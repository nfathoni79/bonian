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
 */

class PartialsController  extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('AdminPanel.Customers');
        $this->loadModel('AdminPanel.CustomerBalances');
        $this->loadModel('AdminPanel.CustomerMutationAmounts');
        $this->loadModel('AdminPanel.CustomerMutationPoints');
        $this->loadModel('AdminPanel.CustomerAddreses');

    }

    public function topmenu(){

        $result = [
            'is_logged' =>  false, //true or false boolean
            'topnav' => [
                [
                    'title' => 'Be Zolaku Member',
                    'url' => '#'
                ],
                [
                    'title' => 'Today\'s Offer',
                    'url' => '#'
                ],
                [
                    'title' => 'Tranck Order',
                    'url' => '#'
                ],
                [
                    'title' => 'Gift Card',
                    'url' => '#'
                ],
                [
                    'title' => 'Check Point',
                    'url' => '#'
                ],
                [
                    'title' => 'Contact Us',
                    'url' => '#'
                ],
            ],
            'top_category' => [
                [
                    'title' => 'Gadget & Accecories',
                    'url' => '#'
                ],
                [
                    'title' => 'Health & Beauty',
                    'url' => '#'
                ],
                [
                    'title' => 'Home & Living',
                    'url' => '#'
                ],
                [
                    'title' => 'Man',
                    'url' => '#'
                ],
                [
                    'title' => 'Woman',
                    'url' => '#'
                ],
            ],
            'shooping_cart' => [
                'counter' => '2',
                'lists' => [
                    [
                        'name' => 'Sepatu Pdh Slip-On Kilap Tampa Semir',
                        'image' => 'image.jpg',
                        'price' => '300000',
                        'variants' => [
                            'option' => 'Red',
                            'value' => 'Size M'
                        ]
                    ],
                    [
                        'name' => 'Sepatu Pdh Slip-On Kilap Tampa Semir',
                        'image' => 'image.jpg',
                        'price' => '300000',
                        'variants' => [
                            'option' => 'Red',
                            'value' => 'Size M'
                        ]
                    ],
                ]
            ],

        ];

        $this->setResponse($this->response->withStatus(200));
        $this->set(compact('result'));
    }

    public function mainOne(){
        $result = [
            'left' => [
                'promotion_banners' => [
                    ['image' => 'default.jpg', 'link_url' => '#'],
                    ['image' => 'default.jpg', 'link_url' => '#'],
                    ['image' => 'default.jpg', 'link_url' => '#'],
                ],
                'link_bottom' => [
                    ['title' => 'UP TO 70% OFF', 'slug' => 'Diskon hingga 70%', 'url' => '#'],
                    ['title' => 'BUY 1 GET 1', 'slug' => 'Hemat hemat hemat', 'url' => '#'],
                    ['title' => 'GET BONUS POINT', 'slug' => 'Belanja dengan keuntungan', 'url' => '#'],
                ]
            ],
            'right' => [
                [
                    'leaderboards' => [
                        'title' => 'Top Leader Board',
                        'image' => 'default',
                        'url' => '#',
                    ]
                ],
                [
                    'user_information' => [
                        'name' => 'John Doe',
                        'avatar' => 'default.jpg',
                        'reff_code' => '1111',
                    ]
                ],
            ],
        ];
        $this->setResponse($this->response->withStatus(200));
        $this->set(compact('result'));
    }

    public function mainTwo(){
        $result = [
            'left' => [
                'title' => 'Bonus & Game',
                'game_lists' => [
                    ['title' => 'Free Point', 'image' => 'default.jpg', 'url' => '#'],
                    ['title' => 'Wheel Of Fortune', 'image' => 'default.jpg', 'url' => '#'],
                    ['title' => 'Flip & Win', 'image' => 'default.jpg', 'url' => '#'],
                    ['title' => 'Treasure Hunt', 'image' => 'default.jpg', 'url' => '#'],
                    ['title' => 'Sell Chalange', 'image' => 'default.jpg', 'url' => '#'],
                    ['title' => 'Guest Box', 'image' => 'default.jpg', 'url' => '#'],
                    ['title' => 'Coupon Exchange', 'image' => 'default.jpg', 'url' => '#'],
                ]
            ],
            'right' => [
                'title' => 'Digital Products',
                'product_lists' => [
                    ['title' => 'Pulsa', 'image' => 'default.jpg', 'url' => '#'],
                    ['title' => 'Data', 'image' => 'default.jpg', 'url' => '#'],
                    ['title' => 'Listrik', 'image' => 'default.jpg', 'url' => '#'],
                    ['title' => 'Air', 'image' => 'default.jpg', 'url' => '#'],
                    ['title' => 'BPJS', 'image' => 'default.jpg', 'url' => '#'],
                    ['title' => 'Top Up', 'image' => 'default.jpg', 'url' => '#'],
                    ['title' => 'Tagihan', 'image' => 'default.jpg', 'url' => '#'],
                ]

            ],
        ];
        $this->setResponse($this->response->withStatus(200));
        $this->set(compact('result'));
    }

    public function mainThree(){
        $result = [
            'tabs' => [
                'Flash Sales',
                'New Arrivals',
                'Hot Products'
            ],
            'tab-lists' => [
                [
                    'name' => 'Flash Sales',
                    'end_date' => '2019-02-20 11:00:00',
                    'product_lists' => [
                        [
                            'name' => 'Sepatu Pdh Slip-On Kilap Tampa Semir',
                            'images' => 'default.jpg',
                            'regular_price' => '330000',
                            'sale_price' => '300000',
                            'point' => '300',
                            'star' => '4',
                        ],
                        [
                            'name' => 'Sepatu Pdh Slip-On Kilap Tampa Semir',
                            'images' => 'default.jpg',
                            'regular_price' => '330000',
                            'sale_price' => '300000',
                            'point' => '300',
                            'star' => '4',
                        ],
                        [
                            'name' => 'Sepatu Pdh Slip-On Kilap Tampa Semir',
                            'images' => 'default.jpg',
                            'regular_price' => '330000',
                            'sale_price' => '300000',
                            'point' => '300',
                            'star' => '4',
                        ],
                        [
                            'name' => 'Sepatu Pdh Slip-On Kilap Tampa Semir',
                            'images' => 'default.jpg',
                            'regular_price' => '330000',
                            'sale_price' => '300000',
                            'point' => '300',
                            'star' => '4',
                        ],
                        [
                            'name' => 'Sepatu Pdh Slip-On Kilap Tampa Semir',
                            'images' => 'default.jpg',
                            'regular_price' => '330000',
                            'sale_price' => '300000',
                            'point' => '300',
                            'star' => '4',
                        ],
                        [
                            'name' => 'Sepatu Pdh Slip-On Kilap Tampa Semir',
                            'images' => 'default.jpg',
                            'regular_price' => '330000',
                            'sale_price' => '300000',
                            'point' => '300',
                            'star' => '4',
                        ],
                        [
                            'name' => 'Sepatu Pdh Slip-On Kilap Tampa Semir',
                            'images' => 'default.jpg',
                            'regular_price' => '330000',
                            'sale_price' => '300000',
                            'point' => '300',
                            'star' => '4',
                        ],
                    ]
                ],
                [
                    'name' => 'New Arrival',
                    'product_lists' => [
                        [
                            'name' => 'Sepatu Pdh Slip-On Kilap Tampa Semir',
                            'images' => 'default.jpg',
                            'regular_price' => '330000',
                            'sale_price' => '300000',
                            'point' => '300',
                            'star' => '4',
                        ],
                        [
                            'name' => 'Sepatu Pdh Slip-On Kilap Tampa Semir',
                            'images' => 'default.jpg',
                            'regular_price' => '330000',
                            'sale_price' => '300000',
                            'point' => '300',
                            'star' => '4',
                        ],
                        [
                            'name' => 'Sepatu Pdh Slip-On Kilap Tampa Semir',
                            'images' => 'default.jpg',
                            'regular_price' => '330000',
                            'sale_price' => '300000',
                            'point' => '300',
                            'star' => '4',
                        ],
                        [
                            'name' => 'Sepatu Pdh Slip-On Kilap Tampa Semir',
                            'images' => 'default.jpg',
                            'regular_price' => '330000',
                            'sale_price' => '300000',
                            'point' => '300',
                            'star' => '4',
                        ],
                        [
                            'name' => 'Sepatu Pdh Slip-On Kilap Tampa Semir',
                            'images' => 'default.jpg',
                            'regular_price' => '330000',
                            'sale_price' => '300000',
                            'point' => '300',
                            'star' => '4',
                        ],
                        [
                            'name' => 'Sepatu Pdh Slip-On Kilap Tampa Semir',
                            'images' => 'default.jpg',
                            'regular_price' => '330000',
                            'sale_price' => '300000',
                            'point' => '300',
                            'star' => '4',
                        ],
                        [
                            'name' => 'Sepatu Pdh Slip-On Kilap Tampa Semir',
                            'images' => 'default.jpg',
                            'regular_price' => '330000',
                            'sale_price' => '300000',
                            'point' => '300',
                            'star' => '4',
                        ],
                    ]
                ],
                [
                    'name' => 'Hot Products',
                    'product_lists' => [
                        [
                            'name' => 'Sepatu Pdh Slip-On Kilap Tampa Semir',
                            'images' => 'default.jpg',
                            'regular_price' => '330000',
                            'sale_price' => '300000',
                            'point' => '300',
                            'star' => '4',
                        ],
                        [
                            'name' => 'Sepatu Pdh Slip-On Kilap Tampa Semir',
                            'images' => 'default.jpg',
                            'regular_price' => '330000',
                            'sale_price' => '300000',
                            'point' => '300',
                            'star' => '4',
                        ],
                        [
                            'name' => 'Sepatu Pdh Slip-On Kilap Tampa Semir',
                            'images' => 'default.jpg',
                            'regular_price' => '330000',
                            'sale_price' => '300000',
                            'point' => '300',
                            'star' => '4',
                        ],
                        [
                            'name' => 'Sepatu Pdh Slip-On Kilap Tampa Semir',
                            'images' => 'default.jpg',
                            'regular_price' => '330000',
                            'sale_price' => '300000',
                            'point' => '300',
                            'star' => '4',
                        ],
                        [
                            'name' => 'Sepatu Pdh Slip-On Kilap Tampa Semir',
                            'images' => 'default.jpg',
                            'regular_price' => '330000',
                            'sale_price' => '300000',
                            'point' => '300',
                            'star' => '4',
                        ],
                        [
                            'name' => 'Sepatu Pdh Slip-On Kilap Tampa Semir',
                            'images' => 'default.jpg',
                            'regular_price' => '330000',
                            'sale_price' => '300000',
                            'point' => '300',
                            'star' => '4',
                        ],
                        [
                            'name' => 'Sepatu Pdh Slip-On Kilap Tampa Semir',
                            'images' => 'default.jpg',
                            'regular_price' => '330000',
                            'sale_price' => '300000',
                            'point' => '300',
                            'star' => '4',
                        ],
                    ]
                ],
            ],
        ];
        $this->setResponse($this->response->withStatus(200));
        $this->set(compact('result'));
    }


}
