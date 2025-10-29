<?php

function nav_obj($mod, $vars_obj, $userRole=0) {
    $search = [0];
    $vars_n = array_filter($vars_obj, function($_array) use ($search){
        return in_array($_array['parentid'], $search);
    });
    $vars_sort = array_multisort_value($vars_n, 'title', SORT_ASC);
    $vars = [];
    foreach ($vars_sort as $var) {
        $vars[] = [
            'name' => $var['title'],
            'link' => '/admin/vars/' . $var['id'],
            'class_li' => '',
            'children' => []
        ];
    }
    $vars[] = [
        'name' => 'Группы переменных',
        'link' => '/admin/vars-group',
        'class_li' => '',
        'children' => []
    ];
    $products = [
        [
            'name' => 'Все шаблоны',
            'link' => '/admin/products',
            'class_li' => '',
            'children' => []
        ],
        [
            'name' => 'Группы шаблонов',
            'link' => '/admin/products-group',
            'class_li' => '',
            'children' => []
        ],
        [
            'name' => 'Создать шаблон',
            'link' => '/admin/product-add',
            'class_li' => '',
            'children' => []
        ],
        [
            'name' => 'Редактировать шаблон',
            'link' => '/admin/product-edit',
            'class_li' => 'd-none',
            'children' => []
        ]
    ];
    $pages = [
        [
            'name' => 'Все страницы',
            'link' => '/admin/pages',
            'class_li' => '',
            'children' => []
        ],
        [
            'name' => 'Создать страницу',
            'link' => '/admin/page-add',
            'class_li' => '',
            'children' => []
        ],
        [
            'name' => 'Редактировать страницу',
            'link' => '/admin/page-edit',
            'class_li' => 'd-none',
            'children' => []
        ]
    ];
    // $vars[] = [
    //     'name' => 'Добавить группу',
    //     'link' => '/admin/vars-add',
    //     'class_li' => '',
    //     'children' => []
    // ];
    $nav_admin = [
        'container'       => 'ul',
        'container_class' => 'side-nav',
        'container_id'    => '',
        'structure' => [
            [
                'name' => 'Консоль',
                'link' => '/admin',
                'icon' => 'bi bi-speedometer2', // ri-dashboard-3-fill
                'children' => []
            ],
            [
                'name' => 'Страницы',
                'link' => 'sidebarPages',
                'icon' => 'ri-pages-line', // ri-dashboard-3-fill
                'children' => $pages
            ],
            [
                'name' => 'Шаблоны',
                'link' => 'sidebarProducts',
                'icon' => 'ri-store-2-line', // ri-dashboard-3-fill
                'children' => $products
            ],
            [
                'name' => 'Переменные',
                'link' => 'sidebarVars',
                'icon' => 'bi bi-hash', // ri-dashboard-3-fill
                'children' => $vars
            ],
            [
                'name' => 'Продажи',
                'link' => '/admin/orders',
                'icon' => 'bi bi-credit-card-2-back-fill', // ri-dashboard-3-fill
                'children' => []
            ],
            [
                'name' => 'Пользователи',
                'link' => 'sidebarUsers',
                'icon' => 'ri-account-box-fill',
                'children' => [
                    [
                        'name' => 'Все пользователи',
                        'link' => '/admin/users',
                        'class_li' => '',
                        'children' => []
                    ],
                    [
                        'name' => 'Админы',
                        'link' => '/admin/users-admins',
                        'class_li' => '',
                        'children' => []
                    ],
                    [
                        'name' => 'Добавить пользователя',
                        'link' => '/admin/user-add',
                        'class_li' => '',
                        'children' => []
                    ]
                ]
            ],
            [
                'name' => 'Профиль',
                'link' => 'sidebarUserSettings',
                'icon' => 'ri-user-6-fill',
                'children' => [
                    [
                        'name' => 'Профиль',
                        'link' => '/admin/user-settings',
                        'class_li' => '',
                        'children' => []
                    ],
                    [
                        'name' => 'Покупки',
                        'link' => '/admin/user-orders',
                        'class_li' => '',
                        'children' => []
                    ]
                ]
            ],
            [
                'name' => 'Настройки',
                'link' => 'sidebarSettings',
                'icon' => 'ri-settings-5-fill',
                'children' => [
                    [
                        'name' => 'Общие',
                        'link' => '/admin/settings',
                        'class_li' => '',
                        'children' => []
                    ],
                    [
                        'name' => 'Платежи',
                        'link' => '/admin/settings-pay',
                        'class_li' => '',
                        'children' => []
                    ]
                ]
            ]
        ]
    ];

    $nav_admin_editors = [
        'container'       => 'ul',
        'container_class' => 'side-nav',
        'container_id'    => '',
        'structure' => [
            [
                'name' => 'Консоль',
                'link' => '/admin',
                'icon' => 'bi bi-speedometer2', // ri-dashboard-3-fill
                'children' => []
            ],
            [
                'name' => 'Страницы',
                'link' => 'sidebarPages',
                'icon' => 'ri-pages-line', // ri-dashboard-3-fill
                'children' => $pages
            ],
            [
                'name' => 'Шаблоны',
                'link' => 'sidebarProducts',
                'icon' => 'ri-store-2-line', // ri-dashboard-3-fill
                'children' => $products
            ],
            [
                'name' => 'Переменные',
                'link' => 'sidebarVars',
                'icon' => 'bi bi-hash', // ri-dashboard-3-fill
                'children' => $vars
            ],
            [
                'name' => 'Профиль',
                'link' => 'sidebarUserSettings',
                'icon' => 'ri-user-6-fill',
                'children' => [
                    [
                        'name' => 'Профиль',
                        'link' => '/admin/user-settings',
                        'class_li' => '',
                        'children' => []
                    ],
                    [
                        'name' => 'Покупки',
                        'link' => '/admin/user-orders',
                        'class_li' => '',
                        'children' => []
                    ]
                ]
            ]
        ]
    ];

    $nav_dashboard = [
        'container'       => 'ul',
        'container_class' => 'side-nav',
        'container_id'    => '',
        'structure' => [
            [
                'name' => 'Личный кабинет',
                'link' => '/dashboard',
                'icon' => 'bi bi-speedometer2', // ri-dashboard-3-fill
                'children' => []
            ],
            [
                'name' => 'Профиль',
                'link' => 'sidebarUserSettings',
                'icon' => 'ri-user-6-fill',
                'children' => [
                    [
                        'name' => 'Профиль',
                        'link' => '/dashboard/user-settings',
                        'class_li' => '',
                        'children' => []
                    ],
                    [
                        'name' => 'Покупки',
                        'link' => '/dashboard/user-orders',
                        'class_li' => '',
                        'children' => []
                    ]
                ]
            ]
        ]
    ];

    if ($mod == 'admin') {
        if ($userRole) {
            if ($userRole == 'SUPER_ADMIN') {
                return $nav_admin;
            } elseif ($userRole == 'EDITOR') {
                return $nav_admin_editors;
            }
        }
    }

    if ($mod == 'dashboard') {
        return $nav_dashboard;
    }
}

function top_nav_site($nav_light='') {
    $top_nav = '';
    $top_nav .= '<ul class="navigation-menu ' . $nav_light . '">';

    $top_nav .= '<li><a href="/documents" class="sub-menu-item">Документы</a></li>';
    $top_nav .= '<li><a href="/calculators" class="sub-menu-item">Калькуляторы</a></li>';
    $top_nav .= '<li><a href="/official-services" class="sub-menu-item">Сервисы</a></li>';

    $top_nav .= '</ul>';
    return $top_nav;
}

function footer_nav_site_1($nav_light='') {
    $footer_nav = '';
    $footer_nav .= '<ul class="list-unstyled footer-list mt-4">';
    $footer_nav .= '<li><a href="/documents" class="text-foot"><i class="uil uil-angle-right-b me-1"></i> Документы</a></li>';
    $footer_nav .= '<li><a href="/calculators" class="text-foot"><i class="uil uil-angle-right-b me-1"></i> Калькуляторы</a></li>';
    $footer_nav .= '<li><a href="/official-services" class="text-foot"><i class="uil uil-angle-right-b me-1"></i> Сервисы</a></li>';

    $footer_nav .= '</ul>';
    return $footer_nav;
}

function footer_nav_site_2($nav_light='') {
    $footer_nav = '';
    $footer_nav .= '<ul class="list-unstyled footer-list mt-4">';


    $footer_nav .= '<li><a href="/contacts" class="text-foot"><i class="uil uil-angle-right-b me-1"></i> Контакты</a></li>';
    $footer_nav .= '<li><a href="/payment-return-terms" class="text-foot"><i class="uil uil-angle-right-b me-1"></i> Условия оплаты и возврата</a></li>';
    $footer_nav .= '<li><a href="/privacy-policy" class="text-foot"><i class="uil uil-angle-right-b me-1"></i> Политика конфиденциальности</a></li>';

    $footer_nav .= '</ul>';
    return $footer_nav;
}
