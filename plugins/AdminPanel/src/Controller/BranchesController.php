<?php
namespace AdminPanel\Controller;

use AdminPanel\Controller\AppController;

/**
 * Branches Controller
 * @property \AdminPanel\Model\Table\BranchesTable $Branches
 * @property \AdminPanel\Model\Table\CitiesTable $Cities
 * @property \AdminPanel\Model\Table\SubdistrictsTable $Subdistricts
 *
 * @method \AdminPanel\Model\Entity\Branch[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BranchesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('AdminPanel.Cities');
        $this->loadModel('AdminPanel.Subdistricts');
    }

    public function index()
    {


        if ($this->request->is('ajax')) {
            $this->viewBuilder()->setLayout('ajax');

            $pagination = $this->request->getData('pagination');
            $sort = $this->request->getData('sort');
            $query = $this->request->getData('query');

            /** custom default query : select, where, contain, etc. **/
            $data = $this->Branches->find('all')
                ->select();
            $data->contain(['Provinces', 'Cities', 'Subdistricts']);

            if ($query && is_array($query)) {
                if (isset($query['generalSearch'])) {
                    $search = $query['generalSearch'];
                    unset($query['generalSearch']);
                    /**
                        custom field for general search
                        ex : 'Users.email LIKE' => '%' . $search .'%'
                    **/
                    $data->where(['Branches.name LIKE' => '%' . $search .'%']);
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


        $this->set(compact('branches'));
    }

    /**
     * View method
     *
     * @param string|null $id Branch id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->viewBuilder()->setLayout('ajax');
        $branch = $this->Branches->get($id, [
            'contain' => ['Provinces', 'Cities', 'Subdistricts', 'OrderDetails', 'ProductBranches', 'ProductOptionValues', 'ProductStockMutations', 'Users']
        ]);

        $this->set('branch', $branch);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $branch = $this->Branches->newEntity();
        if ($this->request->is('post')) {
            $branch = $this->Branches->patchEntity($branch, $this->request->getData());
            if ($this->Branches->save($branch)) {
                $this->Flash->success(__('The branch has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The branch could not be saved. Please, try again.'));
        }
        $provinces = $this->Branches->Provinces->find('list', ['limit' => 200]);
        $cities = $this->Branches->Cities->find('list', ['limit' => 200])->toArray();
        $subdistricts = $this->Branches->Subdistricts->find('list', ['limit' => 200])->toArray();
        $this->set(compact('branch', 'provinces', 'cities', 'subdistricts'));
    }

    public function getCities(){
        if ($this->request->is('ajax')) {
            $this->viewBuilder()->setLayout('ajax');
            $options = $this->Cities->find('list', [
                    'keyField' => 'id',
                    'valueField' => function (\AdminPanel\Model\Entity\City $city) {
                        return $city->get('type') . ' ' . $city->get('name');
                    }
                ])
                ->where(['province_id' => $this->request->getData('province')])
                ->toArray();
            return $this->response->withType('application/json')
                ->withStringBody(json_encode($options));


        }

    }
    public function getDistricts(){
        if ($this->request->is('ajax')) {
            $this->viewBuilder()->setLayout('ajax');
            $options = $this->Subdistricts->find('list', [
                    'keyField' => 'id',
                    'valueField' => 'name'
                ])
                ->where(['city_id' => $this->request->getData('city')])
                ->toArray();
            return $this->response->withType('application/json')
                ->withStringBody(json_encode($options));
        }

    }
    /**
     * Edit method
     *
     * @param string|null $id Branch id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $branch = $this->Branches->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $branch = $this->Branches->patchEntity($branch, $this->request->getData());
            if ($this->Branches->save($branch)) {
                $this->Flash->success(__('The branch has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The branch could not be saved. Please, try again.'));
        }
        $provinces = $this->Branches->Provinces->find('list');
        $cities = $this->Branches->Cities->find('list')->toArray();
        $subdistricts = $this->Branches->Subdistricts->find('list')
            ->where([
                'city_id' => $branch->city_id
            ])->toArray();
        $this->set(compact('branch', 'provinces', 'cities', 'subdistricts'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Branch id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $branch = $this->Branches->get($id);
        try {
            if ($this->Branches->delete($branch)) {
                $this->Flash->success(__('The branch has been deleted.'));
            } else {
                $this->Flash->error(__('The branch could not be deleted. Please, try again.'));
            }
        } catch (Exception $e) {
            $this->Flash->error(__('The branch could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
