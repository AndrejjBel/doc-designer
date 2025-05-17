<?php

namespace App\Controllers\Admin;

use Hleb\Static\Request;
use Hleb\Static\Redirect;
use Hleb\Base\Controller;
use Hleb\Constructor\Data\View;
use App\Content\ArrayPaginator;
use App\Models\{
    PostModel,
    OrdersModel,
    ReviewsModel,
    GlampingModel,
    Admin\AdminUsersModel
};

class ReviewsAdminController extends Controller
{
    public function index(): View
    {
        $post_limit = LIMIT_POSTS_ADMIN;
        $postCount = ReviewsModel::getPostsCount();
        $pagesCount = ceil($postCount/$post_limit);
        $cur_page = Request::get('page')->asInt();
        if (!$cur_page) {
            $cur_page = 1;
        }
        $posts = ReviewsModel::getPosts($cur_page, $post_limit, 'id', 'DESC', '');
        return view('/admin/index',
            [
                'data'  => [
                    'temp' => 'reviews',
                    'title' => 'Admin reviews',
                    'description' => 'Admin reviews description',
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
        $postCount = ReviewsModel::getPostsCount();
        $pagesCount = ceil($postCount/$post_limit);
        $cur_page = Request::get('page')->asInt();
        if (!$cur_page) {
            $cur_page = 1;
        }
        $posts = ReviewsModel::getPosts($cur_page, $post_limit, 'id', 'DESC', '');
        return view('/admin/index',
            [
                'data'  => [
                    'temp' => 'reviews',
                    'title' => 'Dashboard reviews',
                    'description' => 'Dashboard reviews description',
                    'mod' => 'dashboard',
                    'posts' => $posts,
                    'pagesCount' => $pagesCount,
                    'cur_page' => $cur_page
                ]
            ]
        );
    }

    public function add_review()
    {
        return view('/admin/index',
            [
                'data'  => [
                    'temp' => 'review-add',
                    'title' => 'Admin reviews add',
                    'description' => 'Admin reviews add description',
                    'mod' => 'admin',
                    'br' => 'Консоль'
                ]
            ]
        );
    }

    public function edit_review()
    {
        $post_id = Request::get('id')->asInt();
        $post = ReviewsModel::getPostForId($post_id);
        $glamping_id = $post['post_parent'];
        $glamping = GlampingModel::getPostForId($glamping_id);
        return view('/admin/index',
            [
                'data'  => [
                    'temp' => 'review-edit',
                    'title' => 'Admin reviews edit',
                    'description' => 'Admin reviews edit description',
                    'mod' => 'admin',
                    'br' => 'Консоль',
                    'post' => $post,
                    'glamping' => $glamping
                ]
            ]
        );
    }

    public function add_review_dashboard()
    {
        return view('/admin/index',
            [
                'data'  => [
                    'temp' => 'review-add',
                    'title' => 'Dashboard reviews edit',
                    'description' => 'Dashboard reviews edit description',
                    'mod' => 'dashboard',
                    'br' => 'Личный кабинет',
                ]
            ]
        );
    }

    public function edit_review_dashboard()
    {        
        $userId = userId();
        $post_id = Request::get('id')->asInt();
        $post = ReviewsModel::getPostForId($post_id);
        $glamping_id = $post['post_parent'];
        $glamping = GlampingModel::getPostForId($glamping_id);

        if (!$post) {
            Redirect::to('/dashboard/reviews');
        }
        if ((int)$userId != (int)$post['post_author']) {
            Redirect::to('/dashboard/reviews');
        }

        return view('/admin/index',
            [
                'data'  => [
                    'temp' => 'review-edit',
                    'title' => 'Dashboard reviews edit',
                    'description' => 'Dashboard reviews edit description',
                    'mod' => 'dashboard',
                    'br' => 'Личный кабинет',
                    'post' => $post,
                    'glamping' => $glamping
                ]
            ]
        );
    }
}
