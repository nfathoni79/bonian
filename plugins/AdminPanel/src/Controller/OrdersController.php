<?php
namespace AdminPanel\Controller;

use AdminPanel\Controller\AppController;

/**
 * Orders Controller
 * @property \AdminPanel\Model\Table\OrdersTable $Orders
 * @property \AdminPanel\Model\Table\OrderShippingDetailsTable $OrderShippingDetails
 * @property \AdminPanel\Model\Table\TransactionsTable $Transactions
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
    }


    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {


        if ($this->request->is('ajax')) {
            $this->viewBuilder()->setLayout('ajax');

            $pagination = $this->request->getData('pagination');
            $sort = $this->request->getData('sort');
            $query = $this->request->getData('query');

            /** custom default query : select, where, contain, etc. **/
            $data = $this->Orders->find('all')
                ->select()
                ->contain([
                   'Customers',
                    'Transactions'
                ]);

            if ($query && is_array($query)) {
                if (isset($query['generalSearch'])) {
                    $search = $query['generalSearch'];
                    unset($query['generalSearch']);
                    /**
                        custom field for general search
                        ex : 'Users.email LIKE' => '%' . $search .'%'
                    **/
                    //$data->where(['Orders.invoice LIKE' => '%' . $search .'%']);
                    $data->where(function(\Cake\Database\Expression\QueryExpression $exp) use($search) {
                        $orConditions = $exp->or_([
                            'Orders.invoice LIKE' => '%' . $search .'%',
                            'Customers.email LIKE' => '%' . $search .'%',
                        ]);
                        return $exp
                            ->add($orConditions);
                    });
                }
                $data->where($query);
            }

            if (isset($sort['field']) && !empty($sort['field']) && isset($sort['sort'])) {
                $data->order([$sort['field'] => $sort['sort']]);
            }

            if (isset($pagination['perpage']) && is_numeric($pagination['perpage'])) {
                $data->limit($pagination['perpage']);
            }
            if (isset($pagination['page']) && is_numeric($pagination['page'])) {
                $data->page($pagination['page']);
            }

            $total = $data->count();

            $result = [];
            $result['data'] = $data->toArray();


            $result['meta'] = array_merge((array) $pagination, (array) $sort);
            $result['meta']['total'] = $total;


            return $this->response->withType('application/json')
            ->withStringBody(json_encode($result));
        }


        $this->set(compact('orders'));
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
                ]
            ]
        ]);



        if ($this->request->is(['patch', 'post', 'put'])) {
            //$order = $this->Orders->patchEntity($order, $this->request->getData());
            //if ($this->Orders->save($order)) {
            //    $this->Flash->success(__('The order has been saved.'));

            //    return $this->redirect(['action' => 'index']);
            //}
//            debug($this->request->getData('origin'));
//            exit;
            foreach($order->order_details as $detail) {
                foreach($this->request->getData('origin') as $origin => $shipping) {
                    if(!empty($shipping['order_status_id'])){
                        if ($detail->get('branch_id') == $origin) {
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
                                        'message' => vsprintf('Order dengan invoice %s sudah selesai ', [
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
