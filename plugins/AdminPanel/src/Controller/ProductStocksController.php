<?php
namespace AdminPanel\Controller;

use AdminPanel\Controller\AppController;
use Cake\Core\Configure;
use Cake\Validation\Validator;

/**
 * Brands Controller
 * @property \AdminPanel\Model\Table\ProductsTable Products
 * @property \AdminPanel\Model\Table\ProductOptionPricesTable ProductOptionPrices
 * @property \AdminPanel\Model\Table\OptionsTable Options
 * @property \AdminPanel\Model\Table\OptionValuesTable OptionValues
 * @property \AdminPanel\Model\Table\BranchesTable Branches
 * @property \AdminPanel\Model\Table\ProductStockMutationsTable ProductStockMutations
 * @property \AdminPanel\Model\Table\ProductOptionStocksTable ProductOptionStocks
 * @property \AdminPanel\Model\Table\ProductOptionValueListsTable ProductOptionValueLists
 * @property \AdminPanel\Model\Table\CustomerWishesTable CustomerWishes
 *
 * @method \AdminPanel\Model\Entity\Brand[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProductStocksController  extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadModel('AdminPanel.Products');
        $this->loadModel('AdminPanel.ProductOptionPrices');
        $this->loadModel('AdminPanel.ProductStockMutations');
        $this->loadModel('AdminPanel.Options');
        $this->loadModel('AdminPanel.OptionValues');
        $this->loadModel('AdminPanel.ProductOptionValueLists');
        $this->loadModel('AdminPanel.ProductOptionStocks');
        $this->loadModel('AdminPanel.Branches');
        $this->loadModel('AdminPanel.CustomerWishes');
    }


    public function validate(){

        $this->disableAutoRender();
        $response = [];

        $product_option_stocks = $this->request->getData('ProductOptionStocks');
        $validator = new Validator();
        $productStockMutations = new Validator();
        foreach($product_option_stocks as $k => $vals){
            if(!empty($vals['id'])) {
                $productStockMutations
                    ->notBlank('tipe', 'tidak boleh kosong');
                $productStockMutations
                    ->notBlank('stock', 'tidak boleh kosong');
                $productStockMutations
                    ->notBlank('description', 'tidak boleh kosong');
            } else {
                unset($product_option_stocks[$k]);
            }
        }


        $validator->addNestedMany('ProductOptionStocks', $productStockMutations);
        $allData = $this->request->getData();
        $allData['ProductOptionStocks'] = $product_option_stocks;
        $error = $validator->errors($allData);
        if (empty($error)) {
            foreach($product_option_stocks as $key => $val) {
                switch ($val['tipe']) {
                    case 'penambahan':
                        $this->ProductStockMutations->saving($val['id'],'1', $val['stock'],$val['description']);

                        /* Find on whistlist CustomerWishes */
                        $listWhises = $this->CustomerWishes->find()
                            ->contain(['Customers'])
                            ->where(['CustomerWishes.product_id' => $val['product_id']])
                            ->all();
                        foreach($listWhises as $vals){
                            if( $vals['customer_id'] == 3){

                                if ($this->Notification->create(
                                    $vals['customer_id'],
                                    '2',
                                    $val['name']. ' produk restock',
                                    'Produk '.$val['name'].', variant : '. $val['variant'].' telah di restock. Kini anda  dapat melakukan order untuk produk tersebut.',
                                    'Products',
                                    $val['product_id'],
                                    2,
                                    Configure::read('mainSite').'/images/70x59/'. $val['image'],
                                    Configure::read('frontsite').'products/detail/'. $val['slug'],
                                )) {

                                    $this->Notification->triggerCount(
                                        $vals['customer_id'],
                                        $vals['reffcode']
                                    );
                                }
                            }
                        }


                    break;
                    case 'pengurangan':
                        $this->ProductStockMutations->saving($val['id'],'2', ($val['stock'] * -1),$val['description']);
                    break;
                }
            }
            $this->Flash->success(__('The product stock has been update.'));
        }

        $response['error'] = $error;
        return $this->response->withType('application/json')
            ->withStringBody(json_encode($response));
    }

    public function index(){

//        $this->ProductStockMutations->saving('1','1', '1','Test mutation'); //mutation amount

        if ($this->DataTable->isAjax()) {
            $datatable = $this->DataTable->adapter('AdminPanel.ProductOptionStocks')
                ->contain([
                    'Products' => [
                        'ProductImages'
                    ],
                    'ProductOptionPrices'
                ])
                ->search(function ($search, \Cake\Database\Expression\QueryExpression $exp) {

                    $orConditions = $exp->or_([
                        'ProductOptionPrices.sku LIKE' => '%' . $search .'%',
                        'Products.name LIKE' => '%' . $search .'%',
                        'Products.sku LIKE' => '%' . $search .'%',
                    ]);
                    return $exp
                        ->add($orConditions);
                });


            $result = $datatable
                ->setSorting()
                ->getTable()
                ->toArray();
            foreach($result as $k => $vals){
                $priceId = $vals['product_option_price_id'];
                $result[$k]['branches'] = $this->Branches->getNameById($vals['branch_id']);
                $result[$k]['value_lists'] = $this->ProductOptionValueLists->find()
                    ->where(['ProductOptionValueLists.product_option_price_id' => $priceId])
                    ->all()
                    ->toArray();
                foreach($result[$k]['value_lists'] as $x => $val){
                    $result[$k]['value_lists'][$x]['option'] = $this->Options->getNameById($val['option_id']);
                    $result[$k]['value_lists'][$x]['values'] = $this->OptionValues->getNameById($val['option_value_id']);
                }
            }

            //set again datatable
            $datatable->setData($result);


            return $datatable->response();
        }

        /*if ($this->request->is('ajax')) {
            $this->viewBuilder()->setLayout('ajax');

            $pagination = $this->request->getData('pagination');
            $sort = $this->request->getData('sort');
            $query = $this->request->getData('query');

            //** custom default query : select, where, contain, etc.
            $data = $this->ProductOptionStocks->find('all')
                ->select();
            $data->contain(['Products','ProductOptionPrices']);
//            ,'Options','OptionValues'
            if ($query && is_array($query)) {
                if (isset($query['generalSearch'])) {
                    $search = $query['generalSearch'];
                    unset($query['generalSearch']);

                    //custom field for general search
                    //ex : 'Users.email LIKE' => '%' . $search .'%'

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

            foreach($result['data'] as $k => $vals){
                $priceId = $vals['product_option_price_id'];
                $result['data'][$k]['branches'] = $this->Branches->getNameById($vals['branch_id']);
                $result['data'][$k]['value_lists'] = $this->ProductOptionValueLists->find()
                    ->where(['ProductOptionValueLists.product_option_price_id' => $priceId])
                    ->all()
                    ->toArray();
                foreach($result['data'][$k]['value_lists'] as $x => $val){
                    $result['data'][$k]['value_lists'][$x]['option'] = $this->Options->getNameById($val['option_id']);
                    $result['data'][$k]['value_lists'][$x]['values'] = $this->OptionValues->getNameById($val['option_value_id']);
                }
            }

            $result['meta'] = array_merge((array) $pagination, (array) $sort);
            $result['meta']['total'] = $total;


            return $this->response->withType('application/json')
                ->withStringBody(json_encode($result));
        }*/
    }

    public function import(){

        Configure::write('debug', 0);
        if ($this->request->is('post')) {

            $data = $this->request->getData('files');
            $file = $data['tmp_name'];
            $handle = fopen($file, "r");
            $count = 0;
            while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $count++;
                if ($count == 1) {
                    continue;
                }
                $findSKU = $this->ProductOptionPrices->find()
                    ->where(['ProductOptionPrices.sku LIKE ' => $row[0].'%'])
                    ->first();
                if($findSKU){
                    $productOptionPricesId = $findSKU->get('id');
                    $productId = $findSKU->get('product_id');
                    /*Find Branches*/
                    $findBranch = $this->Branches->find()
                        ->where(['Branches.name LIKE' => '%'.$row[1].'%'])
                        ->first();

                    if($findBranch){
                        $findStocks = $this->ProductOptionStocks->find()
                            ->where([
                                'ProductOptionStocks.product_id' => $productId,
                                'ProductOptionStocks.product_option_price_id' => $productOptionPricesId,
                                'ProductOptionStocks.branch_id' => $findBranch->get('id'),
                            ])
                            ->first();
                        if($findStocks){
                            switch ($row[2]) {
                                case 'penambahan':
                                    $this->ProductStockMutations->saving($findStocks->get('id'),'5', $row[3],$row[4]);
                                break;
                                case 'pengurangan':
                                    $this->ProductStockMutations->saving($findStocks->get('id'),'6', ($row[3] * -1),$row[4]);
                                break;
                            }
                        }
                    }
                }
            }
            $this->Flash->success(__('Success import file'));
            $this->redirect(['action' => 'index']);
        }
    }


}