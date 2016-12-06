<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;

/**
 * Calendars Controller
 *
 * @property \App\Model\Table\CalendarsTable $Calendars
 */
class CalendarsController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('UserPerm');
        $this->loadComponent('CalUtil');
    }
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->loadModel('Shows');

        $permList = $this->UserPerm->getAllPerm($this->Auth->user('id'), 'is_cal');

        $shows = $this->Shows->find('all')
            ->where(['Shows.is_active' => 1])
            ->where(['id' => $permList], ['id' => 'integer[]'])
            ->order(['end_date' => 'ASC']);

        if ( $this->Auth->user('is_admin') ) {
            $inactshows = $this->Shows->find('all')
                ->where(['Shows.is_active' => 0])
                ->where(['id' => $permList], ['id' => 'integer[]'])
                ->order(['end_date' => 'ASC']);
            $this->set('inactshows', $inactshows);
        } else {
            $this->set('inactshows', []);
        }

        $this->set('showcal', $this->CalUtil->getAllCounts($this->Auth->user('id')));

        $this->set('crumby', [
            ["/", __("Dashboard")],
            [null, __("Calendars")]
        ]);

        $this->set('calendars', []);
        $this->set('shows', $this->paginate($shows));
        $this->set('_serialize', ['shows']);
    }

    /**
     * View method
     *
     * @param string|null $id Calendar id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null, $year = null, $month = null)
    {

        $this->loadModel('Shows');

        $show = $this->Shows->findById($id)->first();

        if ( ! $show ) {
            $this->Flash->error(__('Show not found!'));
            return $this->redirect(['action' => 'index']); 
        }

        if ( ! $this->UserPerm->checkShow($this->Auth->user('id'), $id, 'is_cal') ) {
            $this->Flash->error(__('You do not have access to this show'));
            return $this->redirect(['action' => 'index']);
        }        

        if ( $show->is_active < 1 ) {
            $this->Flash->error(__('Sorry, this show is now closed.'));
            if ( $this->Auth->user('is_admin') ) {
                $this->set('opsok', false);
            } else {
                return $this->redirect(['action' => 'index']);
            }
        } else {
            $this->set('opsok', true);
        }

        $this->set('show', $show); 

        $moy = ["", __("January"), __("February"), __("March"), __("April"), __("May"), __("June"), __("July"), __("August"), __("September"), __("October"), __("November"), __("December")];

        if ( is_null($year) ) { $year = date('Y'); }
        if ( is_null($month) ) { $month = date('m'); }

        $last_day_num = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $last_day = $year . "-" . str_pad($month, 2, "0", STR_PAD_LEFT) . "-" . $last_day_num;
        $first_day = $year . "-" . str_pad($month, 2, "0", STR_PAD_LEFT) . "-01" ;
        $first_day_of_week = date('w', strtotime($first_day));

        $this->set('first_day_of_week', $first_day_of_week);
        $this->set('last_day_num', $last_day_num);
        $this->set('last_day', $last_day);
        $this->set('first_day', $first_day);

        $calendar = $this->Calendars->find('all')
            ->where([ 'Calendars.show_id' => $id ])
            ->where([ 'Calendars.date >=' => Time::createFromFormat('Y-m-d', $first_day, 'UTC') ])
            ->where([ 'Calendars.date <=' => Time::createFromFormat('Y-m-d', $last_day, 'UTC') ])
            ->order([
                'Calendars.date' => 'ASC',
                'Calendars.all_day' => 'DESC',
                'Calendars.start_time' => 'ASC'
            ]);

        $big_event = [];

        for ( $i=1; $i<=$last_day_num; $i++ ) {
            $big_event[$i] = [];
        }

        foreach ( $calendar as $event ) {
            $big_event[$event->date->i18nFormat("M", 'UTC')][] = $event->toArray();
        }

        $this->set('big_event', $big_event);

        $this->set('year', $year);
        $this->set('month', $moy[$month]);

        if ( $month < 12 ) { $next = [ $year, $month+1 ]; } else { $next = [ $year+1, 1]; }
        if ( $month > 1 ) { $prev = [ $year, $month-1 ]; } else { $prev = [$year-1, 12]; }

        $this->set('next', $next);
        $this->set('prev', $prev);
        $this->set('calendar', $calendar);
        $this->set('_serialize', ['calendar']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add($id = null)
    {
        $this->loadModel('Shows');

        $show = $this->Shows->findById($id)->first();

        if ( ! $show ) {
            $this->Flash->error(__('Show not found!'));
            return $this->redirect(['action' => 'index']); 
        }

        if ( ! $this->UserPerm->checkShow($this->Auth->user('id'), $id, 'is_cal') ) {
            $this->Flash->error(__('You do not have access to this show'));
            return $this->redirect(['action' => 'index']);
        }        

        if ( $show->is_active < 1 ) {
            $this->Flash->error(__('Sorry, this show is now closed.'));
            return $this->redirect(['action' => 'index']);   
        }

        $calendar = $this->Calendars->newEntity();
        if ($this->request->is('post')) {

            $time = Time::createFromFormat(
                 'Y-m-d',
                 $this->request->data['date'],
                 'UTC'
            );
            $this->request->data['date'] = $time;
            $d_worked = $time;
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

            $calendar = $this->Calendars->patchEntity($calendar, $this->request->data);
            if ($this->Calendars->save($calendar)) {
                $this->Flash->success(__('The event has been saved.'));

                return $this->redirect(['action' => 'view', $calendar->show_id]);
            } else {
                $this->Flash->error(__('The event could not be saved. Please, try again.'));
            }
        }

        $catq = $this->Calendars->find()
            ->select(['category'])
            ->distinct(['category'])
            ->order(['category' => 'ASC']);
        $cat = json_encode($catq->extract('category'));

        $this->set('crumby', [
            ["/", __("Dashboard")],
            ["/calendars/", __("Calendars")],
            ["/calendars/view/" . $show->id . "/" . date("Y") . "/" . date("m"), __("{0} Calendar", $show->name)],
            [null, __("Add Event")]
        ]);

        $shows = [$show->id => $show->name];
        $this->set(compact('calendar', 'shows', 'cat'));
        $this->set('_serialize', ['calendar']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Calendar id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $calendar = $this->Calendars->get($id);

        $this->loadModel('Shows');

        $show = $this->Shows->findById($calendar->show_id)->first();

        if ( ! $calendar ) {
            $this->Flash->error(__('Event not found!'));
            return $this->redirect(['action' => 'index']); 
        }

        if ( ! $this->UserPerm->checkShow($this->Auth->user('id'), $calendar->show_id, 'is_cal') ) {
            $this->Flash->error(__('You do not have access to this show'));
            return $this->redirect(['action' => 'index']);
        }        

        if ( $show->is_active < 1 ) {
            $this->Flash->error(__('Sorry, this show is now closed.'));
            return $this->redirect(['action' => 'index']);   
        }

        if ($this->request->is(['patch', 'post', 'put'])) {

            $time = Time::createFromFormat(
                 'Y-m-d',
                 $this->request->data['date'],
                 'UTC'
            );
            $this->request->data['date'] = $time;
            $d_worked = $time;
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

            $calendar = $this->Calendars->patchEntity($calendar, $this->request->data);
            if ($this->Calendars->save($calendar)) {
                $this->Flash->success(__('The event has been saved.'));

                return $this->redirect(['action' => 'view', $calendar->show_id]);
            } else {
                $this->Flash->error(__('The event could not be saved. Please, try again.'));
            }
        }

        $catq = $this->Calendars->find()
            ->select(['category'])
            ->distinct(['category'])
            ->order(['category' => 'ASC']);
        $cat = json_encode($catq->extract('category'));

        $this->set('crumby', [
            ["/", __("Dashboard")],
            ["/calendars/", __("Calendars")],
            ["/calendars/view/" . $show->id . "/" . date("Y") . "/" . date("m"), __("{0} Calendar", $show->name)],
            [null, __("Edit Event")]
        ]);

        $shows = [$show->id => $show->name];
        $this->set(compact('calendar', 'shows', 'cat'));
        $this->set('_serialize', ['calendar']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Calendar id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $calendar = $this->Calendars->get($id);
        if ($this->Calendars->delete($calendar)) {
            $this->Flash->success(__('The calendar has been deleted.'));
        } else {
            $this->Flash->error(__('The calendar could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
