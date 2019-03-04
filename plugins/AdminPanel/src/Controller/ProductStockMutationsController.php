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

        if ($this->DataTable->isAjax()) {
            $datatable = $this->DataTable->adapter('AdminPanel.ProductStockMutations')
                ->contain([
                    'Products',
                    'Branches',
                    'ProductOptionStocks' => [
                        'ProductOptionPrices' => [
                            'ProductOptionValueLists' => [
                                'Options',
                                'OptionValues',
                            ]
                        ]
                    ],
                    'ProductStockMutationTypes'
                ])
                ->search(function ($search, \Cake\Database\Expression\QueryExpression $exp) {
                    $orConditions = $exp->or_([
                        'Products.name LIKE' => '%' . $search .'%',
                        'Branches.name LIKE' => '%' . $search .'%',
                        'ProductStockMutationTypes.name LIKE' => '%' . $search .'%',
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



//        $this->set(compact('productStockMutations'));
    }

}
