<?php
/**
 * Структура элементов навигации сайта и админки
 *
*/

$vars = [
    [
        'name' => 'Все переменные',
        'link' => '/admin/vars',
        'class_li' => '',
        'children' => []
    ],
    [
        'name' => 'Добавить переменную',
        'link' => '/admin/vars-add',
        'class_li' => '',
        'children' => []
    ]
];

// $vars = vars_sections();
return [
    'admin_nav' => [
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
                'name' => 'Переменные',
                'link' => 'sidebarVars',
                'icon' => 'bi bi-hash', // ri-dashboard-3-fill
                'children' => $vars
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
                        'name' => 'Добавить пользователя',
                        'link' => '/admin/user-add',
                        'class_li' => '',
                        'children' => []
                    ]
                ]
            ],
            // [
            //     'name' => 'Лендинги',
            //     'link' => 'sidebarLandings',
            //     'icon' => 'ri-pages-fill',
            //     'children' => [
            //         [
            //             'name' => 'Все лендинги',
            //             'link' => '/admin/landings',
            //             'class_li' => '',
            //             'children' => []
            //         ],
            //         [
            //             'name' => 'Добавить лендинг',
            //             'link' => '/admin/landing-add',
            //             'class_li' => '',
            //             'children' => []
            //         ]
            //     ]
            // ],
            // [
            //     'name' => 'Товары',
            //     'link' => 'sidebarProducts',
            //     'icon' => 'ri-store-3-fill',
            //     'children' => [
            //         [
            //             'name' => 'Все товары',
            //             'link' => '/admin/products',
            //             'class_li' => '',
            //             'children' => []
            //         ],
            //         [
            //             'name' => 'Добавить товар',
            //             'link' => '/admin/product-add',
            //             'class_li' => '',
            //             'children' => []
            //         ],
            //         [
            //             'name' => 'Редактировать товар',
            //             'link' => '/admin/product-edit',
            //             'class_li' => 'd-none',
            //             'children' => []
            //         ]
            //     ]
            // ],
            // [
            //     'name' => 'Заказы',
            //     'link' => 'sidebarOrders',
            //     'icon' => 'ri-shopping-basket-2-fill',
            //     'children' => [
            //         [
            //             'name' => 'Все заказы',
            //             'link' => '/admin/orders',
            //             'class_li' => '',
            //             'children' => []
            //         ],
            //         [
            //             'name' => 'Добавить заказ',
            //             'link' => '/admin/order-add',
            //             'class_li' => 'pe-none',
            //             'children' => []
            //         ],
            //         [
            //             'name' => 'Редактировать заказ',
            //             'link' => '/admin/order-edit',
            //             'class_li' => 'd-none',
            //             'children' => []
            //         ]
            //     ]
            // ],
            [
                'name' => 'Профиль',
                'link' => '/admin/user-settings',
                'icon' => 'ri-user-6-fill',
                'children' => []
            ],
            [
                'name' => 'Настройки',
                'link' => '/admin/settings',
                'icon' => 'ri-settings-5-fill',
                'children' => []
            ]
        ]
    ],

    'dashboard_nav' => [
        'container'       => 'ul',
        'container_class' => 'side-nav',
        'container_id'    => '',
        'structure' => [
            [
                'name' => 'Личный кабинет',
                'link' => '/dashboard',
                'icon' => 'ri-dashboard-3-fill',
                'children' => []
            ],
            // [
            //     'name' => 'Товары',
            //     'link' => 'sidebarProducts',
            //     'icon' => 'ri-store-3-fill',
            //     'children' => [
            //         [
            //             'name' => 'Все товары',
            //             'link' => '/dashboard/products',
            //             'class_li' => '',
            //             'children' => []
            //         ],
            //         [
            //             'name' => 'Добавить товар',
            //             'link' => '/dashboard/product-add',
            //             'class_li' => '',
            //             'children' => []
            //         ],
            //         [
            //             'name' => 'Редактировать товар',
            //             'link' => '/dashboard/product-edit',
            //             'class_li' => 'd-none',
            //             'children' => []
            //         ]
            //     ]
            // ],
            // [
            //     'name' => 'Заказы',
            //     'link' => 'sidebarOrders',
            //     'icon' => 'ri-shopping-basket-2-fill',
            //     'children' => [
            //         [
            //             'name' => 'Все заказы',
            //             'link' => '/dashboard/orders',
            //             'class_li' => '',
            //             'children' => []
            //         ],
            //         [
            //             'name' => 'Добавить заказ',
            //             'link' => '/dashboard/order-add',
            //             'class_li' => 'pe-none',
            //             'children' => []
            //         ],
            //         [
            //             'name' => 'Редактировать заказ',
            //             'link' => '/dashboard/order-edit',
            //             'class_li' => 'd-none',
            //             'children' => []
            //         ]
            //     ]
            // ],
            // [
            //     'name' => 'Лендинг',
            //     'link' => '/dashboard/landing',
            //     'icon' => 'ri-pages-fill',
            //     'children' => []
            // ],
            [
                'name' => 'Профиль',
                'link' => '/dashboard/user-settings',
                'icon' => 'ri-user-6-fill',
                'children' => []
            ]
        ]
    ],

    'site_primary_nav' => [
        'container'       => 'ul',
        'container_class' => 'navigation-menu',
        'container_id'    => '',
        'structure' => [
            [
                'name' => 'Главная',
                'link' => '/',
                'icon' => '',
                'children' => []
            ],
            [
                'name' => 'Изделия',
                'link' => '/products',
                'icon' => '',
                'children' => []
            ],
            [
                'name' => 'О нас',
                'link' => '/about',
                'icon' => '',
                'children' => []
            ],
            [
                'name' => 'Услуги',
                'link' => '/services',
                'icon' => '',
                'children' => []
            ],
            [
                'name' => 'Контакты',
                'link' => '/contact',
                'icon' => '',
                'children' => []
            ]
        ]
    ]
];
