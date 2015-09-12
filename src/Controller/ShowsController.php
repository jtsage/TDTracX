<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Shows Controller
 *
 * @property \App\Model\Table\ShowsTable $Shows
 */
class ShowsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('shows', $this->paginate($this->Shows));
        $this->set('_serialize', ['shows']);
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
        $show = $this->Shows->get($id, [
            'contain' => ['Budgets', 'Payrolls', 'ShowUserPerms']
        ]);
        $this->set('show', $show);
        $this->set('_serialize', ['show']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $show = $this->Shows->newEntity();
        if ($this->request->is('post')) {
            $show = $this->Shows->patchEntity($show, $this->request->data);
            if ($this->Shows->save($show)) {
                $this->Flash->success(__('The show has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The show could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('show'));
        $this->set('_serialize', ['show']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Show id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $show = $this->Shows->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $show = $this->Shows->patchEntity($show, $this->request->data);
            if ($this->Shows->save($show)) {
                $this->Flash->success(__('The show has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The show could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('show'));
        $this->set('_serialize', ['show']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Show id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $show = $this->Shows->get($id);
        if ($this->Shows->delete($show)) {
            $this->Flash->success(__('The show has been deleted.'));
        } else {
            $this->Flash->error(__('The show could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
