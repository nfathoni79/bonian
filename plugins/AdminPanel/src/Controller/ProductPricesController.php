<?php
namespace AdminPanel\Controller;

use AdminPanel\Controller\AppController;
use Cake\Validation\Validator;

/**
 * ProductPricesMutations Controller
 * @property \AdminPanel\Model\Table\ProductsTable $Products
 * @property \AdminPanel\Model\Table\ProductOptionPricesTable $ProductOptionPrices
 * @property \AdminPanel\Model\Table\ActivityLogsTable $ActivityLogs
 *
 */
class ProductPricesController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadModel('AdminPanel.Products');
        $this->loadModel('AdminPanel.ProductOptionPrices');
        $this->loadModel('AdminPanel.ActivityLogs');
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
                $products[$k]['price_sale'] = preg_replace('/[,.]/', '', $vals['price_sale']);
                foreach($vals['ProductOptionPrices'] as $x => $val){
                    if(!empty($val['id'])){
                        $products[$k]['ProductOptionPrices'][$x]['price'] =  preg_replace('/[,.]/', '', $val['price']);
                    }else{
                        unset($products[$k]['ProductOptionPrices'][$x]);
                    }
                }
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

                $this->Products->setLogMessageBuilder(function () use($product){
                    return 'Manajemen Harga - Perubahan Pada Main SKU : '.$product->get('sku');
                });
                if($this->Products->save($product)){
                    foreach($vals['ProductOptionPrices'] as $k => $val){
                        $productOptionPrices = $this->ProductOptionPrices->get($k);
                        $productOptionPrices = $this->ProductOptionPrices->patchEntity($productOptionPrices, [
                            'price' => $val['price']
                        ] , ['validate' => false]);
                        $this->ProductOptionPrices->setLogMessageBuilder(function () use($productOptionPrices){
                            return 'Manajemen Harga - Perubahan Pada SKU : '.$productOptionPrices->get('sku');
                        });
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

        if ($this->DataTable->isAjax()) {
            $datatable = $this->DataTable->adapter('AdminPanel.ProductOptionPrices')
                ->contain([
                    'Products',
                    'ProductOptionValueLists' => [
                        'Options',
                        'OptionValues',
                    ]
                ])
                ->search(function ($search, \Cake\Database\Expression\QueryExpression $exp) {
                    $orConditions = $exp->or_([
                        'Products.name LIKE' => '%' . $search .'%',
                        'Products.sku LIKE' => '%' . $search .'%',
                        'ProductOptionPrices.sku LIKE' => $search .'%',
                    ]);
                    return $exp
                        ->add($orConditions);
                });

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