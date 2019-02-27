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

class ProductsController  extends AppController
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

    public function details(){
        $this->request->allowMethod('post');
        $response = [
            'mainOne' => [
                'left' => [
                    'image_product' => [
                        ['image' => 'default.jpg', 'link_url' => '#'],
                    ],
                    'image_bottom' => [
                        ['image' => 'default.jpg', 'link_url' => '#'],
                        ['image' => 'default.jpg', 'link_url' => '#'],
                        ['image' => 'default.jpg', 'link_url' => '#'],
                        ['image' => 'default.jpg', 'link_url' => '#'],
                        ['image' => 'default.jpg', 'link_url' => '#'],
                    ]
                ],
                'right' => [
                    'detail_product' => [
                        [
                            'name' => 'Kemeja Kantor',
                            'regular_price' => '330000',
                            'sale_price' => '300000',
                            'star' => '4',
                            'point' => '300',
                            'stock_info' => [
                                [
                                    'branch' => 'Jakarta',
                                    'stock' => '5'
                                ],
                                [
                                    'branch' => 'Bandung',
                                    'stock' => 'Tidak Tersedia'
                                ],
                                [
                                    'branch' => 'Semarang',
                                    'stock' => '11'
                                ],
                                [
                                    'branch' => 'Surabaya',
                                    'stock' => '25'
                                ]
                            ],
                            'qty' => '2',
                            'is_combo' => true, //True or False
                            'size' => [
                                'S',
                                'M',
                                'L',
                                'XL',
                                'XXL'
                            ],
                            'color_type' => [
                                ['color' => 'white'],
                                ['color' => 'red', 'add_price' => '10000'],
                                ['color' => 'green', 'add_price' => '10000'],
                                ['color' => 'blue', 'add_price' => '10000'],
                                ['color' => 'black', 'add_price' => '10000'],
                            ],
                            'sort_desc' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
                            'share' => [
                                'facebook' => 'www.facebook.com/',
                                'instagram' => 'www.instagram.com/',
                                'twitter' => 'www.twitter.com/',
                                'googleplus' => 'www.plus.google.com/',
                                'gmail' => 'www.google.com/gmail/'
                            ]
                        ]
                    ]
                ]
            ],
            'mainTwo' => [
                'tabs' => [
                    'Description',
                    'Product Attributes',
                    'Review'
                ],
                'tab-lists' => [
                    [
                        'name' => 'Description',
                        'detail' => [
                            'desc' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
                        ]
                    ],
                    [
                        'name' => 'Product Attributes',
                        'detail' => [
                            'Cotton 100%',
                            'Lengan Panjang',
                            'Kerah Formal',
                            'Slim Fit' => [
                                'S(100cm x 72cm x 59cm)',
                                'M(100cm x 72cm x 59cm)',
                                'L(100cm x 72cm x 59cm)',
                                'XL(100cm x 72cm x 59cm)',
                                'XXL(100cm x 72cm x 59cm)'
                            ]
                        ]
                    ],
                    [
                        'name' => 'Review',
                        'detail' => [
                            [
                                'image' => 'default.jpg',
                                'username' => 'abcde123',
                                'star' => '4',
                                'comment' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
                                'date' => '2019-02-25 13:23'
                            ],
                            [
                                'image' => 'default.jpg',
                                'username' => 'abcde123',
                                'star' => '4',
                                'comment' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
                                'date' => '2019-02-25 13:23'
                            ],
                            [
                                'image' => 'default.jpg',
                                'username' => 'abcde123',
                                'star' => '4',
                                'comment' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
                                'date' => '2019-02-25 13:23'
                            ],
                            [
                                'image' => 'default.jpg',
                                'username' => 'abcde123',
                                'star' => '4',
                                'comment' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
                                'date' => '2019-02-25 13:23'
                            ],
                            [
                                'image' => 'default.jpg',
                                'username' => 'abcde123',
                                'star' => '4',
                                'comment' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
                                'date' => '2019-02-25 13:23'
                            ]
                        ]
                    ]
                ]
            ],
            'mainThree' => [
                'tabs' => [
                    'Same Categories',
                    'Hot Products'
                ],
                'tab-lists' => [
                    [
                        'name' => 'Same Categories',
                        'product_lists' => [
                            [
                                'name' => 'Sepatu Pdh Slip-On Kilap Tampa Semir',
                                'slug' => 'sepatu-pdh-slip-on-kilap-tampa-semir',
                                'image' => 'default.jpg',
                                'regular_price' => '330000',
                                'sale_price' => '300000',
                                'point' => '300',
                                'star' => '4',
                            ],
                            [
                                'name' => 'Sepatu Pdh Slip-On Kilap Tampa Semir',
                                'slug' => 'sepatu-pdh-slip-on-kilap-tampa-semir',
                                'image' => 'default.jpg',
                                'regular_price' => '330000',
                                'sale_price' => '300000',
                                'point' => '300',
                                'star' => '4',
                            ],
                            [
                                'name' => 'Sepatu Pdh Slip-On Kilap Tampa Semir',
                                'slug' => 'sepatu-pdh-slip-on-kilap-tampa-semir',
                                'image' => 'default.jpg',
                                'regular_price' => '330000',
                                'sale_price' => '300000',
                                'point' => '300',
                                'star' => '4',
                            ],
                            [
                                'name' => 'Sepatu Pdh Slip-On Kilap Tampa Semir',
                                'slug' => 'sepatu-pdh-slip-on-kilap-tampa-semir',
                                'image' => 'default.jpg',
                                'regular_price' => '330000',
                                'sale_price' => '300000',
                                'point' => '300',
                                'star' => '4',
                            ],
                            [
                                'name' => 'Sepatu Pdh Slip-On Kilap Tampa Semir',
                                'slug' => 'sepatu-pdh-slip-on-kilap-tampa-semir',
                                'image' => 'default.jpg',
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
                                'slug' => 'sepatu-pdh-slip-on-kilap-tampa-semir',
                                'image' => 'default.jpg',
                                'regular_price' => '330000',
                                'sale_price' => '300000',
                                'point' => '300',
                                'star' => '4',
                            ],
                            [
                                'name' => 'Sepatu Pdh Slip-On Kilap Tampa Semir',
                                'slug' => 'sepatu-pdh-slip-on-kilap-tampa-semir',
                                'image' => 'default.jpg',
                                'regular_price' => '330000',
                                'sale_price' => '300000',
                                'point' => '300',
                                'star' => '4',
                            ],
                            [
                                'name' => 'Sepatu Pdh Slip-On Kilap Tampa Semir',
                                'slug' => 'sepatu-pdh-slip-on-kilap-tampa-semir',
                                'image' => 'default.jpg',
                                'regular_price' => '330000',
                                'sale_price' => '300000',
                                'point' => '300',
                                'star' => '4',
                            ],
                            [
                                'name' => 'Sepatu Pdh Slip-On Kilap Tampa Semir',
                                'slug' => 'sepatu-pdh-slip-on-kilap-tampa-semir',
                                'image' => 'default.jpg',
                                'regular_price' => '330000',
                                'sale_price' => '300000',
                                'point' => '300',
                                'star' => '4',
                            ],
                            [
                                'name' => 'Sepatu Pdh Slip-On Kilap Tampa Semir',
                                'slug' => 'sepatu-pdh-slip-on-kilap-tampa-semir',
                                'image' => 'default.jpg',
                                'regular_price' => '330000',
                                'sale_price' => '300000',
                                'point' => '300',
                                'star' => '4',
                            ],
                        ]
                    ]
                ]
            ]

        ];
        $this->setResponse($this->response->withStatus(200));
        $this->set(compact('response'));
    }

}
