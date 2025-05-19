<?php

namespace App\Controllers\Admin;

use Hleb\Static\Request;
use Hleb\Base\Controller;
use Hleb\Constructor\Data\View;
use App\Models\PostModel;
use App\Content\ArrayPaginator;

class AdminProductsController extends Controller
{
    public function index(): View
    {
        $post_limit = 12; //LIMIT_POSTS;
        $postCount = PostModel::getPostsCount('products');
        $pagesCount = ceil(PostModel::getPostsCount('products')/$post_limit);
        $cur_page = Request::get('page')->asInt();
        if (!$cur_page) {
            $cur_page = 1;
        }
        $products = PostModel::getPosts($cur_page, $post_limit, 'post_id', 'DESC', 'products', '');
        return view('/admin/index',
            [
                'data'  => [
                    'temp' => 'products',
                    'title' => 'Admin products',
                    'description' => 'Admin products description',
                    'mod' => 'admin',
                    'products' => $products,
                    'pagesCount' => $pagesCount,
                    'cur_page' => $cur_page
                ]
            ]
        );
    }

    public function dashboard(): View
    {
        $post_limit = 12; //LIMIT_POSTS;
        $postCount = PostModel::getPostsCount('products');
        $pagesCount = ceil(PostModel::getPostsCount('products')/$post_limit);
        $cur_page = Request::get('page')->asInt();
        if (!$cur_page) {
            $cur_page = 1;
        }
        $products = PostModel::getPosts($cur_page, $post_limit, 'post_id', 'DESC', 'products', '');
        return view('/admin/index',
            [
                'data'  => [
                    'temp' => 'products',
                    'title' => 'Dashboard products',
                    'description' => 'Dashboard products description',
                    'mod' => 'dashboard',
                    'products' => $products,
                    'pagesCount' => $pagesCount,
                    'cur_page' => $cur_page
                ]
            ]
        );
    }
}
