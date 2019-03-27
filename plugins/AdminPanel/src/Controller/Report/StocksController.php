<?php
namespace AdminPanel\Controller\Report;

use AdminPanel\Controller\AppController;

/**
 * Reports Controller
 * @property \AdminPanel\Model\Table\BranchesTable $Branches
 *
 */
class StocksController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadModel('AdminPanel.Branches');
    }


    public function index()
    {
        if ($this->DataTable->isAjax()) {
            $datatable = $this->DataTable->adapter('AdminPanel.ProductOptionStocks')
                ->select([])
                ->contain([
                    'Products' => [
                        'Brands',
                        'ProductToCategories' => [
                            'ProductCategories'
                        ]
                    ],
                    'ProductOptionPrices',
                    'Branches',
                ])
                ->search(function ($search, \Cake\Database\Expression\QueryExpression $exp) {
                    $orConditions = $exp->or_([
                        'Products.name LIKE' => '%' . $search .'%',
                        'ProductOptionPrices.sku LIKE' => '%' . $search .'%',
                        'Brands.name LIKE' => '%' . $search .'%',
                    ]);
                    return $exp
                        ->add($orConditions);
                })
                ->getRequestColumn(3, function($request, \Cake\ORM\Query $table) {
                    if (!empty($request['search']['value'])) {
                        $branch_id = $request['search']['value'];
                        $table->where([
                            'ProductOptionStocks.branch_id' => $branch_id
                        ]);
                    }
                })
                ->getRequestColumn(6, function($request, \Cake\ORM\Query $table) {
                    if (!empty($request['search']['value']) || $request['search']['value'] != '') {
                        $qty = (int) $request['search']['value'];
                    } else {
                        $qty = 10; //default low stock
                    }

                    $table->where(function(\Cake\Database\Expression\QueryExpression $exp) use ($qty) {
                        return $exp->lte('ProductOptionStocks.stock', $qty);
                    });
                });

            $result = $datatable
                ->setSorting()
                ->getTable()
                ->map(function (\AdminPanel\Model\Entity\ProductOptionStock $row) {
                    return $row;
                })
                ->toArray();




            //set again datatable
            $datatable->setData($result);
            return $datatable->response();
        }

        $branches = $this->Branches->find('list')->toArray();

        $this->set(compact('branches'));
    }



}
