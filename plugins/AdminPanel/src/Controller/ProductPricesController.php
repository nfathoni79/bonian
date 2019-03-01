<?php
namespace AdminPanel\Controller;

use AdminPanel\Controller\AppController;
use Cake\Validation\Validator;

/**
 * ProductPricesMutations Controller
 * @property \AdminPanel\Model\Table\ProductsTable $Products
 * @property \AdminPanel\Model\Table\ProductOptionPricesTable $ProductOptionPrices
 *
 */
class ProductPricesController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadModel('AdminPanel.Products');
        $this->loadModel('AdminPanel.ProductOptionPrices');
    }



    public function validate(){

        $this->disableAutoRender();
        $response = [];
        $products = $this->request->getData('Products');
        $validator = new Validator();

        $productsValue = new Validator();
        $optionPrice = new Validator();
        foreach($products as $k => $vals){
            if(!empty($vals['id'])) {
                $productsValue
                    ->decimal('price_sale')
                    ->notBlank('price_sale', 'tidak boleh kosong');
                $optionPrice->decimal('price')
                    ->notBlank('price', 'tidak boleh kosong');

            } else {
                unset($products[$k]);
            }
        }

        $productsValue->addNestedMany('ProductOptionPrices', $optionPrice);
        $validator->addNestedMany('Products', $productsValue);

        $allData = $this->request->getData();
        $allData['Products'] = $products;
        $error = $validator->errors($allData);
        if (empty($error)) {

            foreach($products as $vals){
                $id = $vals['id'];
                $product = $this->Products->get($id);
                $product = $this->Products->patchEntity($product, [
                    'price_sale' => $vals['price_sale']
                ] , ['validate' => false]);

                if($this->Products->save($product)){
                    foreach($vals['ProductOptionPrices'] as $k => $val){
                        $productOptionPrices = $this->ProductOptionPrices->get($k);
                        $productOptionPrices = $this->ProductOptionPrices->patchEntity($productOptionPrices, [
                            'price' => $val['price']
                        ] , ['validate' => false]);
                        $this->ProductOptionPrices->save($productOptionPrices);
                    }
                }
            }

            $this->Flash->success(__('The product price has been update.'));


        }

        $response['error'] = $error;
        return $this->response->withType('application/json')
            ->withStringBody(json_encode($response));

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
            $data = $this->Products->find('all')
                ->select();
            $data->contain([
                'ProductOptionPrices',
                'ProductOptionPrices' => [
                    'ProductOptionValueLists' => [
                        'Options',
                        'OptionValues',
                    ]
                ]
            ]);
            $data->where(['Products.name !=' => '']);
            if ($query && is_array($query)) {
                if (isset($query['generalSearch'])) {
                    $search = $query['generalSearch'];
                    unset($query['generalSearch']);
                    /**
                    custom field for general search
                    ex : 'Users.email LIKE' => '%' . $search .'%'
                     **/
                    $data->where(['ProductOptionPrices.sku LIKE' => '%' . $search .'%']);
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
//            debug($data);
//            exit;


            return $this->response->withType('application/json')
                ->withStringBody(json_encode($result));

        }
    }
}