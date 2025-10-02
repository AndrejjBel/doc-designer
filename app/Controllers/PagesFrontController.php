<?php

namespace App\Controllers;

use Hleb\Base\Controller;
use Hleb\Constructor\Data\View;
use Hleb\Static\Request;
use Hleb\Static\Redirect;
use App\Models\{
    PagesModel,
    ProductsModel,
    VarsModel
};
use App\Controllers\{
    Admin\AdminController,
    Auth\SigninController,
    Auth\ForgotPassController,
    Auth\VerifyController
};

use App\Content\{
    Breadcrumb,
    Paginator
};

class PagesFrontController extends Controller
{
    public function index(): View
    {
        // $post_limit = LIMIT_POSTS;
        // $pagesCount = ceil(PostModel::getPostsCount('products')/$post_limit);
        // $cur_page = Request::get('page')->asInt();
        // if (!$cur_page) {
        //     $cur_page = 1;
        // }
        // $posts_data = PostModel::getPosts($cur_page, $post_limit, 'post_id', 'DESC', 'products');
        // return view('products',
        //     [
        //         'data'  => [
        //             'body_classes' => 'products',
        //             'temp_header' => 'header-pages',
        //             'title' => 'Products',
        //             'description' => 'Products description',
        //             'mod' => 'products',
        //             'posts_data' => $posts_data,
        //             'pagesCount' => $pagesCount,
        //             'cur_page' => $cur_page
        //         ]
        //     ]
        // );
    }

    public function pages_item(): View
    {
        $page_slug = Request::param('slug')->asString();

        if ($page_slug == 'signin') {
            return (new SigninController())->index();
        }
        if ($page_slug == 'forgot-password') {
            return (new ForgotPassController())->showPasswordForm();
        }
        if ($page_slug == 'verify') {
            return (new VerifyController())->index();
        }

        if ($page_slug == 'admin') {
            return (new AdminController())->index();
        }
        if ($page_slug == 'dashboard') {
            return (new AdminController())->dashboard();
        }
        if ($page_slug == 'privacy-policy') {
            Breadcrumb::add('/privacy-policy/', 'Политика конфиденциальности', 0);
            $breadcrumbs = Breadcrumb::out();
            return view('privacy-policy',
                [
                    'data'  => [
                        'body_classes' => 'page cont-page privacy-policy',
                        'temp_header' => 'header-cont-page',
                        'title' => 'Политика конфиденциальности',
                        'description' => 'Политика конфиденциальности в Онлайн конструкторе быстрого создания юридических документов без ошибок.',
                        'mod' => 'page',
                        'script_rend' => '',
                        'breadcrumbs' => $breadcrumbs
                    ]
                ]
            );
        }
        if ($page_slug == 'official-services') {
            Breadcrumb::add('/official-services/', 'Официальный перечень служб', 0);
            $breadcrumbs = Breadcrumb::out();
            return view('official-services',
                [
                    'data'  => [
                        'body_classes' => 'page cont-page official-services',
                        'temp_header' => 'header-cont-page',
                        'title' => 'Официальный перечень служб для мониторинга ситуации',
                        'description' => 'Официальный перечень служб для мониторинга ситуации в Онлайн конструкторе быстрого создания юридических документов без ошибок.',
                        'mod' => 'page',
                        'script_rend' => '',
                        'breadcrumbs' => $breadcrumbs
                    ]
                ]
            );
        }
        if ($page_slug == 'services') {
            Breadcrumb::add('/services/', 'Услуги', 0);
            $breadcrumbs = Breadcrumb::out();
            return view('services',
                [
                    'data'  => [
                        'body_classes' => 'page cont-page services',
                        'temp_header' => 'header-cont-page',
                        'title' => 'Услуги',
                        'description' => 'Услуги в Онлайн конструкторе быстрого создания юридических документов без ошибок.',
                        'mod' => 'page',
                        'script_rend' => '',
                        'breadcrumbs' => $breadcrumbs,
                    ]
                ]
            );
        }
        if ($page_slug == 'documents') {
            // $products_all = ProductsModel::getProductsAll();
            $products = ProductsModel::getProductsDocPage();
            Breadcrumb::add('/documents/', 'Документы', 0);
            $breadcrumbs = Breadcrumb::out();
            return view('documents',
                [
                    'data'  => [
                        'body_classes' => 'page cont-page documents',
                        'temp_header' => 'header-cont-page',
                        'title' => 'Документы',
                        'description' => 'Документы в Онлайн конструкторе быстрого создания юридических документов без ошибок.',
                        'mod' => 'page',
                        'script_rend' => '',
                        'products' => $products,
                        // 'products_all' => $products_all,
                        'breadcrumbs' => $breadcrumbs
                    ]
                ]
            );
        }
        if ($page_slug == 'contacts') {
            Breadcrumb::add('/contacts/', 'Контакты', 0);
            $breadcrumbs = Breadcrumb::out();
            return view('contacts',
                [
                    'data'  => [
                        'body_classes' => 'page cont-page contacts bg-light bg-gradient',
                        'temp_header' => 'header-cont-page',
                        'title' => 'Контакты',
                        'description' => 'Контакты в Онлайн конструкторе быстрого создания юридических документов без ошибок.',
                        'mod' => 'page',
                        'script_rend' => '',
                        'breadcrumbs' => $breadcrumbs
                    ]
                ]
            );
        }
        if ($page_slug == 'calculators') {
            Breadcrumb::add('/calculators/', 'Калькуляторы', 0);
            $breadcrumbs = Breadcrumb::out();
            return view('calculators',
                [
                    'data'  => [
                        'body_classes' => 'page cont-page calculators neustojka-brak',
                        'temp_header' => 'header-cont-page',
                        'title' => 'Калькуляторы',
                        'description' => 'Калькуляторы в Онлайн конструкторе быстрого создания юридических документов без ошибок.',
                        'mod' => 'page',
                        'script_rend' => '',
                        'breadcrumbs' => $breadcrumbs,
                    ]
                ]
            );
        }
        $page_data = PagesModel::getPostForSlug($page_slug);
        if ($page_data) {
            $vars = '';
            $varsJson = '';
            $script_rend = '';
            $view = 'page';
            $mod = 'page';
            $temp_header = 'header-cont-page';
            $body_classes = 'page page-templates';
            if ((int)$page_data['product_id']) {
                $product = ProductsModel::getProductForId($page_data['product_id']);
                $vars = VarsModel::getVarsAll();
                $varsJson = VarsModel::getVarsAllJsonFront();
                $script_rend = 'product';
                $body_classes = 'page page-templates doc-page';
                $view = 'cont-page';
            } else {
                $product = 0;
            }

            if ($page_data['terms'] == 'cont_page') {
                $view = 'cont-page';
                $mod = 'cont_page';
                $body_classes = 'page page-templates cont-page';
                $temp_header = 'header-cont-page';
            }

            if ($page_data['status']) {
                Breadcrumb::add($page_slug, $page_data['title'], 0);
                $breadcrumbs = Breadcrumb::out();
                return view($view,
                    [
                        'data'  => [
                            'body_classes' => $body_classes,
                            'temp_header' => $temp_header,
                            'title' => 'Page',
                            'description' => 'Page description',
                            'mod' => $mod,
                            'script_rend' => $script_rend,
                            'page_data' => $page_data,
                            'product' => $product,
                            'vars' => $vars,
                            'varsJson' => $varsJson,
                            'breadcrumbs' => $breadcrumbs
                        ]
                    ]
                );
            } else {
                return view("404-page");
            }
        } else {
            return view("404-page");
        }
    }

    public function products_pages(): View
    {
        $page_slug = Request::param('slug')->asString();
        $page_data = PagesModel::getPostForSlug($page_slug);
        $product = ProductsModel::getProductForId($page_data[0]['product_id']);
        $vars = VarsModel::getVarsAll();
        $varsJson = VarsModel::getVarsAllJsonFront();
        return view('page',
            [
                'data'  => [
                    'body_classes' => 'page page-templates',
                    'temp_header' => 'header-pages',
                    'title' => 'Page',
                    'description' => 'Page description',
                    'mod' => 'page',
                    'script_rend' => $script_rend,
                    'page_data' => $page_data,
                    'product' => $product,
                    'vars' => $vars,
                    'varsJson' => $varsJson
                ]
            ]
        );
    }

    public function neustojka_brak(): View
    {
        Breadcrumb::add('/calculators/', 'Калькуляторы');
        Breadcrumb::add('/neustojka-brak/', 'Калькулятор - неустойка, брак', 0);
        $breadcrumbs = Breadcrumb::out();
        return view('templates/calculators/neustojka_brak',
            [
                'data'  => [
                    'body_classes' => 'page cont-page calculators neustojka-brak',
                    'temp_header' => 'header-cont-page',
                    'title' => 'Калькулятор - неустойка, брак',
                    'description' => 'Калькулятор - неустойка, брак в Онлайн конструкторе быстрого создания юридических документов без ошибок.',
                    'mod' => 'page',
                    'script_rend' => 'calculators',
                    'breadcrumbs' => $breadcrumbs,
                ]
            ]
        );
    }
}
