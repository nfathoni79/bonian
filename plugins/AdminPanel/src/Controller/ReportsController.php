<?php
namespace AdminPanel\Controller;

use AdminPanel\Controller\AppController;
use Cake\Database\Expression\IdentifierExpression;
use Cake\Database\Expression\QueryExpression;
use Cake\I18n\Number;
use DateTime;

/**
 * Reports Controller
 * @property \AdminPanel\Model\Table\ProductsTable $Products
 * @property \AdminPanel\Model\Table\ProductRatingsTable $ProductRatings
 * @property \AdminPanel\Model\Table\CustomerCartsTable $CustomerCarts
 * @property \AdminPanel\Model\Table\CustomerCartDetailsTable $CustomerCartDetails
 * @property \AdminPanel\Model\Table\OrdersTable $Orders
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
                    'rating_count',
                    'modified',
                ])
                ->contain([
                    'ProductRatings'
                ])
                ->search(function ($search, \Cake\Database\Expression\QueryExpression $exp) {
                    $orConditions = $exp->or_([
                        'Products.name LIKE' => '%' . $search .'%',
                        'Products.modified LIKE' => '%' . $search .'%',
                        'Products.rating_count LIKE' => '%' . $search .'%',
                    ]);
                    return $exp
                        ->add($orConditions);
                })
                ->where(['Products.rating_count > ' => 0])
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
                    ]
                ])
                ->search(function ($search, \Cake\Database\Expression\QueryExpression $exp) {
                    $orConditions = $exp->or_([
//                        'Customers.first_name LIKE' => '%' . $search .'%',
//                        'Customers.last_name LIKE' => '%' . $search .'%',
//                        'ProductRatings.comment LIKE' => '%' . $search .'%',
                    ]);
                    return $exp
                        ->add($orConditions);
                })
                ->where(['CustomerCartDetails.status NOT IN' => [1,4]]);

            $result = $datatable
                ->setSorting()
                ->getTable()
                ->where(function ($exp) use($datestart,$dateend) {
                    return $exp->between('CustomerCartDetails.created', $datestart, $dateend);
                })
                ->group('product_id')
                ->map(function (\AdminPanel\Model\Entity\CustomerCartDetail $row) use($datestart, $dateend){
                    $sumAbandonedByProduct = $this->CustomerCartDetails->find('all')
                        ->where([
                            'CustomerCartDetails.status NOT IN ' => [1,4],
                            'CustomerCartDetails.product_id' => $row->product->id
                        ])
                        ->where([
                            'created BETWEEN :start AND :end'
                        ])
                        ->bind(':start', $datestart, 'date')
                        ->bind(':end',   $dateend, 'date')
                        ->group(['customer_cart_id']);

                    $row->abandoned_cart = $sumAbandonedByProduct->count();


                    $allAbandon = $this->CustomerCartDetails
                        ->find()
                        ->where([
                            'CustomerCartDetails.status NOT IN' => [1,4],
                            'CustomerCartDetails.product_id' => $row->product->id
                        ])
                        ->where([
                            'created BETWEEN :start AND :end'
                        ])
                        ->bind(':start', $datestart, 'date')
                        ->bind(':end',   $dateend, 'date');

                    $allRes = $allAbandon->select(['total' => $allAbandon->func()->sum('total')])->first();
                    $row->abandoned_revenue = $allRes->total;

                    $allAbandonRate = $this->CustomerCartDetails
                        ->find()
                        ->where([
                            'CustomerCartDetails.status NOT IN' => [1,4],
                            'CustomerCartDetails.product_id' => $row->product->id
                        ]);

                    $allResRate = $allAbandonRate->select(['total' => $allAbandonRate->func()->sum('total')])->first();
                    $row->abandoned_rate = ($allRes->total / $allResRate->total ) * 100;

                    return $row;
                })
                ->toArray();
            //set again datatable
            $datatable->setData($result);
            return $datatable->response();
        }


        $Query = $this->CustomerCartDetails
            ->find()
            ->where([
                'created BETWEEN :start AND :end'
            ])
            ->bind(':start', $datestart, 'date')
            ->bind(':end',   $dateend, 'date')
            ->where(['CustomerCartDetails.status NOT IN ' => [1,4]]);

        $res = $Query->select(['total' => $Query->func()->sum('total')])->first();

        $cart = $this->CustomerCarts
            ->find('all')
            ->where([
                'created BETWEEN :start AND :end'
            ])
            ->bind(':start', $datestart, 'date')
            ->bind(':end',   $dateend, 'date')
            ->where(['CustomerCarts.status' => 2]);

        $abandoneReveneu = $res->total;
        $abandonedCart = $cart->count();
        $allAbandon = $this->CustomerCartDetails
            ->find()
            ->where(['CustomerCartDetails.status NOT IN' => [1,4]]);

        $allRes = $allAbandon->select(['total' => $allAbandon->func()->sum('total')])->first();

        $abandoneRate = ( $abandoneReveneu / $allRes->total ) * 100;

        $sumAllOrders= $this->Orders->find('all')->where(['Orders.payment_status' => 2]);
        $countOrders = $sumAllOrders->count();

        $newList = [];
        foreach($this->createRange($datestart, $dateend) as $k => $vals){
            $newList[$k]['date'] = $vals;
            $findStatsTotal = $this->CustomerCartDetails
                ->find('all')
                ->where([
                    'DATE(CustomerCartDetails.created)' => $vals
                ]);
            $laku = $findStatsTotal->select(['total' => $findStatsTotal->func()->sum('total')])->where(['status IN ' => [1,4]])->first();

            $findStatsTotal = $this->CustomerCartDetails
                ->find('all')
                ->where([
                    'DATE(CustomerCartDetails.created)' => $vals
                ]);

            $galaku = $findStatsTotal->select(['totals' => $findStatsTotal->func()->sum('total')])->where(['status NOT IN ' => [1,4]])->first();
            $percent = @($galaku->totals / ($galaku->totals + $laku->total) * 100);
            if(is_nan($percent)){
                $percent = 0;
            }else{
                $percent = $percent;
            }

            $newList[$k]['value'] = $percent;


        }

        $this->set(compact('abandoneReveneu', 'abandonedCart','abandoneRate','countOrders','datestart','dateend','newList'));


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
}
