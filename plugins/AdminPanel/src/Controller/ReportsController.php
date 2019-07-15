<?php
namespace AdminPanel\Controller;

use AdminPanel\Controller\AppController;
use Cake\Core\Configure;
use Cake\Database\Expression\IdentifierExpression;
use Cake\Database\Expression\QueryExpression;
use Cake\I18n\Number;
use DateTime;
use Cake\I18n\Time;

/**
 * Reports Controller
 * @property \AdminPanel\Model\Table\ProductsTable $Products
 * @property \AdminPanel\Model\Table\ProductRatingsTable $ProductRatings
 * @property \AdminPanel\Model\Table\CustomerCartsTable $CustomerCarts
 * @property \AdminPanel\Model\Table\CustomerCartDetailsTable $CustomerCartDetails
 * @property \AdminPanel\Model\Table\OrdersTable $Orders
 * @property \AdminPanel\Model\Table\CustomerMutationPointsTable $CustomerMutationPoints
 * @property \AdminPanel\Model\Table\CustomerMutationPointTypesTable $CustomerMutationPointTypes
 * @property \AdminPanel\Model\Table\ShareStatisticsTable $ShareStatistics
 *
 * @method \AdminPanel\Model\Entity\Report[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ReportsController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadModel('AdminPanel.Products');
        $this->loadModel('AdminPanel.ProductRatings');
        $this->loadModel('AdminPanel.CustomerCarts');
        $this->loadModel('AdminPanel.CustomerCartDetails');
        $this->loadModel('AdminPanel.Orders');
        $this->loadModel('AdminPanel.CustomerMutationPoints');
        $this->loadModel('AdminPanel.CustomerMutationPointTypes');
        $this->loadModel('AdminPanel.ShareStatistics');
    }

    public function share(){
        $datestart = $this->request->getQuery('start');
        $dateend = $this->request->getQuery('end');

        if (empty($datestart) || empty ($dateend)) {
            $dateend = date("Y-m-d");
            $datestart = date("Y-m-d",strtotime(date("Y-m-d", strtotime($dateend)) . " -2 week"));
        }

        $by_periods = $this->byPeriodShare($datestart, $dateend);
        $this->set(compact('by_periods'));
    }

    protected function byPeriodShare($start = null, $end = null)
    {


        $datatable = $this->ShareStatistics->find()
            ->where(['media_type IN ' => ['tw','fb','sms','wa', 'ln']])
            ->group(['media_type']);
        $datatable->select([
            'not_clicked' => $datatable->func()->sum("IF(ShareStatistics.clicked = 0, 1, 0)"),
            'clickeds' => $datatable->func()->sum("IF(ShareStatistics.clicked = 1, 1, 0)"),
            'type' => 'media_type',
            'year' => $datatable->func()->year([
                'ShareStatistics.created' => 'identifier'
            ]),
            'month' => $datatable->func()->month([
                'ShareStatistics.created' => 'identifier'
            ]),
            'day' => $datatable->func()->day([
                'ShareStatistics.created' => 'identifier'
            ])
        ]);

        if ($this->validDate($start) && $this->validDate($end)) {
            $datatable->where(function(\Cake\Database\Expression\QueryExpression $exp) use ($start, $end) {
                return $exp->gte('ShareStatistics.created', $start . ' 00:00:00')
                    ->lte('ShareStatistics.created', $end . ' 23:59:59');
            });
        }

        $datatable->group(['month', 'year']);

        $datatable = $datatable
            ->order([
                'ShareStatistics.created' => 'ASC'
            ])
            ->map(function(\AdminPanel\Model\Entity\ShareStatistic $row)  {

                switch ($row['type']) {
                    case 'wa':
                        $row->name = date('M Y', strtotime($row->year . '-' . $row->month . '-' . $row->day)).' Whatsapp';
                        break;
                    case 'tw':
                        $row->name = date('M Y', strtotime($row->year . '-' . $row->month . '-' . $row->day)).' Twitter';
                        $row->not_clicked = floor($row->not_clicked / 2);
                        break;
                    case 'fb':
                        $row->name = date('M Y', strtotime($row->year . '-' . $row->month . '-' . $row->day)).' Facebook';
                        $row->not_clicked = floor($row->not_clicked / 2);
                        break;
                    case 'sms':
                        $row->name = date('M Y', strtotime($row->year . '-' . $row->month . '-' . $row->day)).' Sms';
                        break;
                    case 'ln':
                        $row->name = date('M Y', strtotime($row->year . '-' . $row->month . '-' . $row->day)).' Line';
                        $row->not_clicked = floor($row->not_clicked / 2);
                        break;
                }

                return $row;
            })
            ->toArray();
        return $datatable;
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function review()
    {
        if ($this->DataTable->isAjax()) {
            $datatable = $this->DataTable->adapter('AdminPanel.Products')
                ->select([
                    'id',
                    'name',
                    'sku',
                    'rating',
                    'rating_count',
                    'modified',
                ])
                ->contain([
                    'ProductRatings'
                ])
                ->where(['Products.rating_count > ' => 0])
                ->search(function ($search, \Cake\Database\Expression\QueryExpression $exp) {
                    $orConditions = $exp->or_([
                        'Products.name LIKE' => '%' . $search .'%',
                        'Products.sku LIKE' => '%' . $search .'%',
//                        'Products.rating_count LIKE' => '%' . $search .'%'
                    ]);
                    return $exp
                        ->add($orConditions);
                })
            ;

            $result = $datatable
                ->setSorting()
                ->getTable()->map(function (\AdminPanel\Model\Entity\Product $row) {
                    $row->count_review = count($row->product_ratings);
                    return $row;
                })
                ->toArray();
            //set again datatable
            $datatable->setData($result);
            return $datatable->response();
        }
    }

    public function listReview($id = null){

        if ($this->DataTable->isAjax()) {
            $datatable = $this->DataTable->adapter('AdminPanel.ProductRatings')
                ->contain([
                    'Customers' => [
                        'fields' => [
                            'id',
                            'first_name',
                            'last_name',
                        ]
                    ]
                ])
                ->search(function ($search, \Cake\Database\Expression\QueryExpression $exp) {
                    $orConditions = $exp->or_([
                        'Customers.first_name LIKE' => '%' . $search .'%',
                        'Customers.last_name LIKE' => '%' . $search .'%',
                        'ProductRatings.comment LIKE' => '%' . $search .'%',
                    ]);
                    return $exp
                        ->add($orConditions);
                })
                ->where(['ProductRatings.product_id' => $id]);

            $result = $datatable
                ->setSorting()
                ->getTable()
                ->toArray();
            //set again datatable
            $datatable->setData($result);
            return $datatable->response();
        }


    }


    public function deleteReview($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $rating = $this->ProductRatings->get($id);
        try {
            if ($this->ProductRatings->delete($rating)) {
                $this->Flash->success(__('The product review has been deleted.'));
            } else {
                $this->Flash->error(__('The product review  could not be deleted. Please, try again.'));
            }
        } catch (Exception $e) {
            $this->Flash->error(__('The product review  could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'review']);
    }



    public function abandoned(){

        /* PERIODE FIRST */
        if(!empty($this->request->getQuery('start')) && !empty($this->request->getQuery('end'))){
            $dateend = $this->request->getQuery('end');
            $datestart = $this->request->getQuery('start');
        }else{
            $dateend = date("Y-m-d");
            $datestart = date("Y-m-d",strtotime(date("Y-m-d", strtotime($dateend)) . " -2 week"));
        }
        if ($this->DataTable->isAjax()) {
            $datatable = $this->DataTable->adapter('AdminPanel.CustomerCartDetails')
                ->contain([
                    'Products' => [
                        'fields' => [
                            'id',
                            'name',
                            'view',
                            'sku',
                        ]
                    ],
                    'ProductOptionPrices'
                ])
                ->search(function ($search, \Cake\Database\Expression\QueryExpression $exp) {
                    $orConditions = $exp->or_([
                        'Products.name LIKE' => '%' . $search .'%',
                        'Products.sku LIKE' => '%' . $search .'%',
                    ]);
                    return $exp
                        ->add($orConditions);
                })
                ->where(['CustomerCartDetails.status NOT IN' => [1,4]]);

            $datatable->where(function(\Cake\Database\Expression\QueryExpression $exp) use ($datestart, $dateend) {
                return $exp->gte('CustomerCartDetails.created', $datestart . ' 00:00:00')
                    ->lte('CustomerCartDetails.created', $dateend . ' 23:59:59');
            });

            $result = $datatable
                ->setSorting()
                ->getTable()
                ->toArray();
            //set again datatable
            $datatable->setData($result);
            return $datatable->response();
        }


        $Query = $this->CustomerCartDetails
            ->find()
            ->where(['CustomerCartDetails.status NOT IN ' => [1,4]]);
        $Query->where(function(\Cake\Database\Expression\QueryExpression $exp) use ($datestart, $dateend) {
            return $exp->gte('CustomerCartDetails.created', $datestart . ' 00:00:00')
                ->lte('CustomerCartDetails.created', $dateend . ' 23:59:59');
        });
        $res = $Query->select([
            'total' => $Query->func()->sum('total'),
            'items' => $Query->func()->sum('qty'),
        ])->first();
        $abandoneReveneu = $res->total;
        $abandoneItems = $res->items;


        $Query = $this->CustomerCartDetails
            ->find()
            ->where(['CustomerCartDetails.status' => 4]);
        $Query->where(function(\Cake\Database\Expression\QueryExpression $exp) use ($datestart, $dateend) {
            return $exp->gte('CustomerCartDetails.created', $datestart . ' 00:00:00')
                ->lte('CustomerCartDetails.created', $dateend . ' 23:59:59');
        });
        $result = $Query->select([
            'total' => $Query->func()->sum('total'),
            'items' => $Query->func()->sum('qty'),
        ])->first();

        $successReveneu = $result->total;
        $successItems = $result->items;


        $cart = $this->CustomerCarts
            ->find('all')
            ->where(['CustomerCarts.status IN ' => [2]]);

        $cart->where(function(\Cake\Database\Expression\QueryExpression $exp) use ($datestart, $dateend) {
            return $exp->gte('CustomerCarts.created', $datestart . ' 00:00:00')
                ->lte('CustomerCarts.created', $dateend . ' 23:59:59');
        });
        $abandonedCart = $cart->count();

        $sumAllOrders = $this->CustomerCarts
            ->find('all')
            ->where(['CustomerCarts.status NOT IN ' => [1,2]]);
        $sumAllOrders->where(function(\Cake\Database\Expression\QueryExpression $exp) use ($datestart, $dateend) {
            return $exp->gte('CustomerCarts.created', $datestart . ' 00:00:00')
                ->lte('CustomerCarts.created', $dateend . ' 23:59:59');
        });
        $countOrders = $sumAllOrders->count();


        $abandoneRate = ( $abandonedCart / ($countOrders + $abandonedCart)  ) * 100;





        $newList = [];
        foreach($this->createRange($datestart, $dateend) as $k => $vals){
            $newList[$k]['date'] = $vals;
            $findStatsTotal = $this->CustomerCarts
                ->find('all')
                ->where([
                    'DATE(CustomerCarts.created)' => $vals,
                    'CustomerCarts.status NOT IN ' => [1,2]
                ]);
            $laku = $findStatsTotal->count();

            $findStatsTotal = $this->CustomerCarts
                ->find('all')
                ->where([
                    'DATE(CustomerCarts.created)' => $vals,
                    'CustomerCarts.status IN ' => [2]
                ]);
            $galaku = $findStatsTotal->count();

            $percent = @($galaku / ($galaku + $laku) * 100);
            if(is_nan($percent)){
                $percent = 0;
            }else{
                $percent = $percent;
            }

            $newList[$k]['value'] = bcdiv((string)$percent, 1, 2);


        }

        $this->set(compact('abandoneReveneu','abandoneItems', 'abandonedCart','abandoneRate','countOrders','datestart','dateend','newList', 'successReveneu', 'successItems'));


    }

    private function createRange($start, $end, $format = 'Y-m-d') {
        $start  = new DateTime($start);
        $end    = new DateTime($end);
        $invert = $start > $end;

        $dates = array();
        $dates[] = $start->format($format);
        while ($start != $end) {
            $start->modify(($invert ? '-' : '+') . '1 day');
            $dates[] = $start->format($format);
        }
        return $dates;
    }

    public function bestView(){

        if ($this->DataTable->isAjax()) {

            $query = $this->Products->find();
            $query = $query->select(['total' => $query->func()->sum('Products.view')])->first();
            $totalView = $query->total;


            $datatable = $this->DataTable->adapter('AdminPanel.Products')
                ->contain([
                ])
                ->search(function ($search, \Cake\Database\Expression\QueryExpression $exp) {
                    $orConditions = $exp->or_([
                        'Products.name LIKE' => '%' . $search .'%',
                        'Products.sku LIKE' => '%' . $search .'%',
//                        'Products.model LIKE' => '%' . $search .'%',
//                        'Products.view LIKE' => '%' . $search .'%',
                    ]);
                    return $exp
                        ->add($orConditions);
                })
                ->where(['Products.view > ' => 0 ])
                ->order(['Products.view' => 'DESC']) ;

            $result = $datatable
                ->setSorting()
                ->getTable()
                ->map(function (\AdminPanel\Model\Entity\Product $row) use($totalView){
                    $row->percent = Number::toPercentage(( $row-> view / $totalView)* 100);
                    return $row;
                })
                ->toArray();
            //set again datatable
            $datatable->setData($result);
            return $datatable->response();
        }


        $products = $this->Products->find()
            ->select(['name','view'])
            ->where(['Products.view > ' => 0 ])
            ->order(['Products.view' => 'DESC'])
            ->limit(10)
            ->all()->toArray();
        $this->set(compact('products'));


    }


    public function couponAndPoint(){

        $datestart = $this->request->getQuery('start');
        $dateend = $this->request->getQuery('end');

        //if (empty($datestart) || empty ($dateend)) {
        //    $dateend = date("Y-m-d");
        //    $datestart = date("Y-m-d",strtotime(date("Y-m-d", strtotime($dateend)) . " -2 week"));
        //}

        $dateend = $dateend ? $dateend : date("Y-m-d");
        $datestart = $datestart ? $datestart : date("Y-m-d",strtotime(date("Y-m-d", strtotime($dateend)) . " -2 week"));

        if ($this->DataTable->isAjax()) {

            $range = $this->Orders->find();
            $range = $range
                ->select([
                    'min' => $range->func()->min('Orders.created'),
                    'max' => $range->func()->max('Orders.created'),
                ])
                ->where([
                    'Orders.payment_status' => 2
                ])
                ->where(function(\Cake\Database\Expression\QueryExpression $exp) {
                    return $exp->gt('Orders.discount_kupon', 0);
                });


            if ($datestart && $dateend) {
                $range->where(function(\Cake\Database\Expression\QueryExpression $exp) use ($datestart, $dateend) {
                    return $exp->gte('Orders.created', $datestart . ' 00:00:00')
                        ->lte('Orders.created', $dateend . ' 23:59:59');
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





            $datatable = $this->DataTable->adapter('AdminPanel.Orders');
            $datatable = $datatable->select([
                'name' => 'Orders.created',
                'item_sales' => $datatable->getTable()->func()->count('Orders.id'),
                'coupon' => $datatable->getTable()->func()->sum('Orders.discount_kupon'),
                'year' => $datatable->getTable()->func()->year([
                    'Orders.created' => 'identifier'
                ]),
                'month' => $datatable->getTable()->func()->month([
                    'Orders.created' => 'identifier'
                ]),
                'day' => $datatable->getTable()->func()->day([
                    'Orders.created' => 'identifier'
                ])
            ]);



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

            $result = $datatable
                ->setSorting()
                ->getTable()
                ->where([
                    'Orders.payment_status' => 2
                ])
                ->where(function(\Cake\Database\Expression\QueryExpression $exp) {
                    return $exp->gt('Orders.discount_kupon', 0);
                });


            if ($datestart && $dateend) {
                $result->where(function(\Cake\Database\Expression\QueryExpression $exp) use ($datestart, $dateend) {
                    return $exp->gte('Orders.created', $datestart . ' 00:00:00')
                        ->lte('Orders.created', $dateend . ' 23:59:59');
                });
            }


            $result = $result
                ->map(function (\AdminPanel\Model\Entity\Order $row) use($type) {
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

                    return $row;
                })
                ->toArray();

            //set again datatable
            $datatable->setData($result);
            return $datatable->response();
        }

        $by_periods = $this->byPeriod($datestart, $dateend);
        $this->set(compact('by_periods'));
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

    protected function byPeriod($start = null, $end = null)
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

        $datatable = $this->CustomerMutationPoints->find();
        $datatable->select([
            'plus' => $datatable->func()->sum("IF(CustomerMutationPoints.amount > 0, CustomerMutationPoints.amount, 0)"),
            'minus' => $datatable->func()->sum("ABS(IF(CustomerMutationPoints.amount < 0, CustomerMutationPoints.amount, 0))"),
            'year' => $datatable->func()->year([
                'CustomerMutationPoints.created' => 'identifier'
            ]),
            'month' => $datatable->func()->month([
                'CustomerMutationPoints.created' => 'identifier'
            ]),
            'day' => $datatable->func()->day([
                'CustomerMutationPoints.created' => 'identifier'
            ])
        ]);

        if ($this->validDate($start) && $this->validDate($end)) {
            $datatable->where(function(\Cake\Database\Expression\QueryExpression $exp) use ($start, $end) {
                return $exp->gte('CustomerMutationPoints.created', $start . ' 00:00:00')
                    ->lte('CustomerMutationPoints.created', $end . ' 23:59:59');
            });
        }

        switch ($type) {
            case 'year':
                $datatable->group(['year']);
                break;
            case 'month':
                $datatable->group(['month', 'year']);
                break;
            case 'day':
                $datatable->group(['month', 'year']);
                break;
        }

        $datatable = $datatable
            ->order([
                'CustomerMutationPoints.created' => 'ASC'
            ])
            ->map(function(\AdminPanel\Model\Entity\CustomerMutationPoint $row) use($type) {
                switch ($type) {
                    case 'year':
                        $row->name = date('M Y', strtotime($row->year . '-' . $row->month . '-' . $row->day));
                        break;
                    case 'month':
                        $row->name = date('M Y', strtotime($row->year . '-' . $row->month . '-' . $row->day));
                        break;
                    case 'day':
                        $row->name = date('M Y', strtotime($row->year . '-' . $row->month . '-' . $row->day));
                        break;
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
