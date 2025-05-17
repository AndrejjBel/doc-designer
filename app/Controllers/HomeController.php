<?php

namespace App\Controllers;

use Hleb\Static\Request;
use Hleb\Base\Controller;
use Hleb\Constructor\Data\View;
use App\Models\{
    PostModel,
    GlampingModel,
    ReviewsModel
};
use App\Content\Breadcrumb;

class HomeController extends Controller
{
    public function index(): View
    {
        // Breadcrumb::add('/category/', 'Категория');
        // Breadcrumb::add('/category/article', 'Статья', 0);
        // $breadcrumbs = Breadcrumb::out();
        $glamping = GlampingModel::getPostsHome();
        $reviews = ReviewsModel::getPostsHome(30);
        return view('home',
            [
                'data'  => [
                    'body_classes' => 'home',
                    'temp_header' => 'header-pages',
                    'title' => 'Home',
                    'description' => 'Home description',
                    'mod' => 'home',
                    'glamping' => $glamping,
                    'reviews' => $reviews,
                    'post_limit' => 0,
                    'postsCount' => 0,
                    'pagesCount' => 0,
                    'cur_page' => 0,
                    'breadcrumbs' => 0,
                    'paginator' => 0
                ]
            ]
        );
    }

    public function about(): View
    {
        return view('about',
            [
                'data'  => [
                    'body_classes' => 'about',
                    'temp_header' => 'header-pages',
                    'title' => 'About',
                    'description' => 'About description',
                    'mod' => 'about'
                ]
            ]
        );
    }

    public function services(): View
    {
        return view('services',
            [
                'data'  => [
                    'body_classes' => 'services',
                    'temp_header' => 'header-pages',
                    'title' => 'Services',
                    'description' => 'Services description',
                    'mod' => 'services'
                ]
            ]
        );
    }

    public function contact(): View
    {
        return view('contact',
            [
                'data'  => [
                    'body_classes' => 'contact',
                    'temp_header' => 'header-pages',
                    'title' => 'Contact',
                    'description' => 'Contact description',
                    'mod' => 'contact'
                ]
            ]
        );
    }

    public function cart(): View
    {
        $data = '';
        $posts_data_cart = '';
        $orders_arr = '';
        if (isset($_COOKIE['ordersProduct'])) {
            $orders = explode(';', $_COOKIE['ordersProduct']);
            $orders_arr = [];
            foreach ($orders as $value) {
                $orders_arr[explode('-', $value)[0]] = explode('-', $value)[1];
            }
            $data = $orders_arr;
            $posts = [];
            foreach ($data as $key => $value) {
                $posts[] = $key;
            }
            $posts_data = PostModel::getPostsForId(implode(',', $posts));
            $posts_data_cart = [];
            foreach ($posts_data as $key => $post) {
                if (in_array($post['post_id'], $posts)) {
                    $post['order_count'] = $orders_arr[(int)$post['post_id']];
                }
                $posts_data_cart[] = $post;
            }
        }
        return view('cart',
            [
                'data'  => [
                    'body_classes' => 'cart',
                    'temp_header' => 'header-pages',
                    'title' => 'Cart',
                    'description' => 'Cart description',
                    'mod' => 'cart',
                    'data' => $data,
                    'posts' => $posts_data_cart,
                    'orders_arr' => $orders_arr
                ]
            ]
        );
    }
}
