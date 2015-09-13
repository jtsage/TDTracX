<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Budgets Controller
 *
 * @property \App\Model\Table\BudgetsTable $Budgets
 */
class BudgetsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {

        $this->loadModel('ShowUserPerms');
        $this->loadModel('Shows');

        $perms = $this->ShowUserPerms->find('list', [
            'keyField' => 'id',
            'valueField' => 'show_id',
            'conditions' => ['ShowUserPerms.user_id' => $this->Auth->user('id'), 'ShowUserPerms.is_budget' => 1]
        ]);

        $plist = $perms->toArray();
        
        $shows = $this->Shows->find('all')
            ->where(['Shows.is_active' => 1])
            ->where(['id' => $plist], ['id' => 'integer[]'])
            ->order(['end_date' => 'ASC']);

        $this->paginate = [
            'contain' => ['Shows']
        ];

        $budget = $this->Budgets->find('all')
            ->where(['show_id' => $plist], ['show_id' => 'integer[]'])
            ->select([
                'category' => 'Budgets.category',
                'total' => 'sum(Budgets.price)',
                'show_id' => 'Budgets.show_id'
            ])
            ->group('show_id')
            ->group('category')
            ->order(['category' => 'ASC']);

        $this->set('shows', $shows);
        $this->set('budget', $budget);
        //$this->set('budgets', $this->paginate($this->Budgets));
        $this->set('_serialize', ['budgets']);
    }

    /**
     * View method
     *
     * @param string|null $id Budget id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $budget = $this->Budgets->get($id, [
            'contain' => ['Shows']
        ]);
        $this->set('budget', $budget);
        $this->set('_serialize', ['budget']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $budget = $this->Budgets->newEntity();
        if ($this->request->is('post')) {
            $budget = $this->Budgets->patchEntity($budget, $this->request->data);
            if ($this->Budgets->save($budget)) {
                $this->Flash->success(__('The budget has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The budget could not be saved. Please, try again.'));
            }
        }
        $shows = $this->Budgets->Shows->find('list', ['limit' => 200]);
        $this->set(compact('budget', 'shows'));
        $this->set('_serialize', ['budget']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Budget id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $budget = $this->Budgets->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $budget = $this->Budgets->patchEntity($budget, $this->request->data);
            if ($this->Budgets->save($budget)) {
                $this->Flash->success(__('The budget has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The budget could not be saved. Please, try again.'));
            }
        }
        $shows = $this->Budgets->Shows->find('list', ['limit' => 200]);
        $this->set(compact('budget', 'shows'));
        $this->set('_serialize', ['budget']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Budget id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $budget = $this->Budgets->get($id);
        if ($this->Budgets->delete($budget)) {
            $this->Flash->success(__('The budget has been deleted.'));
        } else {
            $this->Flash->error(__('The budget could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
