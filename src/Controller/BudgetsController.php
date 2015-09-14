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
        $this->set('_serialize', ['budgets']);
    }

    /**
     * View method
     *
     * @param string|null $id Show id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {

        $this->loadModel('ShowUserPerms');
        $this->loadModel('Shows');

        $show = $this->Shows->get($id);

        $perms = $this->ShowUserPerms->find()
            ->where(['ShowUserPerms.user_id' => $this->Auth->user('id')])
            ->where(['ShowUserPerms.show_id' => $id])
            ->select([
                'user_id' => 'ShowUserPerms.user_id',
                'show_id' => 'ShowUserPerms.show_id',
                'access' => 'ShowUserPerms.is_budget'
                ])
            ->first();

        if ( $perms->access < 1 ) {
            $this->Flash->error(__('You do not have access to this show'));
            return $this->redirect(['action' => 'index']);
        }
        if ( $show->is_active < 1 ) {
            $this->Flash->error(__('Sorry, this show is now closed.'));
            return $this->redirect(['action' => 'index']);   
        }

        $budgets = $this->Budgets->find('all')
            ->where(['show_id' => $id])
            ->order(['category' => 'ASC', 'date' => 'ASC']);

        $this->set('show', $show);
        $this->set('budgets', $budgets);
        $this->set('_serialize', ['budget']);
    }

    /**
     * View method - CSV Download
     *
     * @param string|null $id Show id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function viewcsv($id = null)
    {

        $this->loadModel('ShowUserPerms');
        $this->loadModel('Shows');

        $show = $this->Shows->get($id);

        $perms = $this->ShowUserPerms->find()
            ->where(['ShowUserPerms.user_id' => $this->Auth->user('id')])
            ->where(['ShowUserPerms.show_id' => $id])
            ->select([
                'user_id' => 'ShowUserPerms.user_id',
                'show_id' => 'ShowUserPerms.show_id',
                'access' => 'ShowUserPerms.is_budget'
                ])
            ->first();

        if ( $perms->access < 1 ) {
            $this->Flash->error(__('You do not have access to this show'));
            return $this->redirect(['action' => 'index']);
        }
        if ( $show->is_active < 1 ) {
            $this->Flash->error(__('Sorry, this show is now closed.'));
            return $this->redirect(['action' => 'index']);   
        }

        $budgets = $this->Budgets->find('all')
            ->where(['show_id' => $id])
            ->order(['category' => 'ASC', 'date' => 'ASC']);

        $csvdata = [];
        foreach ( $budgets as $item ) {
            $csvdata[] = [
                $item->date,
                $show->name,
                $item->category,
                $item->vendor,
                $item->description,
                $item->price
            ];
        }
        $headers = [];

        $_serialize = 'csvdata';
        $_header = ['Date', 'Show', 'Category', 'Vendor', 'Description', 'Price'];

        $filename = "budget-" . preg_replace("/ /", "_", $show->name) . "-" . date('Ymd') . ".csv";
        $this->response->download($filename);
        $this->viewClass = 'CsvView.Csv';
        $this->set(compact('csvdata', '_serialize', '_header'));
    }

    /**
     * Add method
     *
     * @param string $id Show id.
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add($id = null)
    {
        $this->loadModel('ShowUserPerms');
        $this->loadModel('Shows');

        $show = $this->Shows->get($id);

        $perms = $this->ShowUserPerms->find()
            ->where(['ShowUserPerms.user_id' => $this->Auth->user('id')])
            ->where(['ShowUserPerms.show_id' => $id])
            ->select([
                'user_id' => 'ShowUserPerms.user_id',
                'show_id' => 'ShowUserPerms.show_id',
                'access' => 'ShowUserPerms.is_budget'
                ])
            ->first();

        if ( $perms->access < 1 ) {
            $this->Flash->error(__('You do not have access to this show'));
            return $this->redirect(['action' => 'index']);
        }
        if ( $show->is_active < 1 ) {
            $this->Flash->error(__('Sorry, this show is now closed.'));
            return $this->redirect(['action' => 'index']);   
        }


        $budget = $this->Budgets->newEntity();
        if ($this->request->is('post')) {
            $budget = $this->Budgets->patchEntity($budget, $this->request->data);
            if ($this->Budgets->save($budget)) {
                $this->Flash->success(__('The budget has been saved.'));
                return $this->redirect(['action' => 'view', $id]);
            } else {
                $this->Flash->error(__('The budget could not be saved. Please, try again.'));
            }
        }

        $vendq = $this->Budgets->find()
            ->select(['vendor'])
            ->distinct(['vendor'])
            ->order(['vendor' => 'ASC']);
        $venda = [];
        foreach ( $vendq as $v ) { $venda[] = $v->vendor; }
        $vend = json_encode($venda);

        $catq = $this->Budgets->find()
            ->select(['category'])
            ->distinct(['category'])
            ->order(['category' => 'ASC']);
        $cata = [];
        foreach ( $catq as $c ) { $cata[] = $c->category; }
        $cat = json_encode($cata);

        $shows = [$show->id => $show->name];
        $this->set(compact('budget', 'shows', 'vend', 'cat'));
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

        $this->loadModel('ShowUserPerms');
        $this->loadModel('Shows');

        $show = $this->Shows->get($budget->show_id);

        $perms = $this->ShowUserPerms->find()
            ->where(['ShowUserPerms.user_id' => $this->Auth->user('id')])
            ->where(['ShowUserPerms.show_id' => $budget->show_id])
            ->select([
                'user_id' => 'ShowUserPerms.user_id',
                'show_id' => 'ShowUserPerms.show_id',
                'access' => 'ShowUserPerms.is_budget'
                ])
            ->first();

        if ( $perms->access < 1 ) {
            $this->Flash->error(__('You do not have access to this show'));
            return $this->redirect(['action' => 'index']);
        }
        if ( $show->is_active < 1 ) {
            $this->Flash->error(__('Sorry, this show is now closed.'));
            return $this->redirect(['action' => 'index']);   
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $budget = $this->Budgets->patchEntity($budget, $this->request->data, [
                'fieldList' => ['vendor', 'category', 'description', 'price', 'date']
            ]);
            if ($this->Budgets->save($budget)) {
                $this->Flash->success(__('The budget has been saved.'));
                return $this->redirect(['action' => 'view', $show->id]);
            } else {
                $this->Flash->error(__('The budget could not be saved. Please, try again.'));
            }
        }

        $vendq = $this->Budgets->find()
            ->select(['vendor'])
            ->distinct(['vendor'])
            ->order(['vendor' => 'ASC']);
        $venda = [];
        foreach ( $vendq as $v ) { $venda[] = $v->vendor; }
        $vend = json_encode($venda);

        $catq = $this->Budgets->find()
            ->select(['category'])
            ->distinct(['category'])
            ->order(['category' => 'ASC']);
        $cata = [];
        foreach ( $catq as $c ) { $cata[] = $c->category; }
        $cat = json_encode($cata);

        $shows = [$show->id => $show->name];
        $this->set(compact('budget', 'shows', 'cat', 'vend'));
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

        $this->loadModel('ShowUserPerms');
        $this->loadModel('Shows');

        $show = $this->Shows->get($budget->show_id);

        $perms = $this->ShowUserPerms->find()
            ->where(['ShowUserPerms.user_id' => $this->Auth->user('id')])
            ->where(['ShowUserPerms.show_id' => $budget->show_id])
            ->select([
                'user_id' => 'ShowUserPerms.user_id',
                'show_id' => 'ShowUserPerms.show_id',
                'access' => 'ShowUserPerms.is_budget'
                ])
            ->first();

        if ( $perms->access < 1 ) {
            $this->Flash->error(__('You do not have access to this show'));
            return $this->redirect(['action' => 'index']);
        }
        if ( $show->is_active < 1 ) {
            $this->Flash->error(__('Sorry, this show is now closed.'));
            return $this->redirect(['action' => 'index']);   
        }

        if ($this->Budgets->delete($budget)) {
            $this->Flash->success(__('The budget has been deleted.'));
        } else {
            $this->Flash->error(__('The budget could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'view', $show->id]);
    }
}
