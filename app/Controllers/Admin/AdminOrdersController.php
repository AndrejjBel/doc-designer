<?php

namespace App\Controllers\Admin;

use Hleb\Static\Request;
use Hleb\Base\Controller;
use Hleb\Constructor\Data\View;
use App\Models\{PostModel, OrdersModel};
use App\Content\ArrayPaginator;

class AdminOrdersController extends Controller
{
    public function index(): View
    {
        $order_limit = 12; //LIMIT_POSTS;
        $orderCount = OrdersModel::getOrdersCount();
        $pagesCount = ceil($orderCount/$order_limit);
        $cur_page = Request::get('page')->asInt();
        if (!$cur_page) {
            $cur_page = 1;
        }
        $orders = OrdersModel::getOrders($cur_page, $order_limit, 'id', 'DESC');
        return view('/admin/index',
            [
                'data'  => [
                    'temp' => 'orders',
                    'title' => 'Admin orders',
                    'description' => 'Admin orders description',
                    'mod' => 'admin',
                    'orders' => $orders,
                    'pagesCount' => $pagesCount,
                    'cur_page' => $cur_page
                ]
            ]
        );
    }

    public function dashboard(): View
    {
        $order_limit = 12; //LIMIT_POSTS;
        $orderCount = OrdersModel::getOrdersCount();
        $pagesCount = ceil($orderCount/$order_limit);
        $cur_page = Request::get('page')->asInt();
        if (!$cur_page) {
            $cur_page = 1;
        }
        $orders = OrdersModel::getOrders($cur_page, $order_limit, 'id', 'DESC');
        return view('/admin/index',
            [
                'data'  => [
                    'temp' => 'orders',
                    'title' => 'Dashboard orders',
                    'description' => 'Dashboard orders description',
                    'mod' => 'dashboard',
                    'orders' => $orders,
                    'pagesCount' => $pagesCount,
                    'cur_page' => $cur_page
                ]
            ]
        );
    }

    public function edit_order()
    {
        $order_id = Request::get('id')->asInt();

        return view('/admin/index',
            [
                'data'  => [
                    'temp' => 'order-edit',
                    'title' => 'Admin order edit',
                    'description' => 'Admin order edit description',
                    'mod' => 'admin',
                    'order' => $order_id
                ]
            ]
        );
    }

    public function edit_order_status()
    {
        $allPost = Request::allPost();
        $status = OrdersModel::orderStatusEdit($allPost['order_id'], $allPost['order_status']);
        echo json_encode($allPost, true);
    }

    public function add_order()
    {}
}
