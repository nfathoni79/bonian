<?php
namespace AdminPanel\Controller;

use AdminPanel\Controller\AppController;
use Cake\Core\Configure;

/**
 * Orders Controller
 * @property \AdminPanel\Model\Table\OrdersTable $Orders
 * @property \AdminPanel\Model\Table\OrderShippingDetailsTable $OrderShippingDetails
 * @property \AdminPanel\Model\Table\TransactionsTable $Transactions
 * @property \AdminPanel\Model\Table\ProductRatingsTable $ProductRatings
 * @property \AdminPanel\Model\Table\CustomerShareProductsTable $CustomerShareProducts
 * @method \AdminPanel\Model\Entity\Order[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OrdersController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadModel('AdminPanel.Orders');
        $this->loadModel('AdminPanel.OrderShippingDetails');
        $this->loadModel('AdminPanel.Transactions');
        $this->loadModel('AdminPanel.ProductRatings');
        $this->loadModel('AdminPanel.CustomerShareProducts');
    }


    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {

        $general = $this->request->getData('general'); //invoice, email, customer name
        $type = $this->request->getData('type');
        $created = $this->request->getData('created');
        $status = $this->request->getData('status');
        if ($this->DataTable->isAjax()) {

            $datatable = $this->DataTable->adapter('AdminPanel.Orders')
                ->contain([
                    'Provinces',
                    'Cities',
                    'Subdistricts',
                    'Customers',
                    'Transactions',
                    'Vouchers',
                    'OrderDetails' => [
                        'Branches',
                        'OrderStatuses',
                        'Provinces',
                        'Cities',
                        'Subdistricts',
                        'OrderDetailProducts' => [
                            'Products' => [
                                'ProductImages'
                            ],
                            'ProductOptionPrices' => [
                                'ProductOptionValueLists' => [
                                    'Options',
                                    'OptionValues'
                                ],
                            ],
                        ]
                    ],
//                    'OrderDigitals' => [
//                        'DigitalDetails'
//                    ],
                ]);

            if($general){
                if($general){
                    $datatable->where(['OR' => [
                        'Orders.invoice LIKE ' => '%'.$general.'%',
                        'Customers.email LIKE ' => '%'.$general.'%',
                        'Customers.first_name LIKE ' => '%'.$general.'%',
                    ]]);
                }
            }
            if($type){ 
                $datatable->where(['Orders.order_type' => $type]);
            }
            if($created){
                $datatable->where(['DATE(Orders.created)' => $created]);
            }
            if($status){
                $datatable->where(['Orders.payment_status' => $status]);
            }

            $result = $datatable
                ->setSorting()
                ->getTable()
                ->map(function (\AdminPanel\Model\Entity\Order $row) {
                    return $row;
                })
                ->toArray();



            //set again datatable
            $datatable->setData($result);
            return $datatable->response();
        }

    }

    /**
     * View method
     *
     * @param string|null $id Order id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->viewBuilder()->setLayout('ajax');
        $order = $this->Orders->get($id, [
            'contain' => [
                'Provinces',
                'Cities',
                'Subdistricts',
                'Customers',
                'OrderDetails' => [
                    'Branches',
                    'OrderStatuses',
                    'OrderDetailProducts' => [
                        'Products' => [
                            'ProductImages'
                        ],
                        'ProductOptionPrices' => [
                            'ProductOptionValueLists' => [
                                'Options',
                                'OptionValues'
                            ],
                        ],
                    ]
                ]
            ]
        ]);

        //debug($order);exit;

        $this->set('order', $order);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        return $this->redirect(['action' => 'index']);
        /*
        $order = $this->Orders->newEntity();
        if ($this->request->is('post')) {
            $order = $this->Orders->patchEntity($order, $this->request->getData());
            if ($this->Orders->save($order)) {
                $this->Flash->success(__('The order has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The order could not be saved. Please, try again.'));
        }
        $this->set(compact('order'));
        */
    }

    /**
     * Edit method
     *
     * @param string|null $id Order id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        /**
         * @var \AdminPanel\Model\Entity\Order $order
         */
        $order = $this->Orders->get($id, [
            'contain' => [
                'Provinces',
                'Cities',
                'Subdistricts',
                'Customers',
                'Transactions',
                'Vouchers',
                'OrderDetails' => [
                    'Branches',
                    'OrderStatuses',
                    'Provinces',
                    'Cities',
                    'Subdistricts',
                    'OrderDetailProducts' => [
                        'Products' => [
                            'ProductImages' => [
                                'fields' => [
                                    'name',
                                    'product_id',
                                ],
                                'sort' => ['ProductImages.primary' => 'DESC','ProductImages.created' => 'ASC']
                            ]
                        ],
                        'ProductOptionPrices' => [
                            'ProductOptionValueLists' => [
                                'Options',
                                'OptionValues'
                            ],
                        ],
                    ]
                ],
                'OrderDigitals' => [
                    'DigitalDetails'
                ],
            ]
        ]);



        if ($this->request->is(['patch', 'post', 'put'])) {
//            Configure::write('debug',true);
            //$order = $this->Orders->patchEntity($order, $this->request->getData());
            //if ($this->Orders->save($order)) {
            //    $this->Flash->success(__('The order has been saved.'));

            //    return $this->redirect(['action' => 'index']);
            //}

            //process bonus product entity
            $selected_products = [];
            $total_products = 0;
            /**
             * @var \AdminPanel\Model\Entity\CustomerShareProduct $shareProductEntity
             */
            $shareProductEntity = $this->CustomerShareProducts->find()
                ->where([
                    'order_id' => $order->id,
                    'credited' => 0
                ])
                ->first();
            //process bonus product entity

            foreach($order->order_details as $detail) {
                foreach($this->request->getData('origin') as $origin => $shipping) {
                    if (!empty($shipping['order_status_id'])) {
                        if($shipping['order_status_id'] == 4) {
                            //check share products
                            if ($shareProductEntity) {
                                foreach($detail->order_detail_products as $detail_product) {
                                    if ($shareProductEntity->product_id == $detail_product->product_id) {
                                        $selected_products = [
                                            'customer_id' => $shareProductEntity->customer_id,
                                            'product_id' => $detail_product->product_id,
                                            'price' => $detail_product->price,
                                            'qty' => $detail_product->qty,
                                        ];
                                    }
                                    /*if (!array_key_exists($detail_product->product_id, $total_products)) {
                                        $total_products[$detail_product->product_id] = $detail_product->qty;
                                    } else {
                                        $total_products[$detail_product->product_id] += $detail_product->qty;
                                    }*/
                                    $total_products += (int) $detail_product->qty;
                                }
                            }
                            //check share products
                        }
                    }
                }
            }

            foreach($order->order_details as $detail) {
                foreach($this->request->getData('origin') as $origin => $shipping) {
                    if(!empty($shipping['order_status_id'])){
                        if ($detail->get('branch_id') == $origin) {


                            /* Sementara menunggu IPN dari JNE */
                            /* Pemberian ratting produk ketika selesai order ke table ProductRatings */
                            if($shipping['order_status_id'] == 4){
                                foreach($detail->order_detail_products as $vals){
                                    $check = $this->ProductRatings->find()
                                        ->where([
                                            'order_id' => $detail->order_id,
                                            'product_id' => $vals->product_id,
                                        ])->first();
                                    if(empty($check)){
                                        $saveRatting = $this->ProductRatings->newEntity([
                                            'order_id' =>  $detail->order_id,
                                            'product_id' => $vals->product_id,
                                            'customer_id' => $order->get('customer_id'),
                                            'rating' => 0,
                                            'status' => 0,
                                        ]);
                                        if($this->ProductRatings->save($saveRatting)){

                                            if ($this->Notification->create(
                                                $order->customer_id,
                                                '1',
                                                'Ulasan Produk',
                                                'Silahkan memberikan ulasan produk '.$vals->product->name,
                                                'Products',
                                                $vals->product->id,
                                                2,
                                                Configure::read('mainSite').'/images/70x59/'. $vals->product->product_images[0]->name,
                                                Configure::read('frontsite').'user/history?status=semua&page=1&start=&search='.$order->invoice
                                            )) {

                                                $this->Notification->triggerCount(
                                                    $order->customer_id,
                                                    $order->customer->reffcode
                                                );
                                            }
                                        }

                                    }
                                }


                            }
                            /* END SEMENTARA */

                            $detail = $this->Orders->OrderDetails->patchEntity($detail, $shipping);
                            if ($this->Orders->OrderDetails->save($detail)) {


                                $query = $this->OrderShippingDetails->query();
                                $query->update()
                                    ->set(['status' => $shipping['order_status_id']])
                                    ->where([
                                        'order_detail_id' => $detail->get('id'),
                                    ])
                                    ->execute();

                                $templates = [
                                    3 => [
                                        'title' => 'Status Pengiriman',
                                        'message' => vsprintf('Order dengan invoice %s sudah dikirim dengan nomor resi %', [
                                            $order->invoice,
                                            $shipping['awb']
                                        ])
                                    ],
                                    4 => [
                                        'title' => 'Status Pengiriman',
                                        'message' => vsprintf('Order dengan invoice %s sudah selesai, Silahkan memberikan ulasan untuk produk tersebut. ', [
                                            $order->invoice
                                        ])
                                    ],
                                ];

                                if (isset($templates[$shipping['order_status_id']])) {
                                    $template = $templates[$shipping['order_status_id']];
                                    if ($this->Notification->create(
                                        $order->customer_id,
                                        '1',
                                        $template['title'],
                                        $template['message'],
                                        'Orders',
                                        $order->id,
                                        1,
                                        $this->Notification->getImageConfirmationPath(),
                                        '/user/history/detail/' . $order->invoice
                                    )) {

                                        $this->Notification->triggerCount(
                                            $order->customer_id,
                                            $order->customer->reffcode
                                        );
                                    }

									/* MAILER SHIPPING */
                                    $statusShiping = [3 => 'dikirimkan', 4 => 'sampai'];
                                    $this->Mailer
                                        ->setVar([
                                            'orderEntity' => $order,
                                            'awb' => $shipping['awb'],
                                            'send_date' => date('d-m-Y'),
                                            'courier' => $detail->shipping_code,
                                            'transactionEntity' => $order->transactions,
                                            'status' => $statusShiping[$shipping['order_status_id']]
                                        ])
                                        ->send(
                                            $order->customer->email,
                                            'Konfirmasi pengiriman',
                                            'order_shipping'
                                        );

                                }


                                $this->Flash->success(__('The order has been saved.'));
                            } else {
                                $this->Flash->error(__('The order could not be saved. Please, try again.'));
                            }
                            break;
                        }
                    }
                }
            }

            //processing share products

            if ($selected_products && $total_products > 0) {
                $reductions = [
                    'voucher' => $order->discount_voucher / $total_products,
                    'point' => $order->use_point / $total_products,
                    'coupon' => 0 //TODO check coupon detail
                ];

                $sharing_percentage = Configure::read('sharing_percentage', 0.01);
                $bonus_point = $sharing_percentage *
                    ($selected_products['price'] * $selected_products['qty'] - $reductions['voucher'] - $reductions['point'] - $reductions['coupon']);

                $bonus_point = floor($bonus_point); //pembulatan kebawah
                if ($this->Orders
                    ->Customers
                    ->CustomerMutationPoints
                    ->saving(
                        $selected_products['customer_id'],
                        3,
                        intval($bonus_point),
                        'bonus point sharing product'
                    )) {
                    $shareProductEntity->set('credited', 1);
                    $this->CustomerShareProducts->save($shareProductEntity);
                }
            }
            //processing share products

        }
//        $order_detail_statuses = $this->Orders->OrderDetails->OrderStatuses->find('list');
        $order_detail_statuses = [
            '3' => 'Dikirim',
            '4' => 'Selesai',
        ];
        //debug($order);exit;
        $this->set(compact('order', 'order_detail_statuses'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Order id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $order = $this->Orders->get($id);
        try {
            if ($this->Orders->delete($order)) {
                $this->Flash->success(__('The order has been deleted.'));
            } else {
                $this->Flash->error(__('The order could not be deleted. Please, try again.'));
            }
        } catch (Exception $e) {
            $this->Flash->error(__('The order could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
