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
                        'varsJson' => $varsJson
                    ]
                ]
            );
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
}
