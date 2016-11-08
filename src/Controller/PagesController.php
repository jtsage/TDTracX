<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController
{

    /**
     * Displays a view
     *
     * @return void|\Cake\Network\Response
     * @throws \Cake\Network\Exception\NotFoundException When the view file could not
     *   be found or \Cake\View\Exception\MissingTemplateException in debug mode.
     */
    public function display()
    {
        $path = func_get_args();

        $count = count($path);
        if (!$count) {
            return $this->redirect('/');
        }
        $page = $subpage = null;

        if (!empty($path[0])) {
            $page = $path[0];
        }
        if (!empty($path[1])) {
            $subpage = $path[1];
        }
        $this->set(compact('page', 'subpage'));

        try {
            $this->render(implode('/', $path));
        } catch (MissingTemplateException $e) {
            if (Configure::read('debug')) {
                throw $e;
            }
            throw new NotFoundException();
        }
    }

    public function dash()
    {
        $this->loadComponent('UserPerm');
        $this->loadComponent('TaskUtil');

        $this->loadModel('Payrolls');
        $this->loadModel('Budgets');
        $this->loadModel('Users');
        $this->loadModel('Shows');
        $this->loadModel('Tasks');

        $shows = $this->Shows->find()
            ->contain([
                'ShowUserPerms' => function ($q) {
                   return $q
                        ->select([
                            'show_id',
                            'paidTotal' => 'sum(is_paid)',
                            'admnTotal' => 'sum(is_pay_admin)',
                            'budgTotal' => 'sum(is_budget)',
                            'taskTotal' => 'sum(is_task_user)',
                            'tadmTotal' => 'sum(is_task_admin)'

                        ])
                        ->group('show_id');
                }
            ])
            ->contain(['ShowUserPerms'])
            ->where(['is_active' => '1'])
            ->order(['Shows.end_date' => 'ASC', 'Shows.id' => 'ASC']);

        $this->set('shows', $shows);
        $this->set('showcnt', $shows->count());

        $user = $this->Users->get($this->Auth->user('id'));
        $this->set('user', $user);

        $usercnt = $this->Users->find()->where(['is_active' => 1])->count();
        $this->set('usercnt', $usercnt);

        $permListAdmn = $this->UserPerm->getAllPerm($this->Auth->user('id'), 'is_pay_admin');
        $permListPaid = $this->UserPerm->getAllPerm($this->Auth->user('id'), 'is_paid');
        $permListBdgt = $this->UserPerm->getAllPerm($this->Auth->user('id'), 'is_budget');
        $permListTadm = $this->UserPerm->getAllPerm($this->Auth->user('id'), 'is_task_admin');
        $permListTask = $this->UserPerm->getAllPerm($this->Auth->user('id'), 'is_task_user');


        $tasksAdm = $this->Shows->find('all')
            ->where(['Shows.is_active' => 1])
            ->where(['id' => $permListTadm], ['id' => 'integer[]'])
            ->order(['end_date' => 'ASC']);

        $tasksUser = $this->Shows->find('all')
            ->where(['Shows.is_active' => 1])
            ->where(['id' => $permListTask], ['id' => 'integer[]'])
            ->order(['end_date' => 'ASC']);

        $this->set('tasksAdm', $tasksAdm);
        $this->set('tasksUser', $tasksUser);
        $this->set('showtask', $this->TaskUtil->getAllCounts($this->Auth->user('id')));

        $payrollAdmShows = $this->Payrolls->find()
            ->contain(['Shows'])
            ->select([
                 'showName' => 'Shows.name',
                 'workTotal' => 'sum(Payrolls.worked)',
                 'show_id' 
            ])
            ->where(['Shows.is_active' => 1])
            ->where(['show_id IN' => $permListAdmn])
            ->group('show_id')
            ->order(['Shows.end_date' => 'ASC', 'Shows.id' => 'ASC']);

        $payrollSelfShows = $this->Payrolls->find()
            ->contain(['Shows'])
            ->select([
                 'showName' => 'Shows.name',
                 'workTotal' => 'sum(Payrolls.worked)',
                 'show_id' 
            ])
            ->where(['Shows.is_active' => 1])
            ->where(['show_id IN' => $permListPaid])
            ->where(['user_id' => $this->Auth->user('id')])
            ->group('show_id')
            ->order(['Shows.end_date' => 'ASC', 'Shows.id' => 'ASC']);

        $payrollAdmUsers = $this->Payrolls->find()
            ->contain(['Users', 'Shows'])
            ->select([
                 'fullName' => 'concat(Users.first, " ", Users.last)',
                 'workTotal' => 'sum(Payrolls.worked)',
                 'user_id' 
            ])
            ->where(['Shows.is_active' => 1])
            ->where(['show_id IN' => $permListAdmn])
            ->where(['user_id <>' => $this->Auth->user('id')])
            ->where(['Users.is_active' => 1])
            ->group('user_id')
            ->order(['Shows.end_date' => 'ASC', 'Shows.id' => 'ASC']);

        $budgetAdmin = $this->Budgets->find()
            ->contain(['Shows'])
            ->select([
                 'showName' => 'Shows.name',
                 'priceTotal' => 'sum(price)',
                 'show_id' 
            ])
            ->where(['Shows.is_active' => 1])
            ->where(['show_id IN' => $permListBdgt])
            ->group('show_id')
            ->order(['Shows.end_date' => 'ASC', 'Shows.id' => 'ASC']);

        $this->set('payrollSelfShows', $payrollSelfShows);
        $this->set('payrollAdmShows', $payrollAdmShows);
        $this->set('payrollAdmUsers', $payrollAdmUsers);
        $this->set('budgetAdmin', $budgetAdmin);

        $this->set('crumby', [
            [null, __("Dashboard")]
        ]);

        $this->render('dashboard');
    }
}
