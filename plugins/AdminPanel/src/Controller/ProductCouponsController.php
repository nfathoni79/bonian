<?php
namespace AdminPanel\Controller;

use AdminPanel\Controller\AppController;
use Cake\Core\Configure;
use Cake\Validation\Validator;


/**
 * ProductCoupons Controller
 * @property \AdminPanel\Model\Table\ProductCouponsTable $ProductCoupons
 * @property \AdminPanel\Model\Table\ProductsTable $Products
 * @property \AdminPanel\Model\Table\ProductOptionStocksTable $ProductOptionStocks
 * @property \AdminPanel\Model\Table\CustomersTable $Customers
 *
 * @method \AdminPanel\Model\Entity\ProductCoupon[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProductCouponsController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadModel('AdminPanel.Products');
        $this->loadModel('AdminPanel.Customers');
        $this->loadModel('AdminPanel.ProductCoupons');
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
            $data = $this->ProductCoupons->find('all')
                ->select();
            $data->contain(['Products']);

            if ($query && is_array($query)) {
                if (isset($query['generalSearch'])) {
                    $search = $query['generalSearch'];
                    unset($query['generalSearch']);
                    /**
                        custom field for general search
                        ex : 'Users.email LIKE' => '%' . $search .'%'
                    **/
                    $data->where(['ProductCoupons.name LIKE' => '%' . $search .'%']);
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


        $this->set(compact('productCoupons'));
    }

    /**
     * View method
     *
     * @param string|null $id Product Coupon id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */


    public function validateAjax()
    {


        if ($this->request->is(['ajax', 'post'])) {
            $response = [];
            $validator = new Validator();

            $validator
                ->requirePresence('product_id')
                ->notBlank('product_id', 'Tidak boleh kosong');
            $validator
                ->requirePresence('name')
                ->notBlank('name', 'Tidak boleh kosong');
            $validator
                ->requirePresence('price')
                ->notBlank('price', 'Tidak boleh kosong')
                ->numeric('price','Gunakan format angka');

            $validator
                ->requirePresence('expired')
                ->notBlank('expired', 'Tidak boleh kosong')
                ->date('expired');

            $error = $validator->errors($this->request->getData());

            if (empty($error)) {
                $productCoupon = $this->ProductCoupons->newEntity();
                $productCoupon = $this->ProductCoupons->patchEntity($productCoupon, $this->request->getData());

                if ($this->ProductCoupons->save($productCoupon)) {
                    if($this->request->getData('notif') == 1){

                        $products = $this->Products->find()
                            ->select(['id','price_sale', 'name', 'slug'])
                            ->contain(['ProductImages'])
                            ->where(['Products.id' => $this->request->getData('product_id')])
                            ->first();

                        $customers = $this->Customers->find()
                            ->select(['id','email','username','reffcode'])
                            ->where([
                                'Customers.is_verified' => 1,
                                'Customers.is_email_verified' => 1,
                            ])->toArray();
                        foreach($customers as $vals){
                            if ($this->Notification->create(
                                $vals->id,
                                '3',
                                'Kupon promo',
                                'Harga spesial '.$products->name.' Rp.'.$products->price_sale.'!, Makin hemat dengan kupon Rp.'.$this->request->getData('price').'. Buruan, checkout sekarang ',
                                'Products',
                                $products->id,
                                2,
                                Configure::read('mainSite').'/images/70x59/'. $products->product_images[0]['name'],
                                Configure::read('frontsite').'products/detail/'. $products->slug
                            )) {

                                $this->Notification->triggerCount(
                                    $vals->id,
                                    $vals->reffcode
                                );
                            }
                        }
                    }
                    $this->Flash->success(__('The coupon has been saved.'));
                }
            }

            $response['error'] = $validator->errors($this->request->getData());
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
            $listProductCoupon = $this->ProductCoupons->find()
                ->select(['id' => 'product_id'])
                ->where(['ProductCoupons.status' => 1])
                ->all()->toArray();
            foreach($listProductCoupon as $val) {
                $product_id = trim($val['id']);
                if (is_numeric($product_id)) {
                    $exclude_product_id[] = $product_id;
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
                    $opt[$k]['id'] = $vals['id'];
                    $opt[$k]['sku'] = $vals['sku'];
                    $opt[$k]['name'] = $vals['name'];
                }
            }

            return $this->response->withType('application/json')
                ->withStringBody(json_encode($opt));
        }

    }





    /**
     * Delete method
     *
     * @param string|null $id Product Coupon id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $productCoupon = $this->ProductCoupons->get($id);
        try {
            if ($this->ProductCoupons->delete($productCoupon)) {
                $this->Flash->success(__('The product coupon has been deleted.'));
            } else {
                $this->Flash->error(__('The product coupon could not be deleted. Please, try again.'));
            }
        } catch (Exception $e) {
            $this->Flash->error(__('The product coupon could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
