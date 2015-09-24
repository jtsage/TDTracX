<?php
namespace App\Shell;

use Cake\Console\Shell;
use Cake\Datasource\ConnectionManager;
use Cake\Network\Exception\InternalErrorException;
use Cake\I18n\Time;
use Cake\Network\Email\Email;

/**
 * Tdtrac shell command.
 */
class TdtracShell extends Shell
{

    public function getOptionParser()
    {
        $parser = parent::getOptionParser();
        $parser
            ->description('A small set of utilities to streamline administering TDTracX')
            ->addSubcommand('install', [
                'help' => 'Run the install routine'
            ])
            ->addSubcommand('sendunpaid', [
                'help' => 'Send unpaid hours to email on a schedule',
                'parser' => [
                    'description' => 'Send unpaid hours to the specified email, on the specified schedule.',
                    'arguments' => [
                        'email' => [ 'help' => 'E-Mail Address(es) to send to', 'required' => true ],
                        'dayOfWeek' => [ 'help' => 'Day of the week to allow sending on', 'required' => true ],
                        'daysOfPeriod' => [ 'help' => 'Pay period length (i.e. 14 == 2 Weeks)', 'required' => true ],
                        'startDate' => [ 'help' => 'Valid date to calculate period from', 'required' => true ]
                    ],
                    'options' => [
                        'ignoreSchedule' => [ 'short' => 'i', 'boolean' => true, 'help' => 'Ignore schedule, send now', 'default' => false ]
                    ]
                ]
            ])
            ->addSubcommand('adduser', [
                'help' => 'Add a user',
                'parser' => [
                    'description' => 'Add a user to the current system',
                    'arguments' => [
                        'UserName' => [ 'help' => 'The e-mail address of the user', 'required' => true ],
                        'NewPassword' => [ 'help' => 'The new password for the user', 'required' => true ],
                        'FirstName' => [ 'help' => 'The first name of the user', 'required' => true ],
                        'LastName' => [ 'help' => 'The last name of the user', 'required' => true ]
                    ],
                    'options' => [
                        'isAdmin' => [ 'short' => 'a', 'boolean' => true, 'help' => 'This user is an admin', 'default' => false ],
                        'isNotified' => [ 'short' => 'n', 'boolean' => true, 'help' => 'This user is notified', 'default' => false ]
                    ]
                ]
            ])
            ->addSubcommand('resetpass', [
                'help' => 'Reset a user password',
                'parser' => [
                    'description' => 'Reset a user\'s password',
                    'arguments' => [
                        'UserName' => [ 'help' => 'The e-mail address of the user', 'required' => true ],
                        'NewPassword' => [ 'help' => 'The new password for the user', 'required' => true ]
                    ]
                ]
            ])
            ->addSubcommand('unban', [
                'help' => 'Make a user active',
                'parser' => [
                    'description' => 'Mark a user as active, allowing login',
                    'arguments' => [
                        'UserName' => [ 'help' => 'The e-mail address of the user', 'required' => true ],
                    ]
                ]
            ])
            ->addSubcommand('ban', [
                'help' => 'Make a user inactive',
                'parser' => [
                    'description' => 'Mark a user as inactive, preventing login',
                    'arguments' => [
                        'UserName' => [ 'help' => 'The e-mail address of the user', 'required' => true ],
                    ]
                ]
            ])
            ->addSubcommand('demoreset', [
                'help' => 'Reset the database to demo defaults',
                'parser' => [
                    'description' => 'DESTRUCTIVLY reset the database to demo defaults',
                    'arguments' => [
                        'AreYouSure' => [ 'help' => 'Enter YES in all caps to proceed with this operation', 'required' => true ]
                    ],
                    'options' => [
                        'really' => [ 'boolean' => true, 'help' => 'Really run this command', 'default' => false ]
                    ]
                ]
            ]);
        return $parser;
    }
    /**
     * main() method.
     *
     * @return bool|int Success or error code.
     */
    public function main() 
    {
        return $this->out($this->getOptionParser()->help());
    }

    public function resetpass($user, $pass)
    {
        $this->loadModel('Users');

        if ( $thisUser = $this->Users->findByUsername($user)->first() ) {
            $this->out('Changing password for: ' . $thisUser->first . " " . $thisUser->last);
            $thisUser->password = $pass;
            if ( $this->Users->save($thisUser) ) {
                $this->out('New password saved');
            } else {
                $this->out('Unable to update password');
            }
        } else {
            $this->err('User not found');
        }
    }

    public function unban($user)
    {
        $this->loadModel('Users');

        if ( $thisUser = $this->Users->findByUsername($user)->first() ) {
            $this->out('Setting user active: ' . $thisUser->first . " " . $thisUser->last);
            $thisUser->is_active = 1;
            if ( $this->Users->save($thisUser) ) {
                $this->out('User now active');
            } else {
                $this->out('Unable to update user');
            }
        } else {
            $this->err('User not found');
        }
    }

    public function ban($user)
    {
        $this->loadModel('Users');

        if ( $thisUser = $this->Users->findByUsername($user)->first() ) {
            $this->out('Setting user inactive: ' . $thisUser->first . " " . $thisUser->last);
            $thisUser->is_active = 0;
            if ( $this->Users->save($thisUser) ) {
                $this->out('User now inactive');
            } else {
                $this->out('Unable to update user');
            }
        } else {
            $this->err('User not found');
        }
    }

    public function adduser($user, $pass, $first, $last) {
        $this->loadModel('Users');

        $thisUser = $this->Users->newEntity([
            'username' => $user,
            'password' => $pass,
            'first' => $first,
            'last' => $last,
            'is_notified' => ($this->params['isNotified'] ? 1:0 ),
            'is_admin' => ($this->params['isAdmin'] ? 1:0 ),
            'time_zone' => 'America/Detroit'
        ]);

        if ( $this->Users->save($thisUser) ) {
            $this->out('Added user: ' . $thisUser->first . " " . $thisUser->last);
        } else {
            $this->err('Unable to add user');
        }
    }

    public function install() 
    {
        $conn = ConnectionManager::get('default');

        $selection = $this->in('Set up triggers?', ['Y', 'N'], 'Y');

        if ( $selection == 'Y' || $selection == 'y' ) {
            $this->out('Setting up triggers');

            $tiggersql1 = "CREATE TRIGGER `compute_work_ins` BEFORE INSERT ON `payrolls` FOR EACH ROW SET NEW.worked = time_to_sec(timediff(NEW.end_time, NEW.start_time))/(60*60);";
            $tiggersql2 = "CREATE TRIGGER `compute_work_upd` BEFORE UPDATE ON `payrolls` FOR EACH ROW SET NEW.worked = time_to_sec(timediff(NEW.end_time, NEW.start_time))/(60*60);";
            $conn->execute("DROP TRIGGER IF EXISTS `compute_work_upd`");
            $conn->execute("DROP TRIGGER IF EXISTS `compute_work_ins`");
            $conn->execute($tiggersql1);
            $conn->execute($tiggersql2);

            $this->out('Done.' . $this->nl(1));
        } else {
            $this->out('Skipping...' . $this->nl(1));
        }

        $selection = $this->in('Add admin@tdtrac.com::password?', ['Y', 'N'], 'Y');

        if ( $selection == 'Y' || $selection == 'y' ) {
            $this->out('Adding user');
            $this->loadModel('Users');

            $adminUser = $this->Users->newEntity([
                'username' => 'admin@tdtrac.com',
                'password' => 'password',
                'phone' => 1234567890,
                'first' => 'Administrative',
                'last' => 'User',
                'is_notified' => 1,
                'is_admin' => 1,
                'time_zone' => 'America/Detroit'
            ]);
            if ( $this->Users->save($adminUser) ) {
                $this->out('Create: Admin User #' . $adminUser->id  . $this->nl(1));
                $this->out('Please change the password as soon as possible.' . $this->nl(1));
            } else {
                $this->out('Unable to add - duplicate email probably' . $this->nl(1));
            }
            
        } else {
            $this->out('Skipping...' . $this->nl(1));
        }

        $this->out('Nothing else to do.');
    }

    public function demoreset($really)
    {
        if ( $really <> "YES" ) {
            throw new InternalErrorException("Wrong Parameter Supplied, Please Try Again.");
        }

        if ( ! $this->params['really']) {
            throw new InternalErrorException("Wrong Parameter Supplied, Please Try Again.");
        }

        $this->out("<warning>You have really read what this does, and are totally ok with the fact that it is going to nuke all of your data!?!</warning>");
        $selection = $this->in('Nuke it All, Start Over?', ['Y', 'N'], 'N');

        if ( $selection == "Y" ) {
            $conn = ConnectionManager::get('default');

            $this->loadModel('Users');
            $this->loadModel('Shows');
            $this->loadModel('Budgets');
            $this->loadModel('Payrolls');
            $this->loadModel('Messages');
            $this->loadModel('ShowUserPerms');

            $this->out('Removing all records.');

            if ( $this->Payrolls->deleteAll([1 => 1]) ) {
                $this->out(' Delete: Payrolls');
            }
            if ( $this->Budgets->deleteAll([1 => 1]) ) {
                $this->out(' Delete: Budgets');
            }
            if ( $this->ShowUserPerms->deleteAll([1 => 1]) ) {
                $this->out(' Delete: ShowUserPerms');
            }
            if ( $this->Shows->deleteAll([1 => 1]) ) {
                $this->out(' Delete: Shows');
            }
            if ( $this->Messages->deleteAll([1 => 1]) ) {
                $this->out(' Delete: Messages');
            }
            if ( $this->Users->deleteAll([1 => 1]) ) {
                $this->out(' Delete: Users');
            }

            $this->out($this->nl(1) . 'Resetting AUTO_INCREMENT');

            $conn->execute('ALTER TABLE `users` AUTO_INCREMENT = 1');
            $conn->execute('ALTER TABLE `payrolls` AUTO_INCREMENT = 1');
            $conn->execute('ALTER TABLE `budgets` AUTO_INCREMENT = 1');
            $conn->execute('ALTER TABLE `shows` AUTO_INCREMENT = 1');
            $conn->execute('ALTER TABLE `messages` AUTO_INCREMENT = 1');
            $conn->execute('ALTER TABLE `show_user_perms` AUTO_INCREMENT = 1');

            $this->out($this->nl(1) . 'Creating Data:');

            $adminUser = $this->Users->newEntity([
                'username' => 'admin@tdtrac.com',
                'password' => 'password',
                'phone' => 1234567890,
                'first' => 'Administrative',
                'last' => 'User',
                'is_notified' => 1,
                'is_admin' => 1,
                'time_zone' => 'America/Detroit'
            ]);

            $managerUser = $this->Users->newEntity([
                'username' => 'manager@tdtrac.com',
                'password' => 'password',
                'phone' => 1234567890,
                'first' => 'Manager',
                'last' => 'User',
                'is_notified' => 1,
                'time_zone' => 'America/Detroit'
            ]);

            $regularUser = $this->Users->newEntity([
                'username' => 'regular@tdtrac.com',
                'password' => 'password',
                'phone' => 1234567890,
                'first' => 'Regular',
                'last' => 'User',
                'is_notified' => 1,
                'time_zone' => 'America/Detroit'
            ]);

            if ( $this->Users->save($adminUser) ) {
                $this->out(' Create: Admin User #' . $adminUser->id );
            }
            if ( $this->Users->save($managerUser) ) {
                $this->out(' Create: Manager User #' . $managerUser->id );
            }
            if ( $this->Users->save($regularUser) ) {
                $this->out(' Create: Regular User #' . $regularUser->id );
            }

            $show1 = $this->Shows->newEntity([
                'name' => 'Example Show #1',
                'location' => 'Somewhere',
                'end_date' => Time::createFromFormat('Y-m-d', '2020-02-14', 'UTC'),
            ]);

            $show2 = $this->Shows->newEntity([
                'name' => 'Example Show #2',
                'location' => 'Somewhere',
                'end_date' => Time::createFromFormat('Y-m-d', '2010-02-14', 'UTC'),
                'is_active' => 0
            ]);

            if ( $this->Shows->save($show1) ) {
                $this->out(' Create: Open Show - #' . $show1->id );
            }
            if ( $this->Shows->save($show2) ) {
                $this->out(' Create: Closed Show - #' . $show2->id );
            }

            $this->out(' Creating Permissions');

            $insertCol = [ "user_id", "show_id", "is_pay_admin", "is_paid", "is_budget" ];
            
            $insertRow = [
                [ 
                    'user_id' => $adminUser->id,
                    'show_id' => $show1->id,
                    'is_pay_admin' => 1,
                    'is_paid' => 1,
                    'is_budget' => 1
                ],
                [ 
                    'user_id' => $adminUser->id,
                    'show_id' => $show2->id,
                    'is_pay_admin' => 1,
                    'is_paid' => 1,
                    'is_budget' => 1
                ],
                [ 
                    'user_id' => $managerUser->id,
                    'show_id' => $show1->id,
                    'is_pay_admin' => 1,
                    'is_paid' => 1,
                    'is_budget' => 1
                ],
                [ 
                    'user_id' => $managerUser->id,
                    'show_id' => $show2->id,
                    'is_pay_admin' => 1,
                    'is_paid' => 1,
                    'is_budget' => 1
                ],
                [ 
                    'user_id' => $regularUser->id,
                    'show_id' => $show1->id,
                    'is_pay_admin' => 0,
                    'is_paid' => 1,
                    'is_budget' => 0
                ],
                [ 
                    'user_id' => $regularUser->id,
                    'show_id' => $show2->id,
                    'is_pay_admin' => 0,
                    'is_paid' => 1,
                    'is_budget' => 0
                ],
            ];

            $insertQuery = $this->ShowUserPerms->query();

            $insertQuery->insert($insertCol);
            $insertQuery->clause('values')->values($insertRow);
            $insertQuery->execute();


            $this->out(' Creating Budget Items');

            $insertCol = [ "show_id", "category", "vendor", "price", "description", "date" ];
            
            $insertRow = [
                [ 
                    'show_id' => $show1->id,
                    'category' => 'Category #1',
                    'vendor' => 'Random Vendor #' . rand(12,365),
                    'price' => (rand(2234, 355433) / 100),
                    'description' => 'Random Description #' . rand(12,365),
                    'date' => Time::createFromFormat('Y-m-d', '2010-02-'.rand(10,28), 'UTC')
                ],
                [ 
                    'show_id' => $show1->id,
                    'category' => 'Category #1',
                    'vendor' => 'Random Vendor #' . rand(12,365),
                    'price' => (rand(2234, 355433) / 100),
                    'description' => 'Random Description #' . rand(12,365),
                    'date' => Time::createFromFormat('Y-m-d', '2010-02-'.rand(10,28), 'UTC')
                ],
                [ 
                    'show_id' => $show1->id,
                    'category' => 'Category #1',
                    'vendor' => 'Random Vendor #' . rand(12,365),
                    'price' => (rand(2234, 355433) / 100),
                    'description' => 'Random Description #' . rand(12,365),
                    'date' => Time::createFromFormat('Y-m-d', '2010-02-'.rand(10,28), 'UTC')
                ],
                [ 
                    'show_id' => $show1->id,
                    'category' => 'Category #1',
                    'vendor' => 'Random Vendor #' . rand(12,365),
                    'price' => (rand(2234, 355433) / 100),
                    'description' => 'Random Description #' . rand(12,365),
                    'date' => Time::createFromFormat('Y-m-d', '2010-02-'.rand(10,28), 'UTC')
                ],
                [ 
                    'show_id' => $show1->id,
                    'category' => 'Category #2',
                    'vendor' => 'Random Vendor #' . rand(12,365),
                    'price' => (rand(2234, 355433) / 100),
                    'description' => 'Random Description #' . rand(12,365),
                    'date' => Time::createFromFormat('Y-m-d', '2010-02-'.rand(10,28), 'UTC')
                ],
                [ 
                    'show_id' => $show1->id,
                    'category' => 'Category #2',
                    'vendor' => 'Random Vendor #' . rand(12,365),
                    'price' => (rand(2234, 355433) / 100),
                    'description' => 'Random Description #' . rand(12,365),
                    'date' => Time::createFromFormat('Y-m-d', '2010-02-'.rand(10,28), 'UTC')
                ],
                [ 
                    'show_id' => $show1->id,
                    'category' => 'Category #2',
                    'vendor' => 'Random Vendor #' . rand(12,365),
                    'price' => (rand(2234, 355433) / 100),
                    'description' => 'Random Description #' . rand(12,365),
                    'date' => Time::createFromFormat('Y-m-d', '2010-02-'.rand(10,28), 'UTC')
                ],
            ];

            $insertQuery = $this->Budgets->query();

            $insertQuery->insert($insertCol);
            $insertQuery->clause('values')->values($insertRow);
            $insertQuery->execute();

            $this->out(' Creating Payroll Items');

            $insertCol = [ "show_id", "user_id", "is_paid", "notes", "start_time", "end_time", "date_worked" ];
            
            $mins = ['00', '15', '30', '45'];
            $insertRow = [
                [ 
                    'show_id' => $show1->id,
                    'user_id' => $regularUser->id,
                    'is_paid' => 0,
                    'notes' => 'Random Note #' . rand(12,365),
                    'start_time' => Time::createFromFormat('H:i',rand(8,11) . ":" . $mins[rand(0,3)],'UTC'),
                    'end_time' => Time::createFromFormat('H:i',rand(13,17) . ":" . $mins[rand(0,3)],'UTC'),
                    'date_worked' => Time::createFromFormat('Y-m-d', '2010-02-'.rand(10,28), 'UTC')
                ],
                [ 
                    'show_id' => $show1->id,
                    'user_id' => $regularUser->id,
                    'is_paid' => 0,
                    'notes' => 'Random Note #' . rand(12,365),
                    'start_time' => Time::createFromFormat('H:i',rand(8,11) . ":" . $mins[rand(0,3)],'UTC'),
                    'end_time' => Time::createFromFormat('H:i',rand(13,17) . ":" . $mins[rand(0,3)],'UTC'),
                    'date_worked' => Time::createFromFormat('Y-m-d', '2010-02-'.rand(10,28), 'UTC')
                ],
                [ 
                    'show_id' => $show1->id,
                    'user_id' => $regularUser->id,
                    'is_paid' => 0,
                    'notes' => 'Random Note #' . rand(12,365),
                    'start_time' => Time::createFromFormat('H:i',rand(8,11) . ":" . $mins[rand(0,3)],'UTC'),
                    'end_time' => Time::createFromFormat('H:i',rand(13,17) . ":" . $mins[rand(0,3)],'UTC'),
                    'date_worked' => Time::createFromFormat('Y-m-d', '2010-02-'.rand(10,28), 'UTC')
                ],
                [ 
                    'show_id' => $show1->id,
                    'user_id' => $regularUser->id,
                    'is_paid' => 0,
                    'notes' => 'Random Note #' . rand(12,365),
                    'start_time' => Time::createFromFormat('H:i',rand(8,11) . ":" . $mins[rand(0,3)],'UTC'),
                    'end_time' => Time::createFromFormat('H:i',rand(13,17) . ":" . $mins[rand(0,3)],'UTC'),
                    'date_worked' => Time::createFromFormat('Y-m-d', '2010-02-'.rand(10,28), 'UTC')
                ],
                [ 
                    'show_id' => $show1->id,
                    'user_id' => $managerUser->id,
                    'is_paid' => 0,
                    'notes' => 'Random Note #' . rand(12,365),
                    'start_time' => Time::createFromFormat('H:i',rand(8,11) . ":" . $mins[rand(0,3)],'UTC'),
                    'end_time' => Time::createFromFormat('H:i',rand(13,17) . ":" . $mins[rand(0,3)],'UTC'),
                    'date_worked' => Time::createFromFormat('Y-m-d', '2010-02-'.rand(10,28), 'UTC')
                ],
                [ 
                    'show_id' => $show1->id,
                    'user_id' => $managerUser->id,
                    'is_paid' => 0,
                    'notes' => 'Random Note #' . rand(12,365),
                    'start_time' => Time::createFromFormat('H:i',rand(8,11) . ":" . $mins[rand(0,3)],'UTC'),
                    'end_time' => Time::createFromFormat('H:i',rand(13,17) . ":" . $mins[rand(0,3)],'UTC'),
                    'date_worked' => Time::createFromFormat('Y-m-d', '2010-02-'.rand(10,28), 'UTC')
                ],
                [ 
                    'show_id' => $show1->id,
                    'user_id' => $managerUser->id,
                    'is_paid' => 0,
                    'notes' => 'Random Note #' . rand(12,365),
                    'start_time' => Time::createFromFormat('H:i',rand(8,11) . ":" . $mins[rand(0,3)],'UTC'),
                    'end_time' => Time::createFromFormat('H:i',rand(13,17) . ":" . $mins[rand(0,3)],'UTC'),
                    'date_worked' => Time::createFromFormat('Y-m-d', '2010-02-'.rand(10,28), 'UTC')
                ],
                [ 
                    'show_id' => $show1->id,
                    'user_id' => $adminUser->id,
                    'is_paid' => 0,
                    'notes' => 'Random Note #' . rand(12,365),
                    'start_time' => Time::createFromFormat('H:i',rand(8,11) . ":" . $mins[rand(0,3)],'UTC'),
                    'end_time' => Time::createFromFormat('H:i',rand(13,17) . ":" . $mins[rand(0,3)],'UTC'),
                    'date_worked' => Time::createFromFormat('Y-m-d', '2010-02-'.rand(10,28), 'UTC')
                ],
                [ 
                    'show_id' => $show1->id,
                    'user_id' => $adminUser->id,
                    'is_paid' => 0,
                    'notes' => 'Random Note #' . rand(12,365),
                    'start_time' => Time::createFromFormat('H:i',rand(8,11) . ":" . $mins[rand(0,3)],'UTC'),
                    'end_time' => Time::createFromFormat('H:i',rand(13,17) . ":" . $mins[rand(0,3)],'UTC'),
                    'date_worked' => Time::createFromFormat('Y-m-d', '2010-02-'.rand(10,28), 'UTC')
                ],
                
            ];

            $insertQuery = $this->Payrolls->query();

            $insertQuery->insert($insertCol);
            $insertQuery->clause('values')->values($insertRow);
            $insertQuery->execute();

            $this->out($this->nl(1) . 'Resetting Sessions');

            $conn->execute('DELETE FROM `sessions` WHERE 1');

            $this->out($this->nl(1) . 'Finished!');
        } else {
            $this->err('Execution Stopped');
        }
    }

    public function sendunpaid($sendto, $dayOfWeek, $daysOfPeriod, $startDate)
    {
        if ( !$this->params['ignoreSchedule'] ) {
            $today = Time::now();
            $today->hour(0)->minute(0)->second(0);

            $start = Time::createFromFormat('Y-m-d', $startDate,'UTC');

            if ( $today->dayOfWeek <> $dayOfWeek) {
                $this->out('Wrong Day');
                exit(1);
            }

            $daysSince = $today->diffInDays($start) + 1;

            if ( $daysSince % $daysOfPeriod > 0) {
                $this->out('Wrong Period');
                exit(1);
            }
        }

        $this->loadModel('Payrolls');
        $unpaid = $this->Payrolls->find()
            ->contain(['Shows', 'Users'])
            ->select([
                'id', 'date_worked', 'start_time', 'end_time', 'worked', 'is_paid', 'notes', 
                'showname' => 'Shows.name',
                'fullname' => 'concat(Users.first, " ", Users.last)',
                'activeshow' => 'Shows.is_active',
                'Shows.end_date'
            ])
            ->where(['is_paid' => 0])
            ->where(['Shows.is_active' => 1])
            ->order(['Users.last' => 'ASC', 'Users.first' => 'ASC', 'Shows.end_date' => 'DESC', 'date_worked' => 'DESC', 'start_time' => 'DESC']);

        $datatable = [];
        $lastuser = "";
        $subtotal = 0;

        foreach ( $unpaid as $item ) {
            if ( $item->fullname <> $lastuser ) {
                if ( $subtotal > 0 ) {
                    $datatable[] = [ $lastuser, '', 'Subtotal', '', '', '', number_format($subtotal,2) ];
                    $subtotal = 0;
                }
                $lastuser = $item->fullname;
                
            }
            $subtotal = $subtotal + $item->worked;
            $datatable[] = [
                $item->fullname,
                $item->showname,
                $item->notes,
                $item->date_worked->i18nFormat('YYYY-MM-dd', 'UTC'),
                $item->start_time->i18nFormat('H:mm', 'UTC'),
                $item->end_time->i18nFormat('H:mm', 'UTC'),
                number_format($item->worked, 2),
            ];
        }
        if ( $subtotal > 0 ) {
            $datatable[] = [ $lastuser, '', 'Subtotal', '', '', '', number_format($subtotal,2) ];
        }

        $headers = ['User Name', 'Show Name', 'Notes', 'Date Worked', 'Start Time', 'End Time', 'Hours Worked'];

        $email = new Email();
        $email->transport('default');
        $email->helpers(['Html', 'Gourmet/Email.Email']);
        $email->emailFormat('both');
        $email->to($sendto);
        $email->subject('Unpaid Hours - ' . date('Y-m-d'));
        $email->from('tdtracx@tdtrac.com');
        $email->template('unpaid');
        $email->viewVars(['headers' => $headers, 'tabledata' => $datatable]);
        $email->send();
        
        $this->out('E-Mail Sent.');

    }
}
