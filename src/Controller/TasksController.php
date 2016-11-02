<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;

/**
 * Tasks Controller
 *
 * @property \App\Model\Table\TasksTable $Tasks
 */
class TasksController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('UserPerm');
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {

        $this->loadModel('Shows');

        $permListA = $this->UserPerm->getAllPerm($this->Auth->user('id'), 'is_task_admin');
        $permListU = $this->UserPerm->getAllPerm($this->Auth->user('id'), 'is_task_user');

        $showsA = $this->Shows->find('all')
            ->where(['Shows.is_active' => 1])
            ->where(['id' => $permListA], ['id' => 'integer[]'])
            ->order(['end_date' => 'ASC']);

        $showsU = $this->Shows->find('all')
            ->where(['Shows.is_active' => 1])
            ->where(['id' => $permListU], ['id' => 'integer[]'])
            ->order(['end_date' => 'ASC']);

        $tasktotal = $this->Tasks->find('all')
            ->select([
                'show_id' => 'Tasks.show_id',
                'total' => 'count(id)'
            ])
            ->group('show_id');

        $taskdone = $this->Tasks->find('all')
            ->select([
                'total' => 'count(id)',
                'show_id' => 'Tasks.show_id'
            ])
            ->where(['Tasks.task_done' => 1])
            ->group('show_id');

        $taskacceptnotdone = $this->Tasks->find('all')
            ->where(['Tasks.task_accepted' => 1])
            ->where(['Tasks.task_done' => 0 ])
            ->select([
                'total' => 'count(id)',
                'show_id' => 'Tasks.show_id'
            ])
            ->group('show_id');

        $showtask = [];

        foreach ( $tasktotal as $show ) {
            $showtask['total'] = [$show->show_id => $show->total];
        }
        foreach ( $taskdone as $show ) {
            $showtask['done'] = [$show->show_id => $show->total];
        }
        foreach ( $taskacceptnotdone as $show ) {
            $showtask['accept_notdone'] = [$show->show_id => $show->total];
        }

        $this->set('showtask', $showtask);

        if ( $this->Auth->user('is_admin') ) {
            $inactshows = $this->Shows->find('all')
                ->where(['Shows.is_active' => 0])
                ->where(['id' => $permListA], ['id' => 'integer[]'])
                ->order(['end_date' => 'ASC']);
            $this->set('inactshows', $inactshows);
        } else {
            $this->set('inactshows', []);
        }

        $this->set('crumby', [
            ["/", __("Dashboard")],
            [null, __("Task Lists")]
        ]);

        $this->set('showsA', $showsA);
        $this->set('showsU', $showsU);
        $this->set('tasks', []);
        $this->set('shows', $this->paginate($showsA));
        $this->set('_serialize', ['showsA']);
    }

    /**
     * View method
     *
     * @param string|null $id Task id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $task = $this->Tasks->get($id, [
            'contain' => ['Shows']
        ]);

        $this->set('task', $task);
        $this->set('_serialize', ['task']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add($id = null)
    {
        $this->loadModel('Shows');
        $this->loadModel('ShowUserPerms');

        $show = $this->Shows->findById($id)->first();

        if ( ! $show ) {
            $this->Flash->error(__('Show not found!'));
            return $this->redirect(['action' => 'index']); 
        }

        if ( ! $this->UserPerm->checkShow($this->Auth->user('id'), $id, 'is_task_user') && ! $this->UserPerm->checkShow($this->Auth->user('id'), $id, 'is_task_admin') ) {
            $this->Flash->error(__('You do not have access to this show'));
            return $this->redirect(['action' => 'index']);
        }

        if ( $show->is_active < 1 ) {
            $this->Flash->error(__('Sorry, this show is now closed.'));
            return $this->redirect(['action' => 'index']);   
        }


        $task = $this->Tasks->newEntity();
        if ($this->request->is('post')) {
            $time = Time::createFromFormat(
                 'Y-m-d',
                 $this->request->data['due'],
                 'UTC'
            );
            $this->request->data['due'] = $time;
            $this->request->data['created_by'] = $this->Auth->user('id');
            $task = $this->Tasks->patchEntity($task, $this->request->data);
            if ($this->Tasks->save($task)) {
                $this->Flash->success(__('The task has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The task could not be saved. Please, try again.'));
            }
        }

        $assignee = $this->ShowUserPerms->find('list', ['valueField' => 'fullname', 'keyField' => 'user_id'])
            ->contain(['Users'])
            ->select(['fullname' => 'concat(Users.first, " ", Users.last)', 'ShowUserPerms.user_id'])
            ->where(['Users.is_active' => 1])
            ->where(['is_task_admin' => 1])
            ->where(['show_id' => $id])
            ->group(['user_id'])
            ->order(['Users.last' => 'ASC', 'Users.first' => 'ASC']);

        $catq = $this->Tasks->find()
            ->select(['category'])
            ->distinct(['category'])
            ->order(['category' => 'ASC']);
        $cat = json_encode($catq->extract('category'));

        $this->set('crumby', [
            ["/", __("Dashboard")],
            ["/tasks/", __("Task Lists")],
            ["/tasks/view/" . $show->id, __("{0} Tasks", $show->name)],
            [null, __("Add Task")]
        ]);

        $shows = [$show->id => $show->name];
        $this->set(compact('task', 'shows', 'assignee', 'cat'));
        $this->set('_serialize', ['task']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Task id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $task = $this->Tasks->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $task = $this->Tasks->patchEntity($task, $this->request->data);
            if ($this->Tasks->save($task)) {
                $this->Flash->success(__('The task has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The task could not be saved. Please, try again.'));
            }
        }
        $shows = $this->Tasks->Shows->find('list', ['limit' => 200]);
        $this->set(compact('task', 'shows'));
        $this->set('_serialize', ['task']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Task id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $task = $this->Tasks->get($id);
        if ($this->Tasks->delete($task)) {
            $this->Flash->success(__('The task has been deleted.'));
        } else {
            $this->Flash->error(__('The task could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
