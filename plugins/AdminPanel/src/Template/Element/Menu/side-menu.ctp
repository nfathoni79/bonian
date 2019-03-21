<!-- BEGIN: Left Aside -->
<button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn"><i class="la la-close"></i></button>
<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">

    <!-- BEGIN: Aside Menu -->
    <div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark " m-menu-vertical="1" m-menu-scrollable="1" m-menu-dropdown-timeout="500" style="position: relative;">
        <?php

        $menu = [
            [
                'name' => 'Dashboard',
                'url' => ['controller' => 'Dashboard'],
                'icon' => 'm-menu__link-icon flaticon-line-graph'
            ],
            [
                'name' => 'Pengaturan Pengguna',
                'url' => '#',
                'icon' => 'm-menu__link-icon flaticon-users',
                'children' => [
                    [
                        'name' => 'Daftar Pengguna',
                        'url' => ['controller' => 'Users', 'action' => 'index'],
                        'icon' => 'm-menu__link-bullet'
                    ],
                    [
                        'name' => 'Daftar Jenis Pengguna',
                        'url' => ['controller' => 'Groups', 'action' => 'index'],
                        'icon' => 'm-menu__link-bullet'
                    ],
                ]
            ],
            [
                'name' => 'Konten Halaman',
                'url' => '#',
                'icon' => 'm-menu__link-icon  flaticon-browser',
                'children' => [
                    [
                        'name' => 'Daftar Halaman',
                        'url' => ['controller' => 'Pages', 'action' => 'index'],
                        'icon' => 'm-menu__link-bullet'
                    ],
                    [
                        'name' => 'Halaman Baru',
                        'url' => ['controller' => 'Pages', 'action' => 'add'],
                        'icon' => 'm-menu__link-bullet'
                    ],
                ]
            ],
            [
                'name' => 'Pelanggan',
                'url' => '#',
                'icon' => 'm-menu__link-icon flaticon-users',
                'children' => [
                    [
                        'name' => 'Daftar Pelanggan',
                        'url' => ['controller' => 'Customers', 'action' => 'index'],
                        'icon' => 'm-menu__link-bullet'
                    ],
                    [
                        'name' => 'Mutasi Saldo',
                        'url' => ['controller' => 'Customers', 'action' => 'balance'],
                        'icon' => 'm-menu__link-bullet'
                    ],
                    [
                        'name' => 'Mutasi Point',
                        'url' => ['controller' => 'Customers', 'action' => 'point'],
                        'icon' => 'm-menu__link-bullet'
                    ],
                    [
                        'name' => 'Networking',
                        'url' => ['controller' => 'Customers', 'action' => 'network'],
                        'icon' => 'm-menu__link-bullet'
                    ],
                    [
                        'name' => 'Statistik Share',
                        'url' => ['controller' => 'Customers', 'action' => 'share'],
                        'icon' => 'm-menu__link-bullet'
                    ],
                ]
            ],
            [
                'name' => 'Toko Cabang',
                'url' => ['controller' => 'Branches', 'action' => 'index'],
                'icon' => 'm-menu__link-icon flaticon-settings',
                'children' => []
            ],
            [
                'name' => 'Produk',
                'url' => '#',
                'icon' => 'm-menu__link-icon flaticon-box',
                'children' => [
                    [
                        'name' => 'Manajemen Produk',
                        'url' => ['controller' => 'Products', 'action' => 'index'],
                        'icon' => 'm-menu__link-bullet',
                        'children' => []
                    ],
                    [
                        'name' => 'Manajemen Harga',
                        'url' => ['controller' => 'ProductPrices', 'action' => 'index'],
                        'icon' => 'm-menu__link-bullet',
                        'children' => []
                    ],
                    [
                        'name' => 'Manajemen Stock',
                        'url' => '#',
                        'icon' => 'm-menu__link-bullet',
                        'children' => [
                            [
                                'name' => 'Stock',
                                'url' => ['controller' => 'ProductStocks', 'action' => 'index'],
                                'icon' => 'm-menu__link-bullet',
                                'children' => []
                            ],
                            [
                                'name' => 'Mutasi Stock',
                                'url' => ['controller' => 'ProductStockMutations', 'action' => 'index'],
                                'icon' => 'm-menu__link-bullet',
                                'children' => []
                            ],
                        ]
                    ],
                    [
                        'name' => 'Manajemen Brand',
                        'url' => ['controller' => 'Brands', 'action' => 'index'],
                        'icon' => 'm-menu__link-bullet',
                        'children' => []
                    ],
                    [
                        'name' => 'Manajemen Kategori',
                        'url' => ['controller' => 'ProductCategories', 'action' => 'index'],
                        'icon' => 'm-menu__link-bullet',
                        'children' => []
                    ],
                    [
                        'name' => 'Manajemen Atribut',
                        'url' => ['controller' => 'Attributes', 'action' => 'index'],
                        'icon' => 'm-menu__link-bullet',
                        'children' => []
                    ],
                    [
                        'name' => 'Manajemen Penandaan',
                        'url' => ['controller' => 'Tags', 'action' => 'index'],
                        'icon' => 'm-menu__link-bullet',
                        'children' => []
                    ],
                    [
                        'name' => 'Manajemen Varian',
                        'url' => '#',
                        'icon' => 'm-menu__link-bullet m-menu__link-bullet--dot',
                        'children' => [
                            [
                                'name' => 'Daftar Pilihan',
                                'url' => ['controller' => 'Options', 'action' => 'index'],
                                'icon' => 'm-menu__link-bullet',
                                'children' => []
                            ],
                            [
                                'name' => 'Daftar Varian',
                                'url' => ['controller' => 'OptionValues', 'action' => 'index'],
                                'icon' => 'm-menu__link-bullet',
                                'children' => []
                            ],
                        ]
                    ],
                ]
            ],
            [
                'name' => 'Produk Digital',
                'url' => '#',
                'icon' => 'm-menu__link-icon flaticon-box',
                'children' => [
                    [
                        'name' => 'Daftar Produk',
                        'url' => ['controller' => 'Digitals', 'action' => 'index'],
                        'icon' => 'm-menu__link-bullet',
                        'children' => []
                    ],
                ]
            ],
            [
                'name' => 'Penjualan',
                'url' => '#',
                'icon' => 'm-menu__link-icon flaticon-box',
                'children' => [
                    [
                        'name' => 'Daftar Pembelian',
                        'url' => ['controller' => 'Products', 'action' => 'index'],
                        'icon' => 'm-menu__link-bullet',
                        'children' => []
                    ],
                    [
                        'name' => 'Export Data Pembelian',
                        'url' => ['controller' => 'Products', 'action' => 'prices'],
                        'icon' => 'm-menu__link-bullet',
                        'children' => []
                    ],
                ]
            ],
            [
                'name' => 'Promosi Penjualan',
                'url' => '#',
                'icon' => 'm-menu__link-icon flaticon-cart',
                'children' => [
                    [
                        'name' => 'Flash Sales',
                        'url' => ['controller' => 'ProductDeals', 'action' => 'index'],
                        'icon' => 'm-menu__link-bullet',
                        'children' => []
                    ],
                    [
                        'name' => 'Group Sales',
                        'url' => ['controller' => 'ProductGroups', 'action' => 'index'],
                        'icon' => 'm-menu__link-bullet',
                        'children' => []
                    ],
                    [
                        'name' => 'Promotion Sale',
                        'url' => ['controller' => 'ProductPromotions', 'action' => 'index'],
                        'icon' => 'm-menu__link-bullet',
                        'children' => []
                    ],
                    [
                        'name' => 'Voucher',
                        'url' => ['controller' => 'Vouchers', 'action' => 'index'],
                        'icon' => 'm-menu__link-bullet',
                        'children' => []
                    ],
                    [
                        'name' => 'Coupon',
                        'url' => ['controller' => 'ProductCoupons', 'action' => 'index'],
                        'icon' => 'm-menu__link-bullet',
                        'children' => []
                    ],
                    [
                        'name' => 'Pengaturan Banner',
                        'url' => ['controller' => 'Banners', 'action' => 'index'],
                        'icon' => 'm-menu__link-bullet',
                        'children' => []
                    ],
                ]
            ],
            [
                'name' => 'Gamification',
                'url' => '#',
                'icon' => 'm-menu__link-icon flaticon-apps',
                'children' => [
                    [
                    'name' => 'Wheel Of Fortune',
                    'url' => ['controller' => 'GameWheels', 'action' => 'index'],
                    'icon' => 'm-menu__link-bullet',
                    'children' => []
                    ],
                ]
            ],
            [
                'name' => 'Data Master',
                'url' => '#',
                'icon' => 'm-menu__link-icon flaticon-settings',
                'children' => [
                    [
                        'name' => 'Propinsi',
                        'url' => ['controller' => 'Provinces', 'action' => 'index'],
                        'icon' => 'm-menu__link-bullet',
                        'children' => []
                    ],
                    [
                        'name' => 'Kota',
                        'url' => ['controller' => 'Cities', 'action' => 'index'],
                        'icon' => 'm-menu__link-bullet',
                        'children' => []
                    ],
                    [
                        'name' => 'Kabupaten',
                        'url' => ['controller' => 'Subdistricts', 'action' => 'index'],
                        'icon' => 'm-menu__link-bullet',
                        'children' => []
                    ],
                ]
            ],
            [
                'name' => 'Reports',
                'url' => '#',
                'icon' => 'm-menu__link-icon flaticon-settings',
                'children' => [
                    [
                        'name' => 'Product Review Report',
                        'url' => ['controller' => 'Reports', 'action' => 'review'],
                        'icon' => 'm-menu__link-bullet',
                        'children' => []
                    ],
                ]
            ],
            [
                'name' => 'Log Aktifitas',
                'url' => ['controller' => 'Logs', 'action' => 'index'],
                'icon' => 'm-menu__link-icon flaticon-apps',
                'children' => [
                ]
            ],
            [
                'name' => 'FAQ',
                'url' => '#',
                'icon' => 'm-menu__link-icon flaticon-apps',
                'children' => [
                    [
                        'name' => 'Faq Kategori',
                        'url' => ['controller' => 'FaqCategories', 'action' => 'index'],
                        'icon' => 'm-menu__link-bullet',
                        'children' => []
                    ],
                    [
                        'name' => 'Daftar FAQ',
                        'url' => ['controller' => 'Faqs', 'action' => 'index'],
                        'icon' => 'm-menu__link-bullet',
                        'children' => []
                    ],
                ]
            ],
        ];

        echo $this->SideMenu->create('main')
            ->setHasChildOption([
                    'uri' => 'javascript:;',
                    'attributes' => [
                        'class' => 'm-menu__item',
                        'aria-haspopup' => 'true',
                        'data-menu-submenu-toggle' => 'hover'
                    ],
                    'linkAttributes' => [
                        'class' => 'm-menu__link m-menu__toggle'
                    ],
                    'templateVars' => [
                        'icon' => 'm-menu__link-icon flaticon-users',
                        'arrow' => '<i class="m-menu__ver-arrow la la-angle-right"></i>'
                    ],
                    'nestAttributes' => [
                        'class' => 'm-menu__subnav'
                    ],
                ]
            )
            ->setOption([
                'attributes' => [
                    'class' => 'm-menu__item',
                    'aria-haspopup' => 'true'
                ],
                'linkAttributes' => [
                    'class' => 'm-menu__link'
                ],
                'templateVars' => [
                    'icon' => ''
                ]
            ])
            ->setChildOption([
                    'attributes' => [
                        'class' => 'm-menu__item',
                        'aria-haspopup' => 'true'
                    ],
                    'linkAttributes' => [
                        'class' => 'm-menu__link'
                    ],
                    'templateVars' => [
                        'icon' => 'm-menu__link-bullet m-menu__link-bullet--dot',
                        'span' => '<span></span>'
                    ]
                ]
            )
            ->add($menu)
            ->render();
        ?>
    </div>

    <!-- END: Aside Menu -->
</div>

<!-- END: Left Aside -->