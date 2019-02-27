<?php
namespace App\Controller\V1;

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use Cake\Validation\Validator;
use Cake\ORM\Rule\IsUnique;


/**
 * Class CouriersController
 * @package App\Controller\V1
 * @property \AdminPanel\Model\Table\CustomersTable $Customers
 * @property \AdminPanel\Model\Table\CustomerBalancesTable $CustomerBalances
 * @property \AdminPanel\Model\Table\ProductCategoriesTable $ProductCategories
 */

class OrdersController  extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('AdminPanel.Customers');
        $this->loadModel('AdminPanel.CustomerBalances');
        $this->loadModel('AdminPanel.CustomerMutationAmounts');
        $this->loadModel('AdminPanel.CustomerMutationPoints');
        $this->loadModel('AdminPanel.CustomerAddreses');
        $this->loadModel('AdminPanel.ProductCategories');

    }

    public function shoppingcart(){
        $this->request->allowMethod('post');
        $response = [
            [
                'items' => [
                    [
                        'name' => 'Kemeja Kantor',
                        'desc' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry'
                    ]
                ],
                'price' => [
                    [
                        'regular_price' => '330000',
                        'sale_price' => '300000',
                        'add_price' => '10000'
                    ]
                ],
                'qty' => '2',
                'total' => '620000'
            ],
            [
                'items' => [
                    [
                        'name' => 'Kemeja Kantor',
                        'desc' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry'
                    ]
                ],
                'price' => [
                    [
                        'regular_price' => '330000',
                        'sale_price' => '300000',
                    ]
                ],
                'qty' => '2',
                'total' => '600000'
            ],
            [
                'items' => [
                    [
                        'name' => 'Kemeja Kantor',
                        'desc' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry'
                    ]
                ],
                'price' => [
                    [
                        'regular_price' => '330000',
                        'sale_price' => '300000',
                    ]
                ],
                'qty' => '2',
                'total' => '600000'
            ],
            [
                'items' => [
                    [
                        'name' => 'Kemeja Kantor',
                        'desc' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry'
                    ]
                ],
                'price' => [
                    [
                        'regular_price' => '330000',
                        'sale_price' => '300000',
                    ]
                ],
                'qty' => '2',
                'total' => '600000'
            ],
            'sub_total' => '2420000'
        ];
        $this->setResponse($this->response->withStatus(200));
        $this->set(compact('response'));
    }


    public function checkout(){
        $this->request->allowMethod('post');
        $response = [
            'left' => [
                'Shipping Address' => [
                    'destination' => 'Jalan Sanggar Kencana',
                    'subdistrict' => 'Kecamatan Buahbatu',
                    'city' => 'Bandung',
                    'province' => 'Jawa Barat',
                    'postal_code' => '40286',
                    'phone_number' => '081234567890',
                    'Shipping Service' => [
                        'courier' => [
                            [
                                'JNE - Regular Service',
                                'shipping_price' => '11000',
                                'estimation' => '2-3 days'
                            ],
                            [
                                'TIKI - Regular Service',
                                'shipping_price' => '11000',
                                'estimation' => '2-3 days'
                            ],
                            [
                                'JNT - Regular Service',
                                'shipping_price' => '11000',
                                'estimation' => '2-3 days'
                            ]
                        ]
                    ]
                ],
                'Item Detail' => [
                    [
                        'items' => [
                            [
                                'name' => 'Kemeja Kantor',
                                'desc' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry'
                            ]
                        ],
                        'price' => [
                            [
                                'regular_price' => '330000',
                                'sale_price' => '300000',
                                'add_price' => '10000'
                            ]
                        ],
                        'qty' => '2',
                        'total' => '620000'
                    ],
                    [
                        'items' => [
                            [
                                'name' => 'Kemeja Kantor',
                                'desc' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry'
                            ]
                        ],
                        'price' => [
                            [
                                'regular_price' => '330000',
                                'sale_price' => '300000',
                            ]
                        ],
                        'qty' => '2',
                        'total' => '600000'
                    ],
                    [
                        'items' => [
                            [
                                'name' => 'Kemeja Kantor',
                                'desc' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry'
                            ]
                        ],
                        'price' => [
                            [
                                'regular_price' => '330000',
                                'sale_price' => '300000',
                            ]
                        ],
                        'qty' => '2',
                        'total' => '600000'
                    ],
                    [
                        'items' => [
                            [
                                'name' => 'Kemeja Kantor',
                                'desc' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry'
                            ]
                        ],
                        'price' => [
                            [
                                'regular_price' => '330000',
                                'sale_price' => '300000',
                            ]
                        ],
                        'qty' => '2',
                        'total' => '600000'
                    ]
                ]
            ],
            'right' => [
                'Shipping Detail' => [
                    'total_price' => '2420000',
                    'shipping_price' => '11000',
                    'subtotal' => '2431000',
                    'Payment Method' => [
                        'points' => '20500',
                        'transfer' => [
                            'Bank BCA',
                            'Bank Mandiri',
                            'Bank BRI'
                        ],
                        'virtual_account' => [
                            'Bank BCA',
                            'Bank Mandiri',
                            'Bank BRI'
                        ],
                        'others' => 'credit_card'
                    ]
                ]
            ]
        ];
        $this->setResponse($this->response->withStatus(200));
        $this->set(compact('response'));
    }


    public function confirmation(){
        $this->request->allowMethod('post');
        $response = [
            'mainOne' => [
                'Payment Information' => [
                    'desc' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry'
                ]
            ],
            'mainTwo' => [
                'left' => [
                    'Order Detail' => [
                        'order_id' => 'Z100012019',
                        'date' => 'Friday, 05-02-2019',
                        'Item Detail' => [
                            [
                                'items' => [
                                    [
                                        'name' => 'Kemeja Kantor',
                                        'desc' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry'
                                    ]
                                ],
                                'price' => [
                                    [
                                        'regular_price' => '330000',
                                        'sale_price' => '300000',
                                        'add_price' => '10000'
                                    ]
                                ],
                                'qty' => '2',
                                'total' => '620000'
                            ],
                            [
                                'items' => [
                                    [
                                        'name' => 'Kemeja Kantor',
                                        'desc' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry'
                                    ]
                                ],
                                'price' => [
                                    [
                                        'regular_price' => '330000',
                                        'sale_price' => '300000',
                                    ]
                                ],
                                'qty' => '2',
                                'total' => '600000'
                            ],
                            [
                                'items' => [
                                    [
                                        'name' => 'Kemeja Kantor',
                                        'desc' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry'
                                    ]
                                ],
                                'price' => [
                                    [
                                        'regular_price' => '330000',
                                        'sale_price' => '300000',
                                    ]
                                ],
                                'qty' => '2',
                                'total' => '600000'
                            ],
                            [
                                'items' => [
                                    [
                                        'name' => 'Kemeja Kantor',
                                        'desc' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry'
                                    ]
                                ],
                                'price' => [
                                    [
                                        'regular_price' => '330000',
                                        'sale_price' => '300000',
                                    ]
                                ],
                                'qty' => '2',
                                'total' => '600000'
                            ]
                        ],
                        'shipping_method' => 'JNE - Regular Service',
                        'receipt_number' => '--'
                    ]
                ],
                'right' => [
                    'Shipping Detail' => [
                        'invoice_no' => 'INV-ZL0001',
                        'invoice_status' => 'Waiting Payment',
                        'total_payment' => '2431000',
                        'payment_methods' => 'Bank Transfer - Mandiri',
                        'shipping_address' => [
                            'username' => 'abcde12345',
                            'address' => 'Jalan Sanggar Kencana',
                            'phone_number' => '081234567890'
                        ]
                    ]
                ]
            ]

        ];
        $this->setResponse($this->response->withStatus(200));
        $this->set(compact('response'));
    }


    public function history(){
        $this->request->allowMethod('post');
        $response = [
            'Order History' => [
                'mainOne' => [
                    'find_order' => [

                    ],
                    'categories' => [
                        'Gadget & Accecories',
                        'Health & Beauty',
                        'Home & Living',
                        'Man',
                        'Woman'
                    ],
                    'status' => [
                        'Waiting Payment',
                        'Packing',
                        'On Delivery',
                        'Completed',
                        'Canceled'
                    ]
                ],
                'mainTwo' => [
                    [
                        'invoice_no' => 'INV-ZL0001',
                        'total_payment' => '2431000',
                        'invoice_status' => 'Waiting Payment',
                        'date' => 'Friday, 05-02-2019',
                        'product_detail' => [
                            [
                                'image' => 'default.jpg',
                                'name' => 'Kemeja Kantor',
                                'desc' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry'
                            ],
                            [
                                'image' => 'default.jpg',
                                'name' => 'Kemeja Kantor',
                                'desc' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry'
                            ],
                            [
                                'image' => 'default.jpg',
                                'name' => 'Kemeja Kantor',
                                'desc' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry'
                            ],
                            [
                                'image' => 'default.jpg',
                                'name' => 'Kemeja Kantor',
                                'desc' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry'
                            ]
                        ]
                    ],
                    [
                        'invoice_no' => 'INV-ZL0002',
                        'total_payment' => '200000',
                        'invoice_status' => 'Completed',
                        'date' => 'Friday, 23-02-2019',
                        'product_detail' => [
                            [
                                'image' => 'default.jpg',
                                'name' => 'Kemeja Kantor',
                                'desc' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry'
                            ]
                        ]
                    ],
                    [
                        'invoice_no' => 'INV-ZL0003',
                        'total_payment' => '300000',
                        'invoice_status' => 'Completed',
                        'date' => 'Friday, 24-02-2019',
                        'product_detail' => [
                            [
                                'image' => 'default.jpg',
                                'name' => 'Kemeja Kantor',
                                'desc' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry'
                            ]
                        ]
                    ]
                ]
            ]
        ];
        $this->setResponse($this->response->withStatus(200));
        $this->set(compact('response'));
    }

}
