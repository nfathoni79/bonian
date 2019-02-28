<?php
namespace AdminPanel\Controller;

use AdminPanel\Controller\AppController;
use Cake\Validation\Validator;

/**
 * Brands Controller
 * @property \AdminPanel\Model\Table\ProductsTable Products
 * @property \AdminPanel\Model\Table\ProductOptionPricesTable ProductOptionPrices
 * @property \AdminPanel\Model\Table\OptionsTable Options
 * @property \AdminPanel\Model\Table\OptionValuesTable OptionValues
 * @property \AdminPanel\Model\Table\BranchesTable Branches
 * @property \AdminPanel\Model\Table\ProductStockMutationsTable ProductStockMutations
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
        $this->loadModel('AdminPanel.Branches');
    }


    public function validate(){

        $this->disableAutoRender();
        $response = [];
        foreach($this->request->getData('ProductOptionStocks') as $k => $vals){
            if(empty($vals['id'])){
                debug($vals); // form radio kok hilang?? form name ProductOptionStocks[1]['tipe']
//                debug($this->request->getData('ProductOptionStocks.'.$k));
//                exit;
            }
        }
        debug($this->request->getData('ProductOptionStocks'));
        exit;
        $validator = new Validator();
        $productStockMutations = new Validator();
        foreach($this->request->getData('ProductOptionStocks') as $k => $vals){
            if(!empty($vals['id'])){
                $productStockMutations
                    ->notBlank('tipe', 'tidak boleh kosong');
                $productStockMutations
                    ->notBlank('stock', 'tidak boleh kosong');
                $productStockMutations
                    ->notBlank('description', 'tidak boleh kosong');
            }
        }


        $validator->addNestedMany('ProductOptionStocks', $productStockMutations);
        $error = $validator->errors($this->request->getData());
        if (empty($error)) {

        }

        $response['error'] = $validator->errors($this->request->getData());
        return $this->response->withType('application/json')
            ->withStringBody(json_encode($response));
    }

    public function index(){

        if ($this->request->is('ajax')) {
            $this->viewBuilder()->setLayout('ajax');

            $pagination = $this->request->getData('pagination');
            $sort = $this->request->getData('sort');
            $query = $this->request->getData('query');

            /** custom default query : select, where, contain, etc. **/
            $data = $this->ProductOptionPrices->find('all')
                ->select();
            $data->contain(['Products','ProductOptionStocks','ProductOptionValueLists']);
//            ,'Options','OptionValues'
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

            foreach($result['data'] as $k => $vals){
                foreach($vals['product_option_value_lists'] as $x => $val){
                    $result['data'][$k]['product_option_value_lists'][$x]['option'] = $this->Options->getNameById($val['option_id']);
                    $result['data'][$k]['product_option_value_lists'][$x]['values'] = $this->OptionValues->getNameById($val['option_value_id']);
                }
                foreach($vals['product_option_stocks'] as $x => $val){
                    $result['data'][$k]['product_option_stocks'][$x]['branches'] = $this->Branches->getNameById($val['branch_id']);
                }
            }

            $result['meta'] = array_merge((array) $pagination, (array) $sort);
            $result['meta']['total'] = $total;


            return $this->response->withType('application/json')
                ->withStringBody(json_encode($result));
        }
    }

}