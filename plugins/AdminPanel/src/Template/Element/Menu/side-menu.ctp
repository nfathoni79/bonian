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
                'url' => ['controller' => 'Customers', 'action' => 'index'],
                'icon' => 'm-menu__link-icon flaticon-users',
                'children' => []
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
                        'url' => ['controller' => 'Products', 'action' => 'prices'],
                        'icon' => 'm-menu__link-bullet',
                        'children' => []
                    ],
                    [
                        'name' => 'Manajemen Stok',
                        'url' => ['controller' => 'Products', 'action' => 'stock'],
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
                'name' => 'Pembelian',
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
                        'url' => '#',
                        'icon' => 'm-menu__link-bullet',
                        'children' => []
                    ],
                    [
                        'name' => 'Buy 1 GET 1',
                        'url' => '#',
                        'icon' => 'm-menu__link-bullet',
                        'children' => []
                    ],
                    [
                        'name' => 'Voucher',
                        'url' => ['controller' => 'Vouchers', 'action' => 'index'],
                        'icon' => 'm-menu__link-bullet',
                        'children' => []
                    ],
                ]
            ],
            [
                'name' => 'Gamification',
                'url' => '#',
                'icon' => 'm-menu__link-icon flaticon-apps',
                'children' => []
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