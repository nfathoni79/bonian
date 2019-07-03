<?php
namespace AdminPanel\Controller;

use AdminPanel\Controller\AppController;

/**
 * Customers Controller
 * @property \AdminPanel\Model\Table\CustomersTable $Customers
 *
 * @method \AdminPanel\Model\Entity\Customer[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CustomersController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadModel('AdminPanel.Customers');
        $this->loadModel('AdminPanel.Generations');
        $this->loadModel('AdminPanel.CustomerMutationPoints');
        $this->loadModel('AdminPanel.CustomerMutationPointTypes');
        $this->loadModel('AdminPanel.CustomerMutationAmounts');
        $this->loadModel('AdminPanel.CustomerMutationAmountTypes');

    }
    public function balance($id = null){

        if ($this->request->is('ajax')) {

            $this->viewBuilder()->setLayout('ajax');

            $pagination = $this->request->getData('pagination');
            $sort = $this->request->getData('sort');
            $query = $this->request->getData('query');

            /** custom default query : select, where, contain, etc. **/
            $data = $this->CustomerMutationAmounts->find('all')
                ->select([
                    'Customers.id',
                    'Customers.username',
                    'CustomerMutationAmountTypes.name',
                    'CustomerMutationAmountTypes.type',
                    'CustomerMutationAmounts.description',
                    'CustomerMutationAmounts.amount',
                    'CustomerMutationAmounts.balance',
                    'CustomerMutationAmounts.created',
                ]);
            $data->contain(['CustomerMutationAmountTypes','Customers']);

            if(!empty($id)){
                $data->where([
                    'Customers.id' => $id ,
                ]);
            }

            if ($query && is_array($query)) {
                if (isset($query['generalSearch'])) {
                    $search = $query['generalSearch'];
                    unset($query['generalSearch']);
                    /**
                    custom field for general search
                    ex : 'Users.email LIKE' => '%' . $search .'%'
                     **/
                    $data->where([
                        'Customers.username LIKE' => '%' . $search .'%',
                    ]);
                }
                $data->where($query);
            }

            if (isset($sort['field']) && isset($sort['sort'])) {
                $data->order([$sort['field'] => $sort['sort']]);
            }

            if (isset($pagination['perpage']) && is_numeric($pagination['perpage'])) {
                $data->limit($pagination['perpage']);
            }
            if (isset($pagination['page']) && is_numeric($pagination['page'])) {
                $data->page($pagination['page']);
            }

            $total = $data->count();

            $result = [];
            $result['data'] = $data->toArray();


            $result['meta'] = array_merge((array) $pagination, (array) $sort);
            $result['meta']['total'] = $total;


            return $this->response->withType('application/json')
                ->withStringBody(json_encode($result));
        }




    }

    public function point($id = null){

        if ($this->request->is('ajax')) {

            $this->viewBuilder()->setLayout('ajax');

            $pagination = $this->request->getData('pagination');
            $sort = $this->request->getData('sort');
            $query = $this->request->getData('query');

            /** custom default query : select, where, contain, etc. **/
            $data = $this->CustomerMutationPoints->find('all')
                ->select([
                    'Customers.id',
                    'Customers.username',
                    'CustomerMutationPointTypes.name',
                    'CustomerMutationPointTypes.type',
                    'CustomerMutationPoints.description',
                    'CustomerMutationPoints.amount',
                    'CustomerMutationPoints.balance',
                    'CustomerMutationPoints.created',
                ]);
            $data->contain(['CustomerMutationPointTypes','Customers']);

            if(!empty($id)){
                $data->where([
                    'Customers.id' => $id ,
                ]);
            }

            if ($query && is_array($query)) {
                if (isset($query['generalSearch'])) {
                    $search = $query['generalSearch'];
                    unset($query['generalSearch']);
                    /**
                    custom field for general search
                    ex : 'Users.email LIKE' => '%' . $search .'%'
                     **/
                    $data->where([
                        'Customers.username LIKE' => '%' . $search .'%',
                    ]);
                }
                $data->where($query);
            }

            if (isset($sort['field']) && isset($sort['sort'])) {
                $data->order([$sort['field'] => $sort['sort']]);
            }

            if (isset($pagination['perpage']) && is_numeric($pagination['perpage'])) {
                $data->limit($pagination['perpage']);
            }
            if (isset($pagination['page']) && is_numeric($pagination['page'])) {
                $data->page($pagination['page']);
            }

            $total = $data->count();

            $result = [];
            $result['data'] = $data->toArray();


            $result['meta'] = array_merge((array) $pagination, (array) $sort);
            $result['meta']['total'] = $total;


            return $this->response->withType('application/json')
                ->withStringBody(json_encode($result));
        }

    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {


        if ($this->request->is('ajax')) {
            $this->viewBuilder()->setLayout('ajax');

            $pagination = $this->request->getData('pagination');
            $sort = $this->request->getData('sort');
            $query = $this->request->getData('query');

            /** custom default query : select, where, contain, etc. **/
            $data = $this->Customers->find('all')
                ->select();
            $data->contain(['CustomerGroups', 'CustomerStatuses', 'CustomerBalances']);

            if ($query && is_array($query)) {
                if (isset($query['generalSearch'])) {
                    $search = $query['generalSearch'];
                    unset($query['generalSearch']);
                    /**
                        custom field for general search
                        ex : 'Users.email LIKE' => '%' . $search .'%'
                    **/
                    $data->where([
                        'OR' => [
                            'Customers.username LIKE' => '%' . $search .'%',
                            'Customers.email LIKE' => '%' . $search .'%',
                            'Customers.reffcode LIKE' => '%' . $search .'%',
                            'Customers.phone LIKE' => '%' . $search .'%',
                        ]
                    ]);
                }
                $data->where($query);
            }

            if (isset($sort['field']) && isset($sort['sort'])) {
                $data->order([$sort['field'] => $sort['sort']]);
            }

            if (isset($pagination['perpage']) && is_numeric($pagination['perpage'])) {
                $data->limit($pagination['perpage']);
            }
            if (isset($pagination['page']) && is_numeric($pagination['page'])) {
                $data->page($pagination['page']);
            }

            $total = $data->count();

            $result = [];
            $result['data'] = $data->toArray();


            $result['meta'] = array_merge((array) $pagination, (array) $sort);
            $result['meta']['total'] = $total;


            return $this->response->withType('application/json')
            ->withStringBody(json_encode($result));
        }


        $this->set(compact('customers'));
    }


    /**
     * Edit method
     *
     * @param string|null $id Customer id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $customer = $this->Customers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $customer = $this->Customers->patchEntity($customer, $this->request->getData());
            if ($this->Customers->save($customer)) {
                $this->Flash->success(__('The customer has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The customer could not be saved. Please, try again.'));
        }
        $customerGroups = $this->Customers->CustomerGroups->find('list', ['limit' => 200]);
        $customerStatuses = $this->Customers->CustomerStatuses->find('list', ['limit' => 200]);
        $this->set(compact('customer', 'customerGroups', 'customerStatuses'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Customer id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $customer = $this->Customers->get($id);
        try {
            if ($this->Customers->delete($customer)) {
                $this->Flash->success(__('The customer has been deleted.'));
            } else {
                $this->Flash->error(__('The customer could not be deleted. Please, try again.'));
            }
        } catch (Exception $e) {
            $this->Flash->error(__('The customer could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }


    public function network(){

        if ($this->DataTable->isAjax()) {

            $datatable = $this->DataTable->adapterThread('AdminPanel.Generations')
                ->contain([
                    'Customers',
                    'Refferals'
                ])
//                ->search(function ($search, \Cake\Database\Expression\QueryExpression $exp) {
//                    $orConditions = $exp->or_([
//                        'username LIKE' => '%' . $search .'%',
//                    ]);
//                    return $exp
//                        ->add($orConditions);
//                })
            ;

            $result = $datatable
                ->setSorting()
                ->getTable()
                ->toArray();

            //set again datatable
            $datatable->setData($result);
            return $datatable->response();
        }
    }

}
