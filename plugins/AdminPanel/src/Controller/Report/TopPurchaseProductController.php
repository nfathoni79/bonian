<?php
namespace AdminPanel\Controller\Report;

use AdminPanel\Controller\AppController;

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

        $by_categories = $this->byCategory($start, $end);
        $by_brands = $this->byBrand($start, $end);

        $this->set(compact('by_categories', 'by_brands'));
    }

    protected function byCategory($start = null, $end = null)
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
            ->limit(10)
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

    public function byBrand($start = null, $end = null)
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
            ->limit(10)
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

    protected function byPeriod($start = null, $end = null)
    {

    }



}
