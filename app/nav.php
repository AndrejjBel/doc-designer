<?php

function nav_obj($vars_obj) {
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
    $nav = [
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
    ];
    return $nav;
}
