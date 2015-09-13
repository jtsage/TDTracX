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
            'contain' => ['ShowUserPerms' => ['Users']]
        ]);
        $this->set('show', $show);
        $this->set('_serialize', ['show']);
        $this->set('tz', $this->Auth->user('time_zone'));
    }

    public function editperm($id = null)
    {
        
        $this->loadModel('Users');
        $this->loadModel('ShowUserPerms');

        $users = $this->Users->find('all', [
            'conditions' => ['Users.is_active' => 1 ],
            'fields' => ['Users.id', 'Users.last', 'Users.first'],
            'order' => ['Users.last' => 'ASC', 'Users.first' => 'ASC']
        ]);
        $perms = $this->ShowUserPerms->find('all', [
            'conditions' => ['ShowUserPerms.show_id' => $id]
        ]);
        $show = $this->Shows->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $insertCol = [ "user_id", "show_id", "is_pay_admin", "is_paid", "is_budget" ];
            $removeSql = $this->ShowUserPerms->query();
            $removeSql->delete()
                ->where(['show_id' => $id])
                ->execute();

            $insertRow = array();
            foreach ( $this->request->data['users'] as $user ) {
                $insertRow[] = [
                    'user_id' => $user,
                    'show_id' => $id,
                    'is_pay_admin' => ((isset($this->request->data['padmin'][$user]) && $this->request->data['padmin'][$user]) ? 1 : 0 ),
                    'is_paid' => ((isset($this->request->data['paid'][$user]) && $this->request->data['paid'][$user]) ? 1 : 0 ),
                    'is_budget' => ((isset($this->request->data['budget'][$user]) && $this->request->data['budget'][$user]) ? 1 : 0 ),
                ];
            }

            $insertQuery = $this->ShowUserPerms->query();

            $insertQuery->insert($insertCol);
            $insertQuery->clause('values')->values($insertRow);
            $insertQuery->execute();
            
            $this->Flash->success(__('The show has been saved.'));
            return $this->redirect(['action' => 'view', $id]);
            
        }
        $this->set(compact('show'));

        foreach ( $users as $user ) {
            $foundit = false;
            foreach ( $perms as $perm ) {
                if ( $user->id == $perm->user_id ) {
                    $foundit = true;
                    $user['perms'] = array(
                        'is_pay_admin' => $perm->is_pay_admin,
                        'is_budget' => $perm->is_budget,
                        'is_paid' => $perm->is_paid
                    );
                }
            }
            if ( $foundit == false ) {
                $user['perms'] = array(
                    'is_pay_admin' => false,
                    'is_budget' => false,
                    'is_paid' => false
                );
            }
        }

        $this->set('users', $users);

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
