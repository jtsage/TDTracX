<?php
namespace App\Shell;

use Cake\Console\Shell;
use Cake\Network\Exception\InternalErrorException;
use Cake\I18n\Time;
use Cake\Datasource\ConnectionManager;

/**
 * DemoReset shell command.
 */
class DemoResetShell extends Shell
{

    /**
     * main() method.
     *
     * @return bool|int Success or error code.
     */
    public function main($doit = null) 
    {
    	if ( $doit <> "yesdoit" ) {
    		throw new InternalErrorException("Required parameter missing, read the docs please.");
    	}

    	$conn = ConnectionManager::get('default');

    	$this->loadModel('Users');
    	$this->loadModel('Shows');
    	$this->loadModel('Budgets');
    	$this->loadModel('Payrolls');
    	$this->loadModel('Messages');
    	$this->loadModel('ShowUserPerms');

    	$this->out('Removing all records.');

    	if ( $this->Payrolls->deleteAll([1 => 1]) ) {
    		$this->out('Delete: Payrolls');
    	}
    	if ( $this->Budgets->deleteAll([1 => 1]) ) {
    		$this->out('Delete: Budgets');
    	}
    	if ( $this->ShowUserPerms->deleteAll([1 => 1]) ) {
    		$this->out('Delete: ShowUserPerms');
    	}
    	if ( $this->Shows->deleteAll([1 => 1]) ) {
    		$this->out('Delete: Shows');
    	}
    	if ( $this->Messages->deleteAll([1 => 1]) ) {
    		$this->out('Delete: Messages');
    	}
    	if ( $this->Users->deleteAll([1 => 1]) ) {
    		$this->out('Delete: Users');
    	}

    	$this->out('Resetting AUTO_INCREMENT');

    	$conn->execute('ALTER TABLE `users` AUTO_INCREMENT = 1');
    	$conn->execute('ALTER TABLE `payrolls` AUTO_INCREMENT = 1');
    	$conn->execute('ALTER TABLE `budgets` AUTO_INCREMENT = 1');
    	$conn->execute('ALTER TABLE `shows` AUTO_INCREMENT = 1');
    	$conn->execute('ALTER TABLE `messages` AUTO_INCREMENT = 1');
    	$conn->execute('ALTER TABLE `show_user_perms` AUTO_INCREMENT = 1');

    	$this->out('Creating Users');

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
			$this->out('Create: Admin User #' . $adminUser->id );
		}
		if ( $this->Users->save($managerUser) ) {
			$this->out('Create: Manager User #' . $managerUser->id );
		}
		if ( $this->Users->save($regularUser) ) {
			$this->out('Create: Regular User #' . $regularUser->id );
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
			$this->out('Create: Open Show - #' . $show1->id );
		}
		if ( $this->Shows->save($show2) ) {
			$this->out('Create: Closed Show - #' . $show2->id );
		}

		$this->out('Setting Permissions');

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


        $this->out('Setting Budget Items');

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

        $this->out('Setting Payroll Items');

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

        $this->out('Resetting Sessions');

        $conn->execute('DELETE FROM `sessions` WHERE 1');

        $this->out('Finished!');
    }
		
}
