<?php
namespace AdminPanel\Controller;

use AdminPanel\Controller\AppController;
use AdminPanel\Plugin;
use Cake\Database\Expression\QueryExpression;

/**
 * Dashboard Controller
 *
 * @property \AdminPanel\Model\Table\CustomersTable $Customers
 * @property \AdminPanel\Model\Table\ProductDiscussionsTable $ProductDiscussions
 * @method \AdminPanel\Model\Entity\Dashboard[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DashboardController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadModel('AdminPanel.Customers');
        $this->loadModel('AdminPanel.ProductDiscussions');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        //$dashboard = null;

        $month = date('Y-m');
        $nextMonth = date('Y-m', strtotime('+3 months', strtotime($month)));
        $lastMonth = date('Y-m', strtotime('-2 months', strtotime($month)));

//        $customer_android = array();
//        $customer_website = array();
//        $jsonMonth = array();


        $result = [];
        $i = 1;
        while (strtotime($lastMonth) <= strtotime($nextMonth)) {
            $timestamp = strtotime($lastMonth);
            $jsonMonth = date('Y-m', $timestamp);
            $customer_android = $this->Customers->find()
                ->where(['Customers.platforrm' => 'Android', 'MONTH(Customers.created)' => date('m', strtotime($lastMonth))])
                ->count();
            $customer_website = $this->Customers->find()
                ->where(['Customers.platforrm' => 'Web', 'MONTH(Customers.created)' => date('m', strtotime($lastMonth))])
                ->count();
            $lastMonth = date ("Y-m", strtotime("+1 months", strtotime($lastMonth)));

            $result[$i]['y']= $jsonMonth;
            $result[$i]['a']= $customer_android;
            $result[$i]['b']= $customer_website;
            $i++;
        }

        $this->set(compact('result'));
    }

    /**
     * View method
     *
     * @param string|null $id Dashboard id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $dashboard = $this->Dashboard->get($id, [
            'contain' => []
        ]);

        $this->set('dashboard', $dashboard);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $dashboard = $this->Dashboard->newEntity();
        if ($this->request->is('post')) {
            $dashboard = $this->Dashboard->patchEntity($dashboard, $this->request->getData());
            if ($this->Dashboard->save($dashboard)) {
                $this->Flash->success(__('The dashboard has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The dashboard could not be saved. Please, try again.'));
        }
        $this->set(compact('dashboard'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Dashboard id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $dashboard = $this->Dashboard->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $dashboard = $this->Dashboard->patchEntity($dashboard, $this->request->getData());
            if ($this->Dashboard->save($dashboard)) {
                $this->Flash->success(__('The dashboard has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The dashboard could not be saved. Please, try again.'));
        }
        $this->set(compact('dashboard'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Dashboard id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $dashboard = $this->Dashboard->get($id);
        if ($this->Dashboard->delete($dashboard)) {
            $this->Flash->success(__('The dashboard has been deleted.'));
        } else {
            $this->Flash->error(__('The dashboard could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
