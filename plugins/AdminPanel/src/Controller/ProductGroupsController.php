<?php
namespace AdminPanel\Controller;

use AdminPanel\Controller\AppController;
use Cake\Validation\Validator;

/**
 * ProductGroups Controller
 * @property \AdminPanel\Model\Table\ProductGroupsTable $ProductGroups
 *
 * @method \AdminPanel\Model\Entity\ProductGroup[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProductGroupsController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadModel('AdminPanel.Products');
        $this->loadModel('AdminPanel.ProductGroupDetails');
        $this->loadModel('AdminPanel.ProductImages');
        $this->loadModel('AdminPanel.ProductOptionStocks');
    }

    public function validateAjax(){

        if ($this->request->is(['ajax', 'post'])) {
            $response = [];
            $validator = new Validator();

            $validator
                ->requirePresence('name')
                ->notBlank('name', 'Tidak boleh kosong');
            $validator
                ->requirePresence('value')
                ->numeric('value', 'Gunakan format angka')
                ->notBlank('value', 'Tidak boleh kosong');
            $validator
                ->dateTime('date_start')
                ->notBlank('date_start', 'Tidak boleh kosong')
                ->requirePresence('date_start', 'create')
                ->allowEmptyDateTime('date_start', false);
            $validator
                ->dateTime('date_end')
                ->notBlank('date_end', 'Tidak boleh kosong')
                ->requirePresence('date_end', 'create')
                ->allowEmptyDateTime('date_end', false);

            $ProductGroupDetails = new Validator();
            $ProductGroupDetails
                ->requirePresence('produk')
                ->notBlank('produk', 'Produk Harus di pilih');
            $ProductGroupDetails
                ->requirePresence('price_sale')
                ->notBlank('price_sale', 'Tidak boleh kosong')
                ->numeric('price_sale', 'Gunakan format angka');

            $validator->addNestedMany('ProductGroupsDetails', $ProductGroupDetails);

            $error = $validator->errors($this->request->getData());

            if (empty($error)) {
                if(!empty(@$this->request->getData('id'))){
                    $productGroup = $this->ProductGroups->get($this->request->getData('id'));
                }else{
                    $productGroup = $this->ProductGroups->newEntity();
                }

                $productGroup = $this->ProductGroups->patchEntity($productGroup, $this->request->getData());
                if ($this->ProductGroups->save($productGroup)) {
                    $productGroupId = $productGroup->get('id');
                    foreach($this->request->getData('ProductGroupDetails') as $vals){

                        if(!empty(@$vals['idx'])){
                            $productGroupDetails = $this->ProductGroupDetails->get($vals['idx']);
                            $productGroupDetails = $this->ProductGroupDetails->patchEntity($productGroupDetails, [
                                'product_group_id' => $productGroupId,
                                'product_id' => $vals['produk_id'],
                                'price_sale' => $vals['price_sale']
                            ] , ['validate' => false]);
                        }else{
                            $productGroupDetails = $this->ProductGroupDetails->newEntity([
                                'product_group_id' => $productGroupId,
                                'product_id' => $vals['produk_id'],
                                'price_sale' => $vals['price_sale']
                            ] , ['validate' => false]);
                        }
                        $this->ProductGroupDetails->save($productGroupDetails);

                    }
                    $this->Flash->success(__('The Flash sale has been saved.'));
                }
            }

            $response['error'] = $validator->errors($this->request->getData());
            return $this->response->withType('application/json')
                ->withStringBody(json_encode($response));
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
            $data = $this->ProductGroups->find('all')
                ->select();

            if ($query && is_array($query)) {
                if (isset($query['generalSearch'])) {
                    $search = $query['generalSearch'];
                    unset($query['generalSearch']);
                    /**
                        custom field for general search
                        ex : 'Users.email LIKE' => '%' . $search .'%'
                    **/
                    $data->where(['ProductGroups.name LIKE' => '%' . $search .'%']);
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


        $this->set(compact('productGroups'));
    }

    /**
     * View method
     *
     * @param string|null $id Product Group id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->viewBuilder()->setLayout('ajax');
        $productGroup = $this->ProductGroups->get($id, [
            'contain' => ['CustomerBuyGroups', 'ProductGroupDetails']
        ]);

        $this->set('productGroup', $productGroup);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $productGroup = $this->ProductGroups->newEntity();
        if ($this->request->is('post')) {
            $productGroup = $this->ProductGroups->patchEntity($productGroup, $this->request->getData());
            if ($this->ProductGroups->save($productGroup)) {
                $this->Flash->success(__('The product group has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product group could not be saved. Please, try again.'));
        }
        $this->set(compact('productGroup'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Product Group id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $productGroup = $this->ProductGroups->get($id, [
            'contain' => []
        ]);
        $ProductGroupDetail = $this->ProductGroupDetails->find()
            ->where(['ProductGroupDetails.product_group_id' => $id])
            ->select([
                'Products.id',
                'Products.sku',
                'Products.name',
                'Products.price',
                'Products.price_sale',
                'ProductGroupDetails.id',
                'ProductGroupDetails.price_sale',
            ])
            ->contain(['Products'])
            ->all()->toArray();
        foreach($ProductGroupDetail as $k => $vals){
            $ProductGroupDetail[$k]['product']['images'] = $this->ProductImages->getNameImageById($vals['product']['id']);
            $ProductGroupDetail[$k]['product']['stock'] = $this->ProductOptionStocks->sumStock($vals['product']['id']);
        }

        $this->set(compact('productGroup','ProductGroupDetail'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Product Group id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $productGroup = $this->ProductGroups->get($id);
        try {
            if ($this->ProductGroups->delete($productGroup)) {
                $this->Flash->success(__('The product group has been deleted.'));
            } else {
                $this->Flash->error(__('The product group could not be deleted. Please, try again.'));
            }
        } catch (Exception $e) {
            $this->Flash->error(__('The product group could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
