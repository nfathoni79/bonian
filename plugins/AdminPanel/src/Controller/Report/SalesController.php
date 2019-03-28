<?php
namespace AdminPanel\Controller\Report;

use AdminPanel\Controller\AppController;

/**
 * Reports Controller
 * @property \AdminPanel\Model\Table\BranchesTable $Branches
 *
 */
class SalesController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadModel('AdminPanel.Branches');
    }


    public function index()
    {
        $report_type = $this->request->getData('report_type', 1);
        $branch_id = $this->request->getData('branch_id');


        if ($this->DataTable->isAjax()) {
            $datatable = $this->DataTable->adapter('AdminPanel.OrderDetailProducts')
                ->leftJoinWith('OrderDetails')
                ->leftJoinWith('OrderDetails.Orders')
                ->leftJoinWith('OrderDetails.Orders.Vouchers');

            switch ($report_type) {
                case '1':
                    $datatable
                        ->select([
                            'name' => 'ProductCategories.name',
                            'total' => $datatable->getTable()->func()->count('ProductToCategories.product_category_id'),
                            'gross_sales' => $datatable->getTable()->func()->sum('OrderDetailProducts.total'),
                            'discount' => "SUM(IF(Vouchers.type = 1, Vouchers.value / 100 * OrderDetailProducts.total, Vouchers.value))",
                        ])
                        ->leftJoinWith('Products')
                        ->leftJoinWith('Products.ProductToCategories')
                        ->leftJoinWith('Products.ProductToCategories.ProductCategories')
                        ->group([
                            'ProductToCategories.product_category_id'
                        ]);
                    break;
                case '2':
                    $datatable
                        ->select([
                            'name' => 'Brands.name',
                            'total' => $datatable->getTable()->func()->count('Products.brand_id'),
                            'gross_sales' => $datatable->getTable()->func()->sum('OrderDetailProducts.total'),
                            'discount' => "SUM(IF(Vouchers.type = 1, Vouchers.value / 100 * OrderDetailProducts.total, Vouchers.value))",
                        ])
                        ->leftJoinWith('Products')
                        ->leftJoinWith('Products.Brands')
                        ->leftJoinWith('Products.ProductToCategories')
                        ->leftJoinWith('Products.ProductToCategories.ProductCategories')
                        ->group([
                            'Products.brand_id'
                        ]);
                    break;
                case '3':

                    break;
            }

            $datatable
                ->search(function ($search, \Cake\Database\Expression\QueryExpression $exp) {
                    $orConditions = $exp->or_([
                        'Products.name LIKE' => '%' . $search .'%',
                        'ProductOptionPrices.sku LIKE' => '%' . $search .'%',
                        'Brands.name LIKE' => '%' . $search .'%',
                    ]);
                    return $exp
                        ->add($orConditions);
                });


            $result = $datatable
                ->setSorting()
                ->getTable()
                ->where([
                    //'Orders.payment_status' => 2
                    //'Orders.id' => 78, //TODO this for testing
                ])
                ->map(function (\AdminPanel\Model\Entity\OrderDetailProduct $row) {
                    $row->net_sales = $row->gross_sales - $row->discount;
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
