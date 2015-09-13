<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{

    public function beforeFilter(\Cake\Event\Event $event)
    {
        $this->Auth->allow(['logout']);
    }
    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        if ( ! $this->Auth->user('is_admin')) {
            return $this->redirect(['action' => 'view', $this->Auth->user('id')]);
        }
        $this->set('users', $this->paginate($this->Users));
        $this->set('_serialize', ['users']);
        $this->set('tz', $this->Auth->user('time_zone'));
    }



    public function login()
    {
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                
                $goodUser = $this->Users->get($this->Auth->user('id'));
                
                $this->Users->touch($goodUser, 'Users.afterLogin');
                $this->Users->save($goodUser);

                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error('Your username or password is incorrect.');
        }
    }

    public function logout()
    {
        $this->Flash->success('You are now logged out.');
        return $this->redirect($this->Auth->logout());
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        if ( !$this->Auth->user('is_admin') && $id <> $this->Auth->user('id') ) {
            $this->Flash->error('You may only view and edit your own user record. (Loaded)');
            return $this->redirect(['action' => 'view', $this->Auth->user('id')]);
        }
        $user = $this->Users->get($id, [
            'contain' => ['Messages', 'Payrolls', 'ShowUserPerms']
        ]);
        $this->set('user', $user);
        $this->set('_serialize', ['user']);
        $this->set('tz', $this->Auth->user('time_zone'));
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        if ( ! $this->Auth->user('is_admin')) {
            $this->Flash->error('You may not add users');
            return $this->redirect(['action' => 'view', $this->Auth->user('id')]);
        }
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        if ( ! $this->Auth->user('is_admin') ) {
            if ( $id <> $this->Auth->user('id') ) {
                $this->Flash->error('You may only change your own user record. (Loaded)');    
            }
            return $this->redirect(['action' => 'safeedit', $this->Auth->user('id')]);
        }
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    public function safeedit($id = null)
    {
        if ( !$this->Auth->user('is_admin') && $id <> $this->Auth->user('id') ) {
            $this->Flash->error('You may edit your own user record. (Loaded)');
            return $this->redirect(['action' => 'safeedit', $this->Auth->user('id')]);
        }
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->data, [
                'fieldlist' => ['first', 'last', 'phone', 'time_zone']
            ]);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    public function changepass($id = null)
    {
        if ( !$this->Auth->user('is_admin') && $id <> $this->Auth->user('id') ) {
            $this->Flash->error('You may only change your own password. (Loaded)');
            return $this->redirect(['action' => 'changepass', $this->Auth->user('id')]);
        }
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->data, ['fieldList' => ['password', 'is_password_expired']]);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        if ( ! $this->Auth->user('is_admin')) {
            $this->Flash->error('You may not delete users');
            return $this->redirect(['action' => 'view', $this->Auth->user('id')]);
        }
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
