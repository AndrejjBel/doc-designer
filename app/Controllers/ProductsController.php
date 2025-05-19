<?php

namespace App\Controllers;

use Hleb\Base\Controller;
use Hleb\Constructor\Data\View;
use Hleb\Static\Request;
use App\Models\PostModel;

class ProductsController extends Controller
{
    public function index(): View
    {
        $post_limit = LIMIT_POSTS;
        $pagesCount = ceil(PostModel::getPostsCount('products')/$post_limit);
        $cur_page = Request::get('page')->asInt();
        if (!$cur_page) {
            $cur_page = 1;
        }
        $posts_data = PostModel::getPosts($cur_page, $post_limit, 'post_id', 'DESC', 'products');
        return view('products',
            [
                'data'  => [
                    'body_classes' => 'products',
                    'temp_header' => 'header-pages',
                    'title' => 'Products',
                    'description' => 'Products description',
                    'mod' => 'products',
                    'posts_data' => $posts_data,
                    'pagesCount' => $pagesCount,
                    'cur_page' => $cur_page
                ]
            ]
        );
    }

    public function product(): View
    {
        $post_slug = Request::param('post_slug')->asString();
        $post_data = PostModel::getPostForSlug($post_slug);
        return view('product',
            [
                'data'  => [
                    'body_classes' => 'product',
                    'temp_header' => 'header-pages',
                    'title' => 'Product',
                    'description' => 'Product description',
                    'mod' => 'product',
                    'post_data' => $post_data
                ]
            ]
        );
    }
}
