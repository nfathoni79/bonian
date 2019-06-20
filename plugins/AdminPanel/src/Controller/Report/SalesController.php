<?php
namespace AdminPanel\Controller\Report;

use AdminPanel\Controller\AppController;
use Cake\I18n\Time;

/**
 * Reports Controller
 * @property \AdminPanel\Model\Table\BranchesTable $Branches
 * @property \AdminPanel\Model\Table\OrderDetailProductsTable $OrderDetailProducts
 *
 */
class SalesController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadModel('AdminPanel.Branches');
        $this->loadModel('AdminPanel.OrderDetailProducts');
    }


    public function index()
    {
        $report_type = $this->request->getData('report_type', 1);
        $branch_id = $this->request->getData('branch_id');

        $start = (Time::now())->addDays(-29)->format('Y-m-d');
        $end = (Time::now())->format('Y-m-d');

        if ($date_range = $this->request->getData('date_range')) {
            //parse date range
            list($start, $end) = explode('/', $date_range);
            $start = (Time::parse(trim($start)))->format('Y-m-d');
            $end = (Time::parse(trim($end)))->format('Y-m-d');
        }


        if ($this->DataTable->isAjax()) {
            $datatable = $this->DataTable->adapter('AdminPanel.OrderDetailProducts')
                ->leftJoinWith('OrderDetails')
                ->leftJoinWith('Products')
                ->leftJoinWith('ProductOptionStocks')
                ->leftJoinWith('OrderDetails.Orders')
                ->leftJoinWith('OrderDetails.Orders.Vouchers');

            $type = null;

            switch ($report_type) {
                case '1':
                    $datatable
                        ->select([
                            'name' => 'ProductCategories.name',
                            'total' => $datatable->getTable()->func()->count('ProductToCategories.product_category_id'),
                            'gross_sales' => $datatable->getTable()->func()->sum('OrderDetailProducts.total'),
                            'discount' => "SUM(IF(Vouchers.type = 1, Vouchers.value / 100 * OrderDetailProducts.total, Vouchers.value))",
                            'use_voucher' => "(SUM(IF(isnull(Orders.voucher_id), 0, 1)))"
                        ])
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
                            'use_voucher' => "(SUM(IF(isnull(Orders.voucher_id), 0, 1)))"
                        ])
                        ->leftJoinWith('Products.Brands')
                        ->leftJoinWith('Products.ProductToCategories')
                        ->leftJoinWith('Products.ProductToCategories.ProductCategories')
                        ->group([
                            'Products.brand_id'
                        ]);
                    break;
                case '3':
                    $range = $this->OrderDetailProducts->find();
                    $range = $range
                        ->select([
                            'min' => $range->func()->min('Orders.created'),
                            'max' => $range->func()->max('Orders.created'),
                        ])
                        ->leftJoinWith('ProductOptionStocks')
                        ->leftJoinWith('OrderDetails')
                        ->leftJoinWith('OrderDetails.Orders');


                    if ($branch_id) {
                        $range->where([
                            'ProductOptionStocks.branch_id' => $branch_id
                        ]);
                    }

                    if ($start && $end) {
                        $range->where(function(\Cake\Database\Expression\QueryExpression $exp) use ($start, $end) {
                            return $exp->gte('Orders.created', $start . ' 00:00:00')
                                ->lte('Orders.created', $end . ' 23:59:59');
                        });
                    }


                    $range = $range
                        ->first();

                    $timeInYear = 0;
                    $timeInMonth = 0;
                    //$timeInDay = 0;
                    $type = 'day';
                    if ($range) {
                        $timeInYear = (Time::parse($range->get('max')))->diffInYears(
                            Time::parse($range->get('min'))
                        );
                        $timeInMonth = (Time::parse($range->get('max')))->diffInMonths(
                            Time::parse($range->get('min'))
                        );

                        /*$timeInDay = (Time::parse($range->get('max')))->diffInDays(
                            Time::parse($range->get('min'))
                        );*/
                    }


                    if ($timeInYear) {
                        $type = 'year';
                    } else if ($timeInMonth) {
                        $type = 'month';
                    } else {
                        $type = 'day';
                    }



                    $datatable
                        ->select([
                            'name' => "Orders.created",
                            'total' => $datatable->getTable()->func()->count('Products.brand_id'),
                            'gross_sales' => $datatable->getTable()->func()->sum('OrderDetailProducts.total'),
                            'discount' => "SUM(IF(Vouchers.type = 1, Vouchers.value / 100 * OrderDetailProducts.total, Vouchers.value))",
                            'use_voucher' => "(SUM(IF(isnull(Orders.voucher_id), 0, 1)))",
                            'year' => $datatable->getTable()->func()->year([
                                'Orders.created' => 'identifier'
                            ]),
                            'month' => $datatable->getTable()->func()->month([
                                'Orders.created' => 'identifier'
                            ]),
                            'day' => $datatable->getTable()->func()->day([
                                'Orders.created' => 'identifier'
                            ])
                        ])
                        ->leftJoinWith('Products.ProductToCategories')
                        ->leftJoinWith('Products.ProductToCategories.ProductCategories');

                    switch ($type) {
                        case 'year':
                            $datatable->group(['year']);
                            break;
                        case 'month':
                            $datatable->group(['month', 'year']);
                            break;
                        case 'day':
                            $datatable->group(['day', 'month', 'year']);
                            break;
                    }

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
                ]);

            if ($branch_id) {
                $result->where([
                    'ProductOptionStocks.branch_id' => $branch_id
                ]);
            }

            if ($start && $end) {
                $result->where(function(\Cake\Database\Expression\QueryExpression $exp) use ($start, $end) {
                    return $exp->gte('Orders.created', $start . ' 00:00:00')
                        ->lte('Orders.created', $end . ' 23:59:59');
                });
            }


            $result = $result
                ->map(function (\AdminPanel\Model\Entity\OrderDetailProduct $row) use($type) {
                    if ($type) {
                        switch ($type) {
                            case 'year':
                                $row->name = (Time::parse($row->name))->format('Y');
                                break;
                            case 'month':
                                $row->name = (Time::parse($row->name))->format('M Y');
                                break;
                            case 'day':
                                $row->name = (Time::parse($row->name))->format('d M Y');
                                break;
                        }
                    }
                    $row->net_sales = $row->gross_sales - $row->discount;
                    return $row;
                })
                ->toArray();

            //set again datatable
            $datatable->setData($result);
            return $datatable->response();
        }

        $branches = $this->Branches->find('list')->toArray();

        $this->set(compact('branches', 'start', 'end'));
    }



}
