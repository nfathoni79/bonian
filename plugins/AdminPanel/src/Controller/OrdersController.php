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
                        'Customers.email LIKE ' => '%'.general.'%',
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
                                        $this->ProductRatings->save($saveRatting);

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
