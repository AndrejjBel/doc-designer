<?php

namespace App\Controllers;

use Hleb\Base\Controller;
use Hleb\Constructor\Data\View;
use Hleb\Static\Request;
use App\Models\{
    PagesModel,
    ProductsModel,
    VarsModel,
    User\UsersModel
};
use App\Controllers\Admin\AdminController;

class ProductsFrontController extends Controller
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
        if ($page_slug == 'admin') {
            return (new AdminController())->index();
        }
        if ($page_slug == 'dashboard') {
            return (new AdminController())->dashboard();
        }

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
                    'page_data' => $page_data,
                    'product' => $product,
                    'vars' => $vars,
                    'varsJson' => $varsJson
                ]
            ]
        );
    }

    public function products_pages(): View
    {
        $page_slug = Request::param('slug')->asString();
        $product = ProductsModel::getProductForSlug($page_slug);
        if ($product) {
            $user = UsersModel::getUser();
            $vars = VarsModel::getVarsAll();
            $varsJson = VarsModel::getVarsAllJsonFront();
            return view('product',
                [
                    'data'  => [
                        'body_classes' => 'page page-templates',
                        'temp_header' => 'header-pages',
                        'title' => 'Page',
                        'description' => 'Page description',
                        'mod' => 'page',
                        'script_rend' => 'product',
                        'page_slug' => $page_slug,
                        'product' => $product,
                        'vars' => $vars,
                        'varsJson' => $varsJson,
                        'user' => $user
                    ]
                ]
            );
        } else {
            return view('404');
        }
    }
}
