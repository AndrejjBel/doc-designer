<?php
/**
 * Структура элементов навигации сайта и админки
 *
*/
return [
    'admin_nav' => [
        'container'       => 'ul',
        'container_class' => 'side-nav',
        'container_id'    => '',
        'structure' => [
            [
                'name' => 'Консоль',
                'link' => '/admin',
                'icon' => 'ri-dashboard-3-fill',
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
                        'name' => 'Добавить пользователя',
                        'link' => '/admin/user-add',
                        'class_li' => '',
                        'children' => []
                    ]
                ]
            ],
            [
                'name' => 'Глэмпинги',
                'link' => 'sidebarGlampings',
                'icon' => 'ri-landscape-fill',
                'children' => [
                    [
                        'name' => 'Все глэмпинги',
                        'link' => '/admin/glampings',
                        'class_li' => '',
                        'children' => []
                    ],
                    [
                        'name' => 'Добавить глэмпинг',
                        'link' => '/admin/glamping-add',
                        'class_li' => '',
                        'children' => []
                    ],
                    [
                        'name' => 'Регионы',
                        'link' => '/admin/location',
                        'class_li' => '',
                        'children' => []
                    ],
                    [
                        'name' => 'Редактировать глэмпинг',
                        'link' => '/admin/glamping-edit',
                        'class_li' => 'd-none',
                        'children' => []
                    ]
                ]
            ],
            [
                'name' => 'Отзывы',
                'link' => 'sidebarReviews',
                'icon' => 'ri-star-s-fill',
                'children' => [
                    [
                        'name' => 'Все отзывы',
                        'link' => '/admin/reviews',
                        'class_li' => '',
                        'children' => []
                    ],
                    [
                        'name' => 'Добавить отзыв',
                        'link' => '/admin/review-add',
                        'class_li' => '',
                        'children' => []
                    ],
                    [
                        'name' => 'Редактировать отзыв',
                        'link' => '/admin/review-edit',
                        'class_li' => 'd-none',
                        'children' => []
                    ]
                ]
            ],
            [
                'name' => 'Блог',
                'link' => 'sidebarPosts',
                'icon' => 'ri-git-repository-fill',
                'children' => [
                    [
                        'name' => 'Все записи',
                        'link' => '/admin/posts',
                        'class_li' => '',
                        'children' => []
                    ],
                    [
                        'name' => 'Добавить запись',
                        'link' => '/admin/post-add',
                        'class_li' => '',
                        'children' => []
                    ],
                    // [
                    //     'name' => 'Категории блога',
                    //     'link' => '/admin/post-category',
                    //     'class_li' => '',
                    //     'children' => []
                    // ],
                    [
                        'name' => 'Редактировать запись',
                        'link' => '/admin/post-edit',
                        'class_li' => 'd-none',
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
            [
                'name' => 'Глэмпинги',
                'link' => 'sidebarGlampings',
                'icon' => 'ri-landscape-fill',
                'children' => [
                    [
                        'name' => 'Все глэмпинги',
                        'link' => '/dashboard/glampings',
                        'class_li' => '',
                        'children' => []
                    ],
                    [
                        'name' => 'Добавить глэмпинг',
                        'link' => '/dashboard/glamping-add',
                        'class_li' => '',
                        'children' => []
                    ],
                    [
                        'name' => 'Редактировать глэмпинг',
                        'link' => '/dashboard/glamping-edit',
                        'class_li' => 'd-none',
                        'children' => []
                    ]
                ]
            ],
            [
                'name' => 'Отзывы',
                'link' => 'sidebarReviews',
                'icon' => 'ri-star-s-fill',
                'children' => [
                    [
                        'name' => 'Все отзывы',
                        'link' => '/dashboard/reviews',
                        'class_li' => '',
                        'children' => []
                    ],
                    [
                        'name' => 'Добавить отзыв',
                        'link' => '/dashboard/review-add',
                        'class_li' => '',
                        'children' => []
                    ],
                    [
                        'name' => 'Редактировать отзыв',
                        'link' => '/dashboard/review-edit',
                        'class_li' => 'd-none',
                        'children' => []
                    ]
                ]
            ],
            [
                'name' => 'Блог',
                'link' => 'sidebarPosts',
                'icon' => 'ri-git-repository-fill',
                'children' => [
                    [
                        'name' => 'Все записи',
                        'link' => '/dashboard/posts',
                        'class_li' => '',
                        'children' => []
                    ],
                    [
                        'name' => 'Добавить запись',
                        'link' => '/dashboard/post-add',
                        'class_li' => '',
                        'children' => []
                    ],
                    [
                        'name' => 'Редактировать запись',
                        'link' => '/dashboard/post-edit',
                        'class_li' => 'd-none',
                        'children' => []
                    ]
                ]
            ],
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
        'container_class' => 'navigation-menu nav-light',
        'container_id'    => '',
        'structure' => [
            [
                'name' => 'Каталог',
                'link' => '/glampings/',
                'icon' => '',
                'children' => []
            ],
            [
                'name' => 'Регионы',
                'link' => '/location/',
                'icon' => '',
                'children' => []
            ],
            [
                'name' => 'О проекте',
                'link' => '/o-proekte/',
                'icon' => '',
                'children' => []
            ],
            [
                'name' => 'Контакты',
                'link' => '/contact/',
                'icon' => '',
                'children' => []
            ],
            [
                'name' => 'Блог',
                'link' => '/blog/',
                'icon' => '',
                'children' => []
            ],
        ]
    ]
];
