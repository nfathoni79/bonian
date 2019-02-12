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
                'name' => 'Users & Groups',
                'url' => '#',
                'icon' => 'm-menu__link-icon flaticon-users',
                'children' => [
                    [
                        'name' => 'List Users',
                        'url' => ['controller' => 'Users', 'action' => 'index'],
                        'icon' => 'm-menu__link-bullet'
                    ],
                    [
                        'name' => 'List Groups',
                        'url' => ['controller' => 'Groups', 'action' => 'index'],
                        'icon' => 'm-menu__link-bullet'
                    ],
                ]
            ],
            [
                'name' => 'Pages CMS',
                'url' => '#',
                'icon' => 'm-menu__link-icon  flaticon-browser',
                'children' => [
                    [
                        'name' => 'All Pages',
                        'url' => ['controller' => 'Pages', 'action' => 'index'],
                        'icon' => 'm-menu__link-bullet'
                    ],
                    [
                        'name' => 'New Pages',
                        'url' => ['controller' => 'Pages', 'action' => 'add'],
                        'icon' => 'm-menu__link-bullet'
                    ],
                ]
            ],
            [
                'name' => 'Customers',
                'url' => ['controller' => 'Customers', 'action' => 'index'],
                'icon' => 'm-menu__link-icon flaticon-users',
                'children' => []
            ],
            [
                'name' => 'Products',
                'url' => ['controller' => 'Products', 'action' => 'index'],
                'icon' => 'm-menu__link-icon flaticon-box',
                'children' => [
                    [
                        'name' => 'All Products',
                        'url' => ['controller' => 'Products', 'action' => 'index'],
                        'icon' => 'm-menu__link-bullet',
                        'children' => []
                    ],
                    [
                        'name' => 'Categories',
                        'url' => ['controller' => 'ProductCategories', 'action' => 'index'],
                        'icon' => 'm-menu__link-bullet',
                        'children' => []
                    ],
                    [
                        'name' => 'Options',
                        'url' => '#',
                        'icon' => 'm-menu__link-bullet m-menu__link-bullet--dot',
                        'children' => [
                            [
                                'name' => 'All Options',
                                'url' => ['controller' => 'Options', 'action' => 'index'],
                                'icon' => 'm-menu__link-bullet m-menu__link-bullet--dot',
                                'children' => []
                            ],
                            [
                                'name' => 'Option Values',
                                'url' => ['controller' => 'OptionValues', 'action' => 'index'],
                                'icon' => 'm-menu__link-bullet m-menu__link-bullet--dot',
                                'children' => []
                            ],
                        ]
                    ],
                    [
                        'name' => 'Tags',
                        'url' => ['controller' => 'Tags', 'action' => 'index'],
                        'icon' => 'm-menu__link-bullet',
                        'children' => []
                    ],
                ]
            ],
            [
                'name' => 'Promotion Sales',
                'url' => '#',
                'icon' => 'm-menu__link-icon flaticon-cart',
                'children' => [
                    [
                        'name' => 'Sales Method',
                        'url' => '#',
                        'icon' => 'm-menu__link-bullet m-menu__link-bullet--dot',
                        'children' => [
                            [
                                'name' => 'Flash Sales',
                                'url' => ['controller' => 'Provinces', 'action' => 'index'],
                                'icon' => 'm-menu__link-bullet m-menu__link-bullet--dot',
                                'children' => []
                            ],
                            [
                                'name' => 'Group Sales',
                                'url' => ['controller' => 'Cities', 'action' => 'index'],
                                'icon' => 'm-menu__link-bullet m-menu__link-bullet--dot',
                                'children' => []
                            ]
                        ]
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
                'name' => 'Configurations',
                'url' => ['controller' => 'Customers', 'action' => 'index'],
                'icon' => 'm-menu__link-icon flaticon-settings',
                'children' => [
                    [
                        'name' => 'Branches',
                        'url' => ['controller' => 'Branches', 'action' => 'index'],
                        'icon' => 'm-menu__link-bullet',
                        'children' => []
                    ],
                    [
                        'name' => 'Master Data',
                        'url' => '#',
                        'icon' => 'm-menu__link-bullet m-menu__link-bullet--dot',
                        'children' => [
                            [
                                'name' => 'Province',
                                'url' => ['controller' => 'Provinces', 'action' => 'index'],
                                'icon' => 'm-menu__link-bullet m-menu__link-bullet--dot',
                                'children' => []
                            ],
                            [
                                'name' => 'Cities',
                                'url' => ['controller' => 'Cities', 'action' => 'index'],
                                'icon' => 'm-menu__link-bullet m-menu__link-bullet--dot',
                                'children' => []
                            ],
                            [
                                'name' => 'Subdistrict',
                                'url' => ['controller' => 'Subdistricts', 'action' => 'index'],
                                'icon' => 'm-menu__link-bullet m-menu__link-bullet--dot',
                                'children' => []
                            ],
                        ]
                    ]
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