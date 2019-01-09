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
                        'icon' => 'm-menu__link-bullet m-menu__link-bullet--dot'
                    ],
                    [
                        'name' => 'List Groups',
                        'url' => ['controller' => 'Groups', 'action' => 'index'],
                        'icon' => 'm-menu__link-bullet m-menu__link-bullet--dot'
                    ],
                ]
            ],
            [
                'name' => 'Clients',
                'url' => '#',
                'icon' => 'm-menu__link-icon flaticon-avatar',
                'children' => [
                    [
                        'name' => 'List Clients',
                        'url' => ['controller' => 'Clients', 'action' => 'index'],
                        'icon' => 'm-menu__link-icon flaticon-list-3'
                    ],
                    [
                        'name' => 'Client Balances',
                        'url' => ['controller' => 'Clients', 'action' => 'listbalance'],
                        'icon' => 'm-menu__link-icon flaticon-list-3'
                    ],
                ]
            ],
            [
                'name' => 'Pages',
                'url' => '#',
                'icon' => 'm-menu__link-icon flaticon-file-2',
                'children' => [
                    [
                        'name' => 'List Pages',
                        'url' => ['controller' => 'Pages', 'action' => 'index'],
                        'icon' => 'm-menu__link-icon flaticon-list-3'
                    ],
                    [
                        'name' => 'Add Page',
                        'url' => ['controller' => 'Pages', 'action' => 'add'],
                        'icon' => 'm-menu__link-icon la la-pencil-square-o'
                    ],
                ]
            ],
            [
                'name' => 'Roadmaps',
                'url' => '#',
                'icon' => 'm-menu__link-icon flaticon-more-v2',
                'children' => [
                    [
                        'name' => 'List Roadmaps',
                        'url' => ['controller' => 'Roadmaps', 'action' => 'index'],
                        'icon' => 'm-menu__link-icon flaticon-list-3'
                    ],
                    [
                        'name' => 'Add Roadmap',
                        'url' => ['controller' => 'Roadmaps', 'action' => 'add'],
                        'icon' => 'm-menu__link-icon la la-pencil-square-o'
                    ],
                ]
            ],
            [
                'name' => 'Faqs',
                'url' => '#',
                'icon' => 'm-menu__link-icon flaticon-exclamation',
                'children' => [
                    [
                        'name' => 'List Faqs',
                        'url' => ['controller' => 'Faqs', 'action' => 'index'],
                        'icon' => 'm-menu__link-icon flaticon-list-3'
                    ],
                    [
                        'name' => 'Add Faq',
                        'url' => ['controller' => 'Faqs', 'action' => 'add'],
                        'icon' => 'm-menu__link-icon la la-pencil-square-o'
                    ],
                ]
            ],
            [
                'name' => 'KYC Approval',
                'url' => ['controller' => 'Verification', 'action' => 'index'],
                'icon' => 'm-menu__link-icon flaticon-line-graph',
                'children' => []
            ],[
                'name' => 'Withdrawl Aproval',
                'url' => ['controller' => 'Withdrawal', 'action' => 'index'],
                'icon' => 'm-menu__link-icon flaticon-line-graph',
                'children' => []
            ],
            [
                'name' => 'Change Requests',
                'url' => '#',
                'icon' => 'm-menu__link-icon flaticon-edit-1',
                'children' => [
                    [
                        'name' => 'Email',
                        'url' => ['controller' => 'ChangeRequests', 'action' => 'email'],
                        'icon' => 'm-menu__link-icon flaticon-email'
                    ],
                    [
                        'name' => 'Phone',
                        'url' => ['controller' => 'ChangeRequests', 'action' => 'phone'],
                        'icon' => 'm-menu__link-icon flaticon-support'
                    ],
                    [
                        'name' => 'Address',
                        'url' => ['controller' => 'ChangeRequests', 'action' => 'address'],
                        'icon' => 'm-menu__link-icon flaticon-map-location'
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