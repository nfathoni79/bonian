<?php
namespace AdminPanel\Controller;

use AdminPanel\Controller\AppController;
use Cake\Validation\Validator;
/**
 * ProductDeals Controller
 * @property \AdminPanel\Model\Table\ProductDealsTable $ProductDeals
 * @property \AdminPanel\Model\Table\ProductsTable $Products
 * @property \AdminPanel\Model\Table\ProductDealDetailsTable $ProductDealDetails
 * @property \AdminPanel\Model\Table\ProductImagesTable $ProductImages
 * @property \AdminPanel\Model\Table\ProductOptionStocksTable $ProductOptionStocks
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
        $this->loadModel('AdminPanel.ProductImages');
        $this->loadModel('AdminPanel.ProductOptionStocks');
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
                if(!empty(@$this->request->getData('id'))){
                    $productDeal = $this->ProductDeals->get($this->request->getData('id'));
                }else{
                    $productDeal = $this->ProductDeals->newEntity();
                }

                $productDeal = $this->ProductDeals->patchEntity($productDeal, $this->request->getData());
                if ($this->ProductDeals->save($productDeal)) {
                    $productDealId = $productDeal->get('id');
                    foreach($this->request->getData('ProductDealDetails') as $vals){

                        if(!empty(@$vals['idx'])){
                            $productDealDetails = $this->ProductDealDetails->get($vals['idx']);
                            $productDealDetails = $this->ProductDealDetails->patchEntity($productDealDetails, [
                                'product_deal_id' => $productDealId,
                                'product_id' => $vals['produk_id'],
                                'price_sale' => $vals['price_sale']
                            ] , ['validate' => false]);
                        }else{
                            $productDealDetails = $this->ProductDealDetails->newEntity([
                                'product_deal_id' => $productDealId,
                                'product_id' => $vals['produk_id'],
                                'price_sale' => $vals['price_sale']
                            ] , ['validate' => false]);
                        }
                        $this->ProductDealDetails->save($productDealDetails);

                    }
                    $this->Flash->success(__('The Flash sale has been saved.'));
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
        $ProductDealDetail = $this->ProductDealDetails->find()
            ->where(['ProductDealDetails.product_deal_id' => $id])
            ->select([
                'Products.id',
                'Products.sku',
                'Products.name',
                'Products.price',
                'Products.price_sale',
                'ProductDealDetails.id',
                'ProductDealDetails.price_sale',
            ])
            ->contain(['Products'])
            ->all()->toArray();
        foreach($ProductDealDetail as $k => $vals){
            $ProductDealDetail[$k]['product']['images'] = $this->ProductImages->getNameImageById($vals['product']['id']);
            $ProductDealDetail[$k]['product']['stock'] = $this->ProductOptionStocks->sumStock($vals['product']['id']);
        }

        $this->set(compact('productDeal','ProductDealDetail'));
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

    /**
     * Delete Detail method
     *
     * @param string|null $id Product Deal id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function deleteDetail()
    {
        if ($this->request->is('ajax')) {
            $this->viewBuilder()->setLayout('ajax');
            $productDeal = $this->ProductDealDetails->get($this->request->getData('id'));
            try {
                if ($this->ProductDealDetails->delete($productDeal)) {
                    $this->Flash->success(__('The product deal detail has been deleted.'));
                    $response['is_error'] = false;
                } else {
                    $this->Flash->error(__('The product deal detail could not be deleted. Please, try again.'));
                    $response['is_error'] = true;
                }
            } catch (Exception $e) {
                $this->Flash->error(__('The product deal detail could not be deleted. Please, try again.'));
                $response['is_error'] = true;
            }

            return $this->response->withType('application/json')
                ->withStringBody(json_encode($response));
        }
    }


    public function productExist(){

        if ($this->request->is('ajax')) {
            $this->viewBuilder()->setLayout('ajax');
            $search = $this->request->getQuery('search');
            $exclude = $this->request->getQuery('exl');
            $exclude_product_id = [];
            if ($exclude) {
                $lists = explode(',', $exclude);
                foreach($lists as $val) {
                    $product_id = trim($val);
                    if (is_numeric($product_id)) {
                        $exclude_product_id[] = $product_id;
                    }
                }
            }
            $options = $this->Products->find('all')
                ->select(['id','sku','name'])
                ->where(function (\Cake\Database\Expression\QueryExpression $exp) use ($search, $exclude_product_id) {
                    $expresion = $exp->like('name', '%' . $search . '%');
                    if (count($exclude_product_id) > 0) {
                        $expresion->notIn('id', $exclude_product_id);
                    }
                    return $expresion;
                })
                ->toArray();
            $opt = [];
            foreach($options as $k => $vals){
                $stock =$this->ProductOptionStocks->sumStock($vals['id']);
                if($stock > 1){
                    $opt[$k]['sku'] = $vals['sku'];
                    $opt[$k]['name'] = $vals['name'];
                }
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
                    'Products.price_sale',
                ])
                ->where(['Products.sku' => $this->request->getData('sku')])
                ->contain(['ProductImages'])
                ->first()
                ->toArray();
            $options['stock'] = $this->ProductOptionStocks->sumStock($options['id']);

            return $this->response->withType('application/json')
                ->withStringBody(json_encode($options));
        }

    }
}
