<?php

namespace App\Controllers\Admin;

use Hleb\Static\Request;
use Hleb\Base\Controller;
use Hleb\Constructor\Data\View;
use App\Content\ArrayPaginator;
use App\Models\{
    PostModel,
    OrdersModel
};

class AdminPostsController extends Controller
{
    public function index(): View
    {
        $post_limit = LIMIT_POSTS_ADMIN;
        $postCount = PostModel::getPostsCount();
        $pagesCount = ceil($postCount/$post_limit);
        $cur_page = Request::get('page')->asInt();
        if (!$cur_page) {
            $cur_page = 1;
        }
        $posts = PostModel::getPosts($cur_page, $post_limit, 'id', 'DESC', '');
        return view('/admin/index',
            [
                'data'  => [
                    'temp' => 'posts',
                    'title' => 'Admin orders',
                    'description' => 'Admin orders description',
                    'mod' => 'admin',
                    'posts' => $posts,
                    'pagesCount' => $pagesCount,
                    'cur_page' => $cur_page
                ]
            ]
        );
    }

    public function dashboard(): View
    {
        $post_limit = LIMIT_POSTS_ADMIN;
        $postCount = PostModel::getPostsCount();
        $pagesCount = ceil($postCount/$post_limit);
        $cur_page = Request::get('page')->asInt();
        if (!$cur_page) {
            $cur_page = 1;
        }
        $posts = PostModel::getPosts($cur_page, $post_limit, 'id', 'DESC', '');
        return view('/admin/index',
            [
                'data'  => [
                    'temp' => 'posts',
                    'title' => 'Dashboard orders',
                    'description' => 'Dashboard orders description',
                    'mod' => 'dashboard',
                    'posts' => $posts,
                    'pagesCount' => $pagesCount,
                    'cur_page' => $cur_page
                ]
            ]
        );
    }

    public function add_post()
    {
        return view('/admin/index',
            [
                'data'  => [
                    'temp' => 'post-add',
                    'title' => 'Admin post edit',
                    'description' => 'Admin post edit description',
                    'mod' => 'admin',
                    'br' => 'Консоль',
                ]
            ]
        );
    }

    public function edit_post()
    {
        $post_id = Request::get('id')->asInt();
        $post = PostModel::getPostForId($post_id);
        return view('/admin/index',
            [
                'data'  => [
                    'temp' => 'post-edit',
                    'title' => 'Admin post edit',
                    'description' => 'Admin post edit description',
                    'mod' => 'admin',
                    'br' => 'Консоль',
                    'post' => $post
                ]
            ]
        );
    }

    public function add_post_dashboard()
    {
        return view('/admin/index',
            [
                'data'  => [
                    'temp' => 'post-add',
                    'title' => 'Dashboard post edit',
                    'description' => 'Dashboard post edit description',
                    'mod' => 'dashboard',
                    'br' => 'Личный кабинет',
                ]
            ]
        );
    }

    public function edit_post_dashboard()
    {
        $post_id = Request::get('id')->asInt();
        $post = PostModel::getPostForId($post_id);
        return view('/admin/index',
            [
                'data'  => [
                    'temp' => 'post-edit',
                    'title' => 'Dashboard post edit',
                    'description' => 'Dashboard post edit description',
                    'mod' => 'dashboard',
                    'br' => 'Личный кабинет',
                    'post' => $post
                ]
            ]
        );
    }
}
