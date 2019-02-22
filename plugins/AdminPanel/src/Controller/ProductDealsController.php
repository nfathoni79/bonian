<?php
namespace AdminPanel\Controller;

use AdminPanel\Controller\AppController;
use Cake\Validation\Validator;
/**
 * ProductDeals Controller
 * @property \AdminPanel\Model\Table\ProductDealsTable $ProductDeals
 * @property \AdminPanel\Model\Table\ProductsTable $Products
 * @property \AdminPanel\Model\Table\ProductDealDetailsTable $ProductDealDetails
 *
 * @method \AdminPanel\Model\Entity\ProductDeal[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProductDealsController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('AdminPanel.Products');
        $this->loadModel('AdminPanel.ProductDealDetails');
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
            $data = $this->ProductDeals->find('all')
                ->select();

            if ($query && is_array($query)) {
                if (isset($query['generalSearch'])) {
                    $search = $query['generalSearch'];
                    unset($query['generalSearch']);
                    /**
                    custom field for general search
                    ex : 'Users.email LIKE' => '%' . $search .'%'
                     **/
                    $data->where(['ProductDeals.name LIKE' => '%' . $search .'%']);
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


        $this->set(compact('productDeals'));
    }

    /**
     * View method
     *
     * @param string|null $id Product Deal id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->viewBuilder()->setLayout('ajax');
        $productDeal = $this->ProductDeals->get($id, [
            'contain' => ['ProductDealDetails']
        ]);

        $this->set('productDeal', $productDeal);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function validateAjax(){

        if ($this->request->is(['ajax', 'post'])) {
            $response = [];
            $validator = new Validator();

            $validator
                ->requirePresence('name')
                ->notBlank('name', 'Tidak boleh kosong');
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

            $ProductDealDetails = new Validator();
            $ProductDealDetails
                ->requirePresence('produk')
                ->notBlank('produk', 'Produk Harus di pilih');
            $ProductDealDetails
                ->requirePresence('price_sale')
                ->notBlank('price_sale', 'Tidak boleh kosong')
                ->numeric('price_sale', 'Gunakan format angka');

            $validator->addNestedMany('ProductDealDetails', $ProductDealDetails);

            $error = $validator->errors($this->request->getData());

            if (empty($error)) {

                $productDeal = $this->ProductDeals->newEntity();
                $productDeal = $this->ProductDeals->patchEntity($productDeal, $this->request->getData());
                if ($this->ProductDeals->save($productDeal)) {
                    $productDealId = $productDeal->get('id');
                    foreach($this->request->getData('ProductDealDetails') as $vals){

                        $productDealDetails = $this->ProductDealDetails->newEntity([
                            'product_deal_id' => $productDealId,
                            'product_id' => $vals['produk_id'],
                            'price_sale' => $vals['price_sale']
                        ] , ['validate' => false]);
                        $this->ProductDealDetails->save($productDealDetails);

                    }
                    $this->Flash->success(__('The product deal has been saved.'));
                }
            }

            $response['error'] = $validator->errors($this->request->getData());
            return $this->response->withType('application/json')
                ->withStringBody(json_encode($response));
        }
    }

    public function add()
    {
        $productDeal = $this->ProductDeals->newEntity();
//        if ($this->request->is('post')) {
//            $productDeal = $this->ProductDeals->patchEntity($productDeal, $this->request->getData());
//            if ($this->ProductDeals->save($productDeal)) {
//                $this->Flash->success(__('The product deal has been saved.'));
//
//                return $this->redirect(['action' => 'index']);
//            }
//            $this->Flash->error(__('The product deal could not be saved. Please, try again.'));
//        }
        $this->set(compact('productDeal'));

    }

    /**
     * Edit method
     *
     * @param string|null $id Product Deal id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $productDeal = $this->ProductDeals->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $productDeal = $this->ProductDeals->patchEntity($productDeal, $this->request->getData());
            if ($this->ProductDeals->save($productDeal)) {
                $this->Flash->success(__('The product deal has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product deal could not be saved. Please, try again.'));
        }
        $this->set(compact('productDeal'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Product Deal id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $productDeal = $this->ProductDeals->get($id);
        try {
            if ($this->ProductDeals->delete($productDeal)) {
                $this->Flash->success(__('The product deal has been deleted.'));
            } else {
                $this->Flash->error(__('The product deal could not be deleted. Please, try again.'));
            }
        } catch (Exception $e) {
            $this->Flash->error(__('The product deal could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }


    public function productExist(){

        if ($this->request->is('ajax')) {
            $this->viewBuilder()->setLayout('ajax');
            $options = $this->Products->find('all')
                ->select(['sku','name'])
                ->toArray();
            $opt = [];
            foreach($options as $k => $vals){
                $opt[$k]['sku'] = $vals['sku'];
                $opt[$k]['name'] = $vals['name'];
            }
            return $this->response->withType('application/json')
                ->withStringBody(json_encode($opt));
        }

    }

    public function productDetails(){

        if ($this->request->is('ajax')) {
            $this->viewBuilder()->setLayout('ajax');
            $options = $this->Products->find()
                ->select([
                    'Products.id',
                    'Products.sku',
                    'Products.name',
                    'Products.price',
                    'Products.price_discount',
                ])
                ->where(['Products.sku' => $this->request->getData('sku')])
                ->contain(['ProductImages'])
                ->first()
                ->toArray();
            return $this->response->withType('application/json')
                ->withStringBody(json_encode($options));
        }

    }
}
