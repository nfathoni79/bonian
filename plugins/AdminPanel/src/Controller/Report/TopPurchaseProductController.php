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
class TopPurchaseProductController  extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadModel('AdminPanel.Branches');
        $this->loadModel('AdminPanel.OrderDetailProducts');
    }


    public function index()
    {
        $start = $this->request->getQuery('start');
        $end = $this->request->getQuery('end');
        $limit = $this->request->getQuery('limit', 10);

        if (empty($start) || empty ($end)) {
            $start = (Time::now())->addDays(-14)->format('Y-m-d');
            $end = (Time::now())->format('Y-m-d');
        }

        $list_of_products = [];
        $by_categories = $this->byCategory($start, $end, $limit);
        $by_brands = $this->byBrand($start, $end, $limit);
        $by_periods = $this->byPeriod($start, $end, $limit, $list_of_products);

        //debug($list_of_products);


        $this->set(compact('by_categories', 'by_brands', 'by_periods', 'start', 'end', 'list_of_products'));
    }

    protected function byCategory($start = null, $end = null, $limit = 10)
    {


        $datatable = $this->OrderDetailProducts->find();
        $datatable
            ->select([
                'total_sales' => $datatable->func()->count('ProductToCategories.product_category_id'),
                //'revenue' => $datatable->func()->sum('OrderDetailProducts.total'),
                'category_name' => 'ProductCategories.name',
                //'Product_id' => 'Products.id',
                //'Product_name' => 'Products.name',
                //'product_category_id' => 'ProductToCategories.id'
            ])
            ->leftJoinWith('OrderDetails')
            ->leftJoinWith('OrderDetails.Orders')
            ->leftJoinWith('Products.ProductToCategories')
            ->leftJoinWith('Products.ProductToCategories.ProductCategories')
            //->enableAutoFields(true)
            ->where([
                'Orders.payment_status' => 2,
                //'OrderDetails.order_status_id IN' => [2, 3, 4]
            ]);

        if ($this->validDate($start) && $this->validDate($end)) {
            $datatable->where(function(\Cake\Database\Expression\QueryExpression $exp) use ($start, $end) {
                return $exp->gte('Orders.created', $start . ' 00:00:00')
                    ->lte('Orders.created', $end . ' 23:59:59');
            });
        }

        $datatable = $datatable
            ->group([
                'ProductToCategories.product_category_id',
            ])
            ->order([
                'total_sales' => 'DESC'
            ])
            ->limit($limit)
            ->map(function(\AdminPanel\Model\Entity\OrderDetailProduct $row) {
                $row->sector = $row->category_name;
                $row->size = $row->total_sales;
                unset($row->category_name);
                unset($row->total_sales);
                return $row;
            })
            ->toArray();


        return $datatable;
    }

    protected function validDate($date)
    {
        $month = 0;
        $day = 0;
        $year = 0;

        if (preg_match('/(\d{4})-(\d{2})-(\d{2})/', $date, $matched)) {
            $year = $matched[1];
            $month = $matched[2];
            $day = $matched[3];
        }

        return checkdate ($month, $day, $year);
    }

    public function byBrand($start = null, $end = null, $limit = 10)
    {


        $datatable = $this->OrderDetailProducts->find();
        $datatable
            ->select([
                'total_sales' => $datatable->func()->count('Products.brand_id'),
                //'revenue' => $datatable->func()->sum('OrderDetailProducts.total'),
                'brand_name' => 'Brands.name',
                //'Product_id' => 'Products.id',
                //'Product_name' => 'Products.name',
            ])
            ->leftJoinWith('OrderDetails')
            ->leftJoinWith('OrderDetails.Orders')
            ->leftJoinWith('Products')
            ->leftJoinWith('Products.Brands')
            //->enableAutoFields(true)
            ->where([
                'Orders.payment_status' => 2,
                //'OrderDetails.order_status_id IN' => [2, 3, 4]
            ]);

        if ($this->validDate($start) && $this->validDate($end)) {
            $datatable->where(function(\Cake\Database\Expression\QueryExpression $exp) use ($start, $end) {
                return $exp->gte('Orders.created', $start . ' 00:00:00')
                    ->lte('Orders.created', $end . ' 23:59:59');
            });
        }

        $datatable = $datatable
            ->group([
                'Products.brand_id',
            ])
            ->order([
                'total_sales' => 'DESC'
            ])
            ->limit($limit)
            ->map(function(\AdminPanel\Model\Entity\OrderDetailProduct $row) {
                $row->sector = $row->brand_name;
                $row->size = $row->total_sales;
                unset($row->brand_name);
                unset($row->total_sales);
                return $row;
            })
            ->toArray();

        return $datatable;
    }

    protected function byPeriod($start = null, $end = null, $limit = 10,  &$list_of_products = null)
    {

        //get date diff
        $type = null;
        if ($this->validDate($start) && $this->validDate($end)) {
            $time = Time::parse($start);
            $diff_days = $time->diffInDays(Time::parse($end));
            $diff_months = $time->diffInMonths(Time::parse($end));
            $diff_years = $time->diffInYears(Time::parse($end));

            if ($diff_days && $diff_months && $diff_years) {
                $type = 'year';
            } else if ($diff_days && $diff_months) {
                $type = 'month';
            } else {
                $type = 'day';
            }

        }


        $datatable = $this->OrderDetailProducts->find();
        $datatable->select([
            'value' => $datatable->func()->count('OrderDetailProducts.product_id'),
            'year' => $datatable->func()->year([
                'Orders.created' => 'identifier'
            ]),
            'month' => $datatable->func()->month([
                'Orders.created' => 'identifier'
            ]),
            'day' => $datatable->func()->day([
                'Orders.created' => 'identifier'
            ])
        ])
        ->leftJoinWith('Products')
        ->leftJoinWith('OrderDetails')
        ->leftJoinWith('OrderDetails.Orders')
            ->where([
                'Orders.payment_status' => 2,
                //'OrderDetails.order_status_id IN' => [2, 3, 4]
            ]);

        if ($this->validDate($start) && $this->validDate($end)) {
            $datatable->where(function(\Cake\Database\Expression\QueryExpression $exp) use ($start, $end) {
                return $exp->gte('Orders.created', $start . ' 00:00:00')
                    ->lte('Orders.created', $end . ' 23:59:59');
            });
        }

        //$datatable->group(['product_id']);

        switch ($type) {
            case 'year':
                $datatable->group(['year'])
                    ->limit(10);
                break;
            case 'month':
                $datatable->group(['month', 'year'])
                    ->limit(12);
                break;
            case 'day':
                $datatable->group(['day', 'month', 'year'])
                    ->limit(31);
                break;
        }

        $datatable
            ->order([
                'Orders.created' => 'ASC'
            ]);

        $datatable = $datatable
            ->map(function(\AdminPanel\Model\Entity\OrderDetailProduct $row) use($type, &$list_of_products, $limit) {
                switch ($type) {
                    case 'year':
                        $row->name = $row->year;
                        break;
                    case 'month':
                        $row->name = date('M Y', strtotime($row->year . '-' . $row->month . '-' . $row->day));
                        break;
                    case 'day':
                        $row->name = date('d M', strtotime($row->year . '-' . $row->month . '-' . $row->day));
                        break;
                }

                //list of products
                $products = $this->OrderDetailProducts->find();
                $products = $products
                    ->select([
                        'total' => $products->func()->count('OrderDetailProducts.product_id'),
                        'product_name' => 'Products.name',
                        'product_id' => 'OrderDetailProducts.product_id',
                        'year' => $products->func()->year([
                            'Orders.created' => 'identifier'
                        ]),
                        'month' => $products->func()->month([
                            'Orders.created' => 'identifier'
                        ]),
                        'day' => $products->func()->day([
                            'Orders.created' => 'identifier'
                        ])
                    ])
                    ->leftJoinWith('Products')
                    ->leftJoinWith('OrderDetails')
                    ->leftJoinWith('OrderDetails.Orders')
                    ->where([
                        'Orders.payment_status' => 2
                    ]);

                switch ($type) {
                    case 'year':
                        $products->where([
                            'YEAR(Orders.created)' => $row->year
                        ]);
                        $products->group(['year']);
                        break;
                    case 'month':
                        $products->where([
                            'YEAR(Orders.created)' => $row->year,
                            'MONTH(Orders.created)' => $row->month,
                        ]);
                        $products->group(['month', 'year']);
                        break;
                    case 'day':
                        $products->where([
                            'DATE(Orders.created)' => $row->year . '-' . $row->month . '-' . $row->day
                        ]);
                        $products->group(['day', 'month', 'year']);
                        break;
                }
                $products->group('OrderDetailProducts.product_id')
                    ->orderDesc('total')
                    ->limit($limit);

                if (!$products->isEmpty()) {
                    foreach($products as $product) {
                        if (!array_key_exists($product->product_id, $list_of_products)) {
                            $list_of_products[$product->product_id] = $product->product_name;
                        }
                        $row->{$product->product_id} = $product->total;
                    }
                }

                unset($row->year);
                unset($row->month);
                unset($row->day);
                return $row;
            })
            ->toArray();

        return $datatable;
    }



}
