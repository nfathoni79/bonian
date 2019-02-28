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
        $this->loadModel('AdminPanel.Options');
        $this->loadModel('AdminPanel.OptionValues');
        $this->loadModel('AdminPanel.Branches');
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