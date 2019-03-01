<?php
namespace AdminPanel\Controller;

use AdminPanel\Controller\AppController;

/**
 * ProductStockMutations Controller
 * @property \AdminPanel\Model\Table\ProductStockMutationsTable $ProductStockMutations
 *
 * @method \AdminPanel\Model\Entity\ProductStockMutation[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProductStockMutationsController extends AppController
{

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
            $data = $this->ProductStockMutations->find('all')
                ->select([
//                    'id' => 'Products.id',
//                    'created' => 'Products.created',
//                    'name' => 'Products.name',
                ]);
            $data->contain([
                'Products',
                'Branches',
                'ProductOptionStocks' => [
                    'ProductOptionPrices' => [
//                        'fields' => [
//                            'sku' => 'ProductOptionPrices.sku',
//                        ],
                        'ProductOptionValueLists' => [
                            'fields' => [
                                'ProductOptionValueLists.product_option_price_id',
                                'option_name' => 'Options.name',
                                'option_value_name' => 'OptionValues.name'
                            ],
                            'Options',
                            'OptionValues',
                        ]
                    ]
                ],
                'ProductStockMutationTypes' => [
                    'fields' => [
                        'tipe' => 'ProductStockMutationTypes.name'
                    ]
                ]
            ])
            ;

            if ($query && is_array($query)) {
                if (isset($query['generalSearch'])) {
                    $search = $query['generalSearch'];
                    unset($query['generalSearch']);
                    /**
                        custom field for general search
                        ex : 'Users.email LIKE' => '%' . $search .'%'
                    **/
                    $data->where(['ProductStockMutations.name LIKE' => '%' . $search .'%']);
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


        $this->set(compact('productStockMutations'));
    }

}
