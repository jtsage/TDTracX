<?php
namespace App\Controller;

use App\Controller\AppController;

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
                ->where(['Shows.is_active' => 1])
                ->where(['id NOT IN' => $permListExclude])
                ->order(['end_date' => 'ASC']);

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
    }

    /**
     * View method
     *
     * @param string|null $id Payroll id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $payroll = $this->Payrolls->get($id, [
            'contain' => ['Users', 'Shows']
        ]);
        $this->set('payroll', $payroll);
        $this->set('_serialize', ['payroll']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $payroll = $this->Payrolls->newEntity();
        if ($this->request->is('post')) {
            $payroll = $this->Payrolls->patchEntity($payroll, $this->request->data);
            if ($this->Payrolls->save($payroll)) {
                $this->Flash->success(__('The payroll has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The payroll could not be saved. Please, try again.'));
            }
        }
        $users = $this->Payrolls->Users->find('list', ['limit' => 200]);
        $shows = $this->Payrolls->Shows->find('list', ['limit' => 200]);
        $this->set(compact('payroll', 'users', 'shows'));
        $this->set('_serialize', ['payroll']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Payroll id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $payroll = $this->Payrolls->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $payroll = $this->Payrolls->patchEntity($payroll, $this->request->data);
            if ($this->Payrolls->save($payroll)) {
                $this->Flash->success(__('The payroll has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The payroll could not be saved. Please, try again.'));
            }
        }
        $users = $this->Payrolls->Users->find('list', ['limit' => 200]);
        $shows = $this->Payrolls->Shows->find('list', ['limit' => 200]);
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
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $payroll = $this->Payrolls->get($id);
        if ($this->Payrolls->delete($payroll)) {
            $this->Flash->success(__('The payroll has been deleted.'));
        } else {
            $this->Flash->error(__('The payroll could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
