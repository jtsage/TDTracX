<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;

/**
 * Payrolls Controller
 *
 * @property \App\Model\Table\PayrollsTable $Payrolls
 */
class PayrollsController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('UserPerm');
    }

    /**
     * Index by user
     *
     * @return void
    */
    public function indexuser() 
    {
        $auth = false;

        $permListPadmin = $this->UserPerm->getAllPerm($this->Auth->user('id'), 'is_pay_admin');

        $this->set('plist', sizeof($permListPadmin));

        if ( sizeof($permListPadmin) < 1 && !$this->Auth->user('is_admin') ) {
            $this->Flash->error(__('You may not view payroll by user'));
            return $this->redirect(['action' => 'index']);
        }

        $this->loadModel('ShowUserPerms');

        $ulist = $this->ShowUserPerms->find('list', ['valueField' => 'fullname', 'keyField' => 'user_id'])
            ->contain(['Users'])
            ->select(['fullname' => 'concat(Users.first, " ", Users.last)', 'ShowUserPerms.user_id'])
            ->where(['Users.is_active' => 1])
            ->where(['is_paid' => 1])
            ->group(['user_id'])
            ->order(['Users.last' => 'ASC', 'Users.first' => 'ASC']);
        
        if ( !$this->Auth->user('is_admin') ) {
            $ulist->where(['show_id IN' => $permListPadmin]);
        }

        $this->set('ulist', $ulist);

        $buddy = $this->Payrolls->find('all')
            ->where(['user_id IN' => array_keys($ulist->toArray())])
            ->select([
                'user_id' => 'Payrolls.user_id',
                'totalwork' => 'sum(Payrolls.worked)',
                'is_paid' => 'Payrolls.is_paid'
            ])
            ->group('user_id')
            ->group('is_paid')
            ->order(['user_id' => 'ASC']);

        if ( !$this->Auth->user('is_admin') ) {
            $buddy->where(['show_id IN' => $permListPadmin]);
        }
        $this->set('buddy', $buddy);

        $this->set('crumby', [
            ["/", "Home"],
            [null, "User Payroll Lists"]
        ]);

    }
    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->loadModel('Shows');

        $permListPaid = $this->UserPerm->getAllPerm($this->Auth->user('id'), 'is_paid');
        $permListPadmin = $this->UserPerm->getAllPerm($this->Auth->user('id'), 'is_pay_admin');

        $showsPaid = $this->Shows->find('all')
            ->where(['Shows.is_active' => 1])
            ->where(['id' => $permListPaid], ['id' => 'integer[]'])
            ->order(['end_date' => 'ASC']);

        $showsPadmin = $this->Shows->find('all')
            ->where(['Shows.is_active' => 1])
            ->where(['id' => $permListPadmin], ['id' => 'integer[]'])
            ->order(['end_date' => 'ASC']);

        $payPaid = $this->Payrolls->find('all')
            ->where(['show_id' => $permListPaid], ['show_id' => 'integer[]'])
            ->where(['user_id' => $this->Auth->user('id')])
            ->select([
                'show_id' => 'Payrolls.show_id',
                'totalwork' => 'sum(Payrolls.worked)',
                'is_paid' => 'Payrolls.is_paid'
            ])
            ->group('show_id')
            ->group('is_paid')
            ->order(['show_id' => 'ASC']);

        $payPadmin = $this->Payrolls->find('all')
            ->where(['show_id' => $permListPadmin], ['show_id' => 'integer[]'])
            ->select([
                'show_id' => 'Payrolls.show_id',
                'totalwork' => 'sum(Payrolls.worked)',
                'is_paid' => 'Payrolls.is_paid'
            ])
            ->group('show_id')
            ->group('is_paid')
            ->order(['show_id' => 'ASC']);

        if ( $this->Auth->user('is_admin') ) {
            $permListExclude = array_merge($permListPaid, $permListPadmin);

            $showsAdmin = $this->Shows->find('all')
                ->where(['id NOT IN' => $permListExclude])
                ->where(['is_active' => 1])
                ->order(['is_active' => 'DESC', 'end_date' => 'ASC']);

            $payAdmin = $this->Payrolls->find('all')
                ->where(['show_id NOT IN' => $permListExclude])
                ->select([
                    'show_id' => 'Payrolls.show_id',
                    'totalwork' => 'sum(Payrolls.worked)',
                ])
                ->group('show_id')
                ->order(['show_id' => 'ASC']);

            $this->set('showsAdmin', $showsAdmin);
            $this->set('payAdmin', $payAdmin);
        }
            
        $this->set('showsPaid', $showsPaid);
        $this->set('payPaid', $payPaid);

        $this->set('showsPadmin', $showsPadmin);
        $this->set('payPadmin', $payPadmin);

        $this->set('crumby', [
            ["/", "Home"],
            [null, "Show Payroll Lists"]
        ]);
    }

    /**
     * View method - by show - open to all
     *
     * @param string|null $id Show id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function viewbyshow($id = null, $csv = false)
    {
        $this->loadModel('Shows');

        $show = $this->Shows->findById($id)->first();

        if ( ! $show ) {
            $this->Flash->error(__('Show not found!'));
            return $this->redirect(['action' => 'index']); 
        }

        $auth = false;
        if ( $this->UserPerm->checkShow($this->Auth->user('id'), $id, 'is_paid') ) {
            $auth = true;
            $this->set('edit_all', false);
            $userlist = [ $this->Auth->user('id') ];
        }
        if ( $this->UserPerm->checkShow($this->Auth->user('id'), $id, 'is_pay_admin') ) {
            $auth = true;
            $this->set('show_add', true);
            $this->set('edit_all', true);
            $userlist = array_keys($this->UserPerm->getShowPaidUsers($id));
        }
        if ( $this->Auth->user('is_admin') ) {
            $auth = true;
            $this->set('show_add', true);
            $this->set('edit_all', true);
            $userlist = array_keys($this->UserPerm->getShowPaidUsers($id));
        }

        if ( ! $auth ) {
            $this->Flash->error(__('You do not have access to this show'));
            return $this->redirect(['action' => 'index']);
        }

        if ( $show->is_active < 1 && ! $this->Auth->user('is_admin') ) {
            $this->Flash->error(__('Sorry, this show is now closed.'));
            return $this->redirect(['action' => 'index']);   
        }

        $this->set('show', $show);

        $payrolls = $this->Payrolls->find('all')
            ->contain(['Users'])
            ->select([
                'id', 'date_worked', 'start_time', 'end_time', 'worked', 'is_paid', 'notes', 
                'fname' => 'Users.first',
                'lname' => 'Users.last',
                'fullname' => 'concat(Users.first, " ", Users.last)'
            ])
            ->where(['user_id IN' => $userlist])
            ->where(['show_id' => $id])
            ->order(['Users.last' => 'ASC', 'Payrolls.date_worked' => 'DESC', 'Payrolls.start_time' => 'DESC']);

        if ( $this->Auth->user('is_admin') ) {
            $orphans = $this->Payrolls->find('all')
                ->contain(['Users'])
                ->select([
                    'user_id', 
                    'fullname' => 'concat(Users.first, " ", Users.last)'
                ])
                ->where(['user_id NOT IN' => $userlist])
                ->where(['show_id' => $id])
                ->order(['Users.last' => 'ASC', 'Payrolls.date_worked' => 'DESC', 'Payrolls.start_time' => 'DESC']);
            if ( $orphans->count() > 0 ) { $this->set('orphans', $orphans); }
        }

        $this->set('payrolls', $payrolls);

        $this->set('crumby', [
            ["/", "Home"],
            [null, "User Payroll Lists"]
        ]);
        if ( $csv == "csv" ) {
            $csvdata = [];
            foreach ( $payrolls as $item ) {
                $csvdata[] = [
                    $item->date_worked->i18nFormat('EEE, MMM dd, yyyy', 'UTC'),
                    $item->fname,
                    $item->lname,
                    $item->notes,
                    $item->start_time->i18nFormat([\IntlDateFormatter::NONE, \IntlDateFormatter::SHORT], 'UTC'),
                    $item->end_time->i18nFormat([\IntlDateFormatter::NONE, \IntlDateFormatter::SHORT], 'UTC'),
                    $item->worked,
                    (($item->is_paid)? "yes":"NO")
                ];
            }
            $headers = [];

            $_serialize = 'csvdata';
            $_header = ['Date', 'First Name', 'Last Name', 'Note', 'Start Time', 'End Time', 'Hours Worked', 'Is Paid?'];

            $filename = "payroll-" . preg_replace("/ /", "_", $show->name) . "-" . date('Ymd') . ".csv";
            $this->response->download($filename);
            $this->viewClass = 'CsvView.Csv';
            $this->set(compact('csvdata', '_serialize', '_header'));
        } else {
            $this->render('view');
        }
    }

    /**
     * View method - by user - open to admin only
     *
     * @param string|null $id User id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function viewbyuser($id = null, $csv = false)
    {
        $this->loadModel('Users');

        $user = $this->Users->findById($id)->first();

        if ( ! $user ) {
            $this->Flash->error(__('User not found!'));
            return $this->redirect(['action' => 'indexuser']); 
        }

        $permListUser = $this->UserPerm->getAllPerm($id, 'is_paid');
        $permListSelf = $this->UserPerm->getAllPerm($this->Auth->user('id'), 'is_pay_admin');

        $this->set('user', $user);

        $payrolls = $this->Payrolls->find('all')
            ->contain(['Shows'])
            ->select([
                'id', 'date_worked', 'start_time', 'end_time', 'worked', 'is_paid', 'notes', 
                'showname' => 'Shows.name',
                'activeshow' => 'Shows.is_active',
                'Shows.end_date'
            ])
            ->where(['user_id' => $id])
            ->where(['show_id IN' => $permListUser]) // All shows the user is paid in
            ->order(['Shows.is_active' => 'DESC', 'Shows.end_date' => 'ASC', 'Shows.id' => 'DESC', 'Payrolls.date_worked' => 'DESC', 'Payrolls.start_time' => 'DESC']);
            

        if ( !$this->Auth->user('is_admin') ) {
            $payrolls->where(['Shows.is_active' => 1]);
        }

        if ( $id <> $this->Auth->user('id') && !$this->Auth->user('is_admin') ) {
            // Self and admin can see all shows, pay admins see the reduced list
            // they have access to.
            $payrolls->where(['show_id IN' => $permListSelf]);
        }

        if ( $this->Auth->user('is_admin') ) {
            $orphans = $this->Payrolls->find('all')
                ->contain(['Shows'])
                ->select([
                    'show_id',
                    'showname' => 'Shows.name',
                    'activeshow' => 'Shows.is_active'
                ])
                ->where(['user_id' => $id])
                ->where(['show_id NOT IN' => $permListUser])
                ->order(['Shows.is_active' => 'DESC', 'Shows.end_date' => 'ASC', 'Payrolls.date_worked' => 'DESC', 'Payrolls.start_time' => 'DESC']);
            if ( $orphans->count() > 0 ) { $this->set('orphans', $orphans); }
        }

        $this->set('adminView', (!($id <> $this->Auth->user('id')) || $this->Auth->user('is_admin')));
        $this->set('payrolls', $payrolls);

        $this->set('crumby', [
            ["/", "Home"],
            ["/payrolls/indexuser/", "User Payroll Lists"],
            [null, "Payroll for: " . $user->first . " " . $user->last]
        ]);

        if ( $csv == "csv" ) {
            $csvdata = [];
            foreach ( $payrolls as $item ) {
                $csvdata[] = [
                    $item->date_worked->i18nFormat('EEE, MMM dd, yyyy', 'UTC'),
                    $item->showname,
                    $item->show->end_date->i18nFormat('EEE, MMM dd, yyyy', 'UTC'),
                    $item->notes,
                    $item->start_time->i18nFormat([\IntlDateFormatter::NONE, \IntlDateFormatter::SHORT], 'UTC'),
                    $item->end_time->i18nFormat([\IntlDateFormatter::NONE, \IntlDateFormatter::SHORT], 'UTC'),
                    $item->worked,
                    (($item->is_paid)? "yes":"NO")
                ];
            }
            $headers = [];

            $_serialize = 'csvdata';
            $_header = ['Date', 'Show', 'Show End Date', 'Note', 'Start Time', 'End Time', 'Hours Worked', 'Is Paid?'];

            $filename = "payroll-" . preg_replace("/ /", "_", $user->first) . "_" . preg_replace("/ /", "_", $user->last) . "-" . date('Ymd') . ".csv";
            $this->response->download($filename);
            $this->viewClass = 'CsvView.Csv';
            $this->set(compact('csvdata', '_serialize', '_header'));
        }
    }

     /**
     * View method - unpaid by user - open to admin only
     *
     * @param string|null $id User id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function unpaidbyuser($csv = false)
    {
        $permListPaid = $this->UserPerm->getAllPerm($this->Auth->user('id'), 'is_paid');
        $permListAdmn = $this->UserPerm->getAllPerm($this->Auth->user('id'), 'is_pay_admin');

        $payrolls = $this->Payrolls->find('all')
            ->contain(['Shows', 'Users'])
            ->select([
                'id', 'date_worked', 'start_time', 'end_time', 'worked', 'is_paid', 'notes', 
                'showname' => 'Shows.name',
                'fullname' => 'concat(Users.first, " ", Users.last)'
            ])
            ->where(['Shows.is_active' => 1])
            //->order(['Shows.end_date' => 'ASC', 'Shows.id' => 'DESC', 'Payrolls.date_worked' => 'DESC', 'Payrolls.start_time' => 'DESC', 'Users.last' => 'ASC', 'Users.first' => 'ASC']);
            ->order(['Users.last' => 'ASC', 'Users.first' => 'ASC', 'Shows.end_date' => 'ASC', 'Shows.id' => 'DESC', 'Payrolls.date_worked' => 'DESC', 'Payrolls.start_time' => 'DESC']);
            
        if ( empty($permListAdmn) && !$this->Auth->user('is_admin') ) {
            $payrolls->where(['show_id IN' => $permListPaid]);
            $payrolls->where(['user_id' => $this->Auth->user('id')]);
            $this->set('adminView', false);
        } elseif ( !empty($permListAdmn) && !$this->Auth->user('is_admin') ) {
            $payrolls->where(['show_id IN' => $permListAdmn]);
            $this->set('adminView', true);
        } else {
            $this->set('adminView', 2);
        }

        $this->set('payrolls', $payrolls);

        $this->set('crumby', [
            ["/", "Home"],
            ["/payrolls/indexuser/", "User Payroll Lists"],
            [null, "Unpaid by User"]
        ]);

        if ( $csv == "csv" ) {
            $csvdata = [];
            foreach ( $payrolls as $item ) {
                $csvdata[] = [
                    $item->fullname,
                    $item->showname,
                    $item->date_worked->i18nFormat('EEE, MMM dd, yyyy', 'UTC'),
                    $item->notes,
                    $item->start_time->i18nFormat([\IntlDateFormatter::NONE, \IntlDateFormatter::SHORT], 'UTC'),
                    $item->end_time->i18nFormat([\IntlDateFormatter::NONE, \IntlDateFormatter::SHORT], 'UTC'),
                    $item->worked,
                    (($item->is_paid)? "yes":"NO")
                ];
            }
            $headers = [];

            $_serialize = 'csvdata';
            $_header = ['User Name', 'Show', 'Date', 'Note', 'Start Time', 'End Time', 'Hours Worked', 'Is Paid?'];

            $filename = "payroll-unpaid_by_user-" . date('Ymd') . ".csv";
            $this->response->download($filename);
            $this->viewClass = 'CsvView.Csv';
            $this->set(compact('csvdata', '_serialize', '_header'));
        }
    }

    /**
     * Add method - by show
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function addtoshow($id = null)
    {
        $this->loadModel('Shows');

        $show = $this->Shows->findById($id)->first();

        if ( ! $show ) {
            $this->Flash->error(__('Show not found!'));
            return $this->redirect(['action' => 'index']); 
        }

        if ( ! $this->UserPerm->checkShow($this->Auth->user('id'), $id, 'is_pay_admin') ) {
            $this->Flash->error(__('You do not have access to this show'));
            return $this->redirect(['action' => 'index']);
        }

        if ( $show->is_active < 1 ) {
            $this->Flash->error(__('Sorry, this show is now closed.'));
            return $this->redirect(['action' => 'index']);   
        }

        $payroll = $this->Payrolls->newEntity();
        if ($this->request->is('post')) {
            $time = Time::createFromFormat(
                 'Y-m-d',
                 $this->request->data['date_worked'],
                 'UTC'
            );
            $this->request->data['date_worked'] = $time;
            $time = Time::createFromFormat(
                 'H:i',
                 $this->request->data['start_time'],
                 'UTC'
            );
            $this->request->data['start_time'] = $time;
            $time = Time::createFromFormat(
                 'H:i',
                 $this->request->data['end_time'],
                 'UTC'
            );
            $this->request->data['end_time'] = $time;
            if ( ! $this->UserPerm->checkShow($this->request->data['user_id'], $id, 'is_paid') ) {
                $this->Flash->error(__('That user cannot be paid on this show'));
                return $this->redirect(['action' => 'indexuser']);
            }
            $fixed_data = array_merge($this->request->data, ['show_id' => $show->id, 'is_paid' => 0]);
            $payroll = $this->Payrolls->patchEntity($payroll, $fixed_data);
            if ($this->Payrolls->save($payroll)) {
                $this->Flash->success(__('The payroll has been saved.'));
                return $this->redirect(['action' => 'indexuser', $show->id]);
            } else {
                $this->Flash->error(__('The payroll could not be saved. Please, try again.'));
            }
        }

        $users = $this->UserPerm->getShowPaidUsers($id);
        $shows = [$show->id => $show->name];

        $this->set('crumby', [
            ["/", "Home"],
            ["/payrolls/", "Show Payroll Lists"],
            [null, 'Add to show: ' . $show->name ]
        ]);
        $this->set(compact('payroll', 'users', 'shows'));
        $this->set('_serialize', ['payroll']);
        $this->render('add');
    }

    /**
     * Add method - by self
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function addtoself($id = null)
    {
        $this->loadModel('Shows');

        $show = $this->Shows->findById($id)->first();

        if ( ! $show ) {
            $this->Flash->error(__('Show not found!'));
            return $this->redirect(['action' => 'index']); 
        }

        if ( ! $this->UserPerm->checkShow($this->Auth->user('id'), $id, 'is_paid') ) {
            $this->Flash->error(__('You do not have access to this show'));
            return $this->redirect(['action' => 'index']);
        }

        if ( $show->is_active < 1 ) {
            $this->Flash->error(__('Sorry, this show is now closed.'));
            return $this->redirect(['action' => 'index']);   
        }

        $payroll = $this->Payrolls->newEntity();
        if ($this->request->is('post')) {
            $time = Time::createFromFormat(
                 'Y-m-d',
                 $this->request->data['date_worked'],
                 'UTC'
            );
            $this->request->data['date_worked'] = $time;
            $time = Time::createFromFormat(
                 'H:i',
                 $this->request->data['start_time'],
                 'UTC'
            );
            $this->request->data['start_time'] = $time;
            $time = Time::createFromFormat(
                 'H:i',
                 $this->request->data['end_time'],
                 'UTC'
            );
            $this->request->data['end_time'] = $time;
            $fixed_data = array_merge($this->request->data, ['show_id' => $show->id, 'user_id' => $this->Auth->user('id'), 'is_paid' => 0]);
            $payroll = $this->Payrolls->patchEntity($payroll, $fixed_data);
            if ($this->Payrolls->save($payroll)) {
                $this->Flash->success(__('The payroll has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The payroll could not be saved. Please, try again.'));
            }
        }

        $users = [$this->Auth->user('id') => $this->Auth->user('first') . " " . $this->Auth->user('last')];
        $shows = [$show->id => $show->name];
        $this->set('crumby', [
            ["/", "Home"],
            ["/payrolls/", "Show Payroll Lists"],
            [null, 'Add to yourself: ' . $this->Auth->user('first') . " " . $this->Auth->user('last') ]
        ]);
        $this->set(compact('payroll', 'users', 'shows'));
        $this->set('_serialize', ['payroll']);
        $this->render('add');
    }

    /**
     * Add method - by self
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function addtouser($id = null)
    {
        $this->loadModel('Users');
        $this->loadModel('Shows');

        $user = $this->Users->findById($id)->first();

        if ( ! $user ) {
            $this->Flash->error(__('User not found!'));
            return $this->redirect(['action' => 'index']); 
        }

        $permListUser = $this->UserPerm->getAllPerm($id, 'is_paid');
        $permListSelf = $this->UserPerm->getAllPerm($this->Auth->user('id'), 'is_pay_admin');

        $showsValid = $this->Shows->find('list', ['keyField' => 'id', 'valueField' => 'name'])
            ->where(['Shows.is_active' => 1])
            ->where(['id' => $permListUser], ['id' => 'integer[]'])
            ->where(['id' => $permListSelf], ['id' => 'integer[]'])
            ->order(['end_date' => 'ASC']);

        if ( $showsValid->count() < 1 ) {
            $this->Flash->error(__('You are not the payroll admin for any of this user\'s shows'));
            return $this->redirect(['action' => 'indexuser']);
        }

        $payroll = $this->Payrolls->newEntity();
        if ($this->request->is('post')) {
            if ( 
                !$this->UserPerm->checkShow($this->Auth->user('id'), $this->request->data['show_id'], 'is_pay_admin') ||
                !$this->UserPerm->checkShow($id, $this->request->data['show_id'], 'is_paid')
                ) {
                    $this->Flash->error(__('You can not add payroll to that show for that user'));
                    return $this->redirect(['action' => 'indexuser']);
            }
            $time = Time::createFromFormat(
                 'Y-m-d',
                 $this->request->data['date_worked'],
                 'UTC'
            );
            $this->request->data['date_worked'] = $time;
            $time = Time::createFromFormat(
                 'H:i',
                 $this->request->data['start_time'],
                 'UTC'
            );
            $this->request->data['start_time'] = $time;
            $time = Time::createFromFormat(
                 'H:i',
                 $this->request->data['end_time'],
                 'UTC'
            );
            $this->request->data['end_time'] = $time;
            $fixed_data = array_merge($this->request->data, ['user_id' => $user->id, 'is_paid' => 0]);
            $payroll = $this->Payrolls->patchEntity($payroll, $fixed_data);
            if ($this->Payrolls->save($payroll)) {
                $this->Flash->success(__('The payroll has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The payroll could not be saved. Please, try again.'));
            }
        }

        $users = [$user->id => $user->first . " " . $user->last];

        $this->set('crumby', [
            ["/", "Home"],
            ["/payrolls/indexuser", "User Payroll Lists"],
            [null, 'Add to user: ' . $user->first . " " . $user->last ]
        ]);
        $this->set(compact('payroll', 'users', 'shows'));
        $this->set('_serialize', ['payroll']);
        $this->render('add');
    }

    /**
     * Edit method
     *
     * @param string|null $id Payroll id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null, $from = 0)
    {

        $payroll = $this->Payrolls->findById($id)->first();

        if ( ! $payroll ) {
            $this->Flash->error(__('Record not found!'));
            return $this->redirect(['action' => 'index']); 
        }

        if ( $this->Auth->user('is_admin') || $this->UserPerm->checkShow($this->Auth->user('id'), $payroll->show_id, 'is_pay_admin') ) {
            $this->set('isAdmin', true);
            $flist = ['notes', 'date_worked', 'start_time', 'end_time', 'is_paid'];
        } elseif ( $this->Auth->user('id') == $payroll->user_id && (!$payroll->is_paid) ) {
            $this->set('isAdmin', false);
            $flist = ['notes', 'date_worked', 'start_time', 'end_time'];
        } else {
            $this->Flash->error(__('You can not edit this payroll item'));
            if ( $from == 1 ) {
                return $this->redirect(['action' => 'viewbyuser', $payroll->user_id]);
            } else {
                return $this->redirect(['action' => 'viewbyshow', $payroll->show_id]);
            }
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $time = Time::createFromFormat(
                 'Y-m-d',
                 $this->request->data['date_worked'],
                 'UTC'
            );
            $this->request->data['date_worked'] = $time;
            $time = Time::createFromFormat(
                 'H:i',
                 $this->request->data['start_time'],
                 'UTC'
            );
            $this->request->data['start_time'] = $time;
            $time = Time::createFromFormat(
                 'H:i',
                 $this->request->data['end_time'],
                 'UTC'
            );
            $this->request->data['end_time'] = $time;
            $payroll = $this->Payrolls->patchEntity($payroll, $this->request->data, [
                'fieldList' => $flist
            ]);
            if ($this->Payrolls->save($payroll)) {
                $this->Flash->success(__('The payroll has been saved.'));
                if ( $from == 1 ) {
                    return $this->redirect(['action' => 'viewbyuser', $payroll->user_id]);
                } else {
                    return $this->redirect(['action' => 'viewbyshow', $payroll->show_id]);
                }
            } else {
                $this->Flash->error(__('The payroll could not be saved. Please, try again.'));
            }
        }
        
        $this->loadModel('Shows');
        $this->loadModel('Users');
        $show = $this->Shows->findById($payroll->show_id)->first();
        $user = $this->Users->findById($payroll->user_id)->first();

        $users = [$user->id => $user->first . " " . $user->last];
        $shows = [$show->id => $show->name];

        $this->set(compact('payroll', 'users', 'shows'));
        $this->set('_serialize', ['payroll']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Payroll id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null, $from = 0)
    {
        $payroll = $this->Payrolls->findById($id)->first();

        if ( ! $payroll ) {
            $this->Flash->error(__('Record not found!'));
            return $this->redirect(['action' => 'index']); 
        }

        if ( !(
            $this->Auth->user('is_admin') || 
            $this->UserPerm->checkShow($this->Auth->user('id'), $payroll->show_id, 'is_pay_admin') ||
            ( $this->Auth->user('id') == $payroll->user_id && (!$payroll->is_paid) )
         ) ) {
            $this->Flash->error(__('You can delete this payroll item'));
            if ( $from == 1 ) {
                return $this->redirect(['action' => 'viewbyuser', $payroll->user_id]);
            } else {
                return $this->redirect(['action' => 'viewbyshow', $payroll->show_id]);
            }
        }

        $this->request->allowMethod(['post', 'delete']);
        if ($this->Payrolls->delete($payroll)) {
            $this->Flash->success(__('The payroll has been deleted.'));
        } else {
            $this->Flash->error(__('The payroll could not be deleted. Please, try again.'));
        }
        if ( $from == 1 ) {
            return $this->redirect(['action' => 'viewbyuser', $payroll->user_id]);
        } else {
            return $this->redirect(['action' => 'viewbyshow', $payroll->show_id]);
        }
    }

    /**
     * Mark (single) method
     *
     * @param string|null $id Payroll id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function markpaid($id = null, $from = 0)
    {
        $payroll = $this->Payrolls->findById($id)->first();

        if ( ! $payroll ) {
            $this->Flash->error(__('Record not found!'));
            return $this->redirect(['action' => 'index']); 
        }

        if ( !(
            $this->Auth->user('is_admin') || 
            $this->UserPerm->checkShow($this->Auth->user('id'), $payroll->show_id, 'is_pay_admin')
         ) ) {
            $this->Flash->error(__('You cannot mark this payroll item paid'));
            if ( $from == 1 ) {
                return $this->redirect(['action' => 'viewbyuser', $payroll->user_id]);
            } else {
                return $this->redirect(['action' => 'viewbyshow', $payroll->show_id]);
            }
        }

        $this->request->allowMethod(['post']);
        $payroll->is_paid = 1;
        if ($this->Payrolls->save($payroll)) {
            $this->Flash->success(__('The payroll has been marked paid.'));
        } else {
            $this->Flash->error(__('The payroll could not be marked paid. Please, try again.'));
        }
        if ( $from == 1 ) {
            return $this->redirect(['action' => 'viewbyuser', $payroll->user_id]);
        } else {
            return $this->redirect(['action' => 'viewbyshow', $payroll->show_id]);
        }
    }
}
