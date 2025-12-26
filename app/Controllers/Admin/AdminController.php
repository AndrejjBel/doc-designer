<?php

namespace App\Controllers\Admin;

use Hleb\Base\Controller;
use Hleb\Constructor\Data\View;
use Hleb\Static\Request;
use Hleb\Static\Redirect;
use App\Models\{
    Admin\AdminModel,
    OrdersModel,
    ProductsModel,
    VarsModel,
    DocOrdersModel,
    DocCommentsModel,
    User\UsersModel
};

class AdminController extends Controller
{
    public function index(): View
    {
        if (! AdminModel::is_admin_allowed()) { // is_logged is_admin_allowed
            Redirect::to('/');
        } else {
            return view('/admin/index',
                [
                    'data'  => [
                        'temp' => 'generale',
                        'title' => 'Admin',
                        'description' => 'Admin description',
                        'mod' => 'admin'
                    ]
                ]
            );
        }
    }

    public function admin_settings(): View
    {
        $site_settings = AdminModel::get_site_settings('site_settings');
        return view('/admin/index',
            [
                'data'  => [
                    'temp' => 'settings',
                    'title' => 'Settings',
                    'description' => 'Settings description',
                    'site_settings' => $site_settings,
                    'mod' => 'admin'
                ]
            ]
        );
    }

    public function admin_settings_pay(): View
    {
        $site_settings = AdminModel::get_site_settings('site_settings');
        return view('/admin/index',
            [
                'data'  => [
                    'temp' => 'settings-pay',
                    'title' => 'Settings pay',
                    'description' => 'Settings pay description',
                    'site_settings' => $site_settings,
                    'mod' => 'admin'
                ]
            ]
        );
    }

    public function user_settings(): View
    {
        $user = userAllDataMeta();

        return view('/admin/index',
            [
                'data'  => [
                    'temp' => 'user-settings',
                    'title' => 'User settings',
                    'description' => 'User settings description',
                    'mod' => 'admin',
                    'user' => $user
                ]
            ]
        );
    }

    public function orders(): View
    {
        $post_limit = LIMIT_POSTS_ADMIN;
        $postCount = OrdersModel::getOrdersCount();
        $pagesCount = ceil($postCount/$post_limit);
        $cur_page = Request::get('page')->asInt();
        if (!$cur_page) {
            $cur_page = 1;
        }
        $user = userAllDataMeta();
        $orders = OrdersModel::getOrders($cur_page, $post_limit, 'id', 'DESC');
        $products = ProductsModel::getProductsAll();
        $loginsEmails = UsersModel::getLoginsEmails();
        $vars = VarsModel::getVarsAll();

        return view('/admin/index',
            [
                'data'  => [
                    'temp' => 'orders',
                    'title' => 'Продажи',
                    'description' => 'Orders description',
                    'mod' => 'admin',
                    'user' => $user,
                    'orders' => $orders,
                    'products' => $products,
                    'post_limit' => $post_limit,
                    'postCount' => $postCount,
                    'pagesCount' => $pagesCount,
                    'cur_page' => $cur_page,
                    'loginsEmails' => $loginsEmails,
                    'vars' => $vars
                ]
            ]
        );
    }

    public function orders_documents(): View
    {
        $post_limit = LIMIT_POSTS_ADMIN;
        $postCount = DocOrdersModel::getOrdersDocCount();
        $pagesCount = ceil($postCount/$post_limit);
        $cur_page = Request::get('page')->asInt();
        if (!$cur_page) {
            $cur_page = 1;
        }
        $user = userAllDataMeta();
        $orders = DocOrdersModel::getOrdersDoc($cur_page, $post_limit, 'id', 'DESC');
        $products = ProductsModel::getProductsAll();
        $loginsEmails = UsersModel::getLoginsEmails();
        $vars = VarsModel::getVarsAll();

        return view('/admin/index',
            [
                'data'  => [
                    'temp' => 'doc-orders',
                    'title' => 'Заказы документов',
                    'description' => 'Orders description',
                    'mod' => 'admin',
                    'user' => $user,
                    'orders' => $orders,
                    'products' => $products,
                    'post_limit' => $post_limit,
                    'postCount' => $postCount,
                    'pagesCount' => $pagesCount,
                    'cur_page' => $cur_page,
                    'loginsEmails' => $loginsEmails,
                    'vars' => $vars
                ]
            ]
        );
    }

    public function doc_order(): View
    {
        $id = Request::get('id')->asInt();
        if (!$id) {
            Redirect::to('/admin/orders-documents');
        }
        $order = DocOrdersModel::getOrder($id);
        $comments = DocCommentsModel::getCommentsOrder($id);
        $user = userAllDataMeta();
        return view('/admin/index',
            [
                'data'  => [
                    'temp' => 'doc-order',
                    'title' => 'Doc order',
                    'description' => 'Doc order description',
                    'mod' => 'admin',
                    'user' => $user,
                    'order_id' => $id,
                    'order' => $order,
                    'comments' => $comments
                ]
            ]
        );
    }

    public function user_orders_admin(): View
    {
        $user = userAllDataMeta();
        $post_limit = LIMIT_POSTS_ADMIN;
        $postCount = OrdersModel::getOrdersUserCount($user['id']);
        $pagesCount = ceil($postCount/$post_limit);
        $cur_page = Request::get('page')->asInt();
        if (!$cur_page) {
            $cur_page = 1;
        }
        $orders = OrdersModel::getOrdersUserPagin($cur_page, $post_limit, 'id', 'DESC', $user['id']);
        $products = ProductsModel::getProductsAll();

        return view('/admin/index',
            [
                'data'  => [
                    'temp' => 'user-orders',
                    'title' => 'User orders',
                    'description' => 'User orders description',
                    'mod' => 'admin',
                    'user' => $user,
                    'orders' => $orders,
                    'products' => $products,
                    'post_limit' => $post_limit,
                    'postCount' => $postCount,
                    'pagesCount' => $pagesCount,
                    'cur_page' => $cur_page
                ]
            ]
        );
    }

    public function users_landings(): View
    {
        $user = userAllDataMeta();

        return view('/admin/index',
            [
                'data'  => [
                    'temp' => 'landings',
                    'title' => 'Users landings',
                    'description' => 'Users landings description',
                    'mod' => 'admin',
                    'user' => $user
                ]
            ]
        );
    }

    public function users_landing_add(): View
    {
        $user = userAllDataMeta();

        return view('/admin/index',
            [
                'data'  => [
                    'temp' => 'landing-add',
                    'title' => 'Landing add',
                    'description' => 'Landing add description',
                    'mod' => 'admin',
                    'user' => $user
                ]
            ]
        );
    }

    public function dashboard(): View
    {
        if (! AdminModel::is_logged()) { // is_logged is_admin_allowed
            Redirect::to('/');
        } else {
            return view('/admin/index',
                [
                    'data'  => [
                        'temp' => 'dashboard',
                        'title' => 'Dashboard',
                        'description' => 'Dashboard description',
                        'mod' => 'dashboard'
                    ]
                ]
            );
        }
    }

    public function user_settings_dashboard(): View
    {
        $user = userAllDataMeta();

        return view('/admin/index',
            [
                'data'  => [
                    'temp' => 'user-settings',
                    'title' => 'User settings',
                    'description' => 'User settings description',
                    'mod' => 'dashboard',
                    'user' => $user
                ]
            ]
        );
    }

    public function user_orders_dashboard(): View
    {
        $user = userAllDataMeta();
        $post_limit = LIMIT_POSTS_ADMIN;
        $postCount = OrdersModel::getOrdersUserCount($user['id']);
        $pagesCount = ceil($postCount/$post_limit);
        $cur_page = Request::get('page')->asInt();
        if (!$cur_page) {
            $cur_page = 1;
        }
        $orders = OrdersModel::getOrdersUserPagin($cur_page, $post_limit, 'id', 'DESC', $user['id']);
        $products = ProductsModel::getProductsAll();

        return view('/admin/index',
            [
                'data'  => [
                    'temp' => 'user-orders',
                    'title' => 'User orders',
                    'description' => 'User orders description',
                    'mod' => 'dashboard',
                    'user' => $user,
                    'orders' => $orders,
                    'products' => $products,
                    'post_limit' => $post_limit,
                    'postCount' => $postCount,
                    'pagesCount' => $pagesCount,
                    'cur_page' => $cur_page
                ]
            ]
        );
    }

    public function user_orders_documents(): View
    {
        $post_limit = LIMIT_POSTS_ADMIN;
        $postCount = DocOrdersModel::getOrdersDocCount();
        $pagesCount = ceil($postCount/$post_limit);
        $cur_page = Request::get('page')->asInt();
        if (!$cur_page) {
            $cur_page = 1;
        }
        $user = userAllDataMeta();
        $orders = DocOrdersModel::getOrdersUserPagin($cur_page, $post_limit, 'id', 'DESC', $user['id']);
        $products = ProductsModel::getProductsAll();
        $loginsEmails = UsersModel::getLoginsEmails();
        $vars = VarsModel::getVarsAll();

        return view('/admin/index',
            [
                'data'  => [
                    'temp' => 'doc-orders',
                    'title' => 'Заказы документов',
                    'description' => 'Orders description',
                    'mod' => 'dashboard',
                    'user' => $user,
                    'orders' => $orders,
                    'products' => $products,
                    'post_limit' => $post_limit,
                    'postCount' => $postCount,
                    'pagesCount' => $pagesCount,
                    'cur_page' => $cur_page,
                    'loginsEmails' => $loginsEmails,
                    'vars' => $vars
                ]
            ]
        );
    }

    public function user_doc_order(): View
    {
        $id = Request::get('id')->asInt();
        if (!$id) {
            Redirect::to('/dashboard/orders-documents');
        }
        $order = DocOrdersModel::getOrder($id);
        $comments = DocCommentsModel::getCommentsOrder($id);
        $user = userAllDataMeta();
        if ($user['id'] != $order['clientid']) {
            Redirect::to('/dashboard/orders-documents');
        }
        return view('/admin/index',
            [
                'data'  => [
                    'temp' => 'doc-order',
                    'title' => 'User doc order',
                    'description' => 'User doc order description',
                    'mod' => 'dashboard',
                    'user' => $user,
                    'order_id' => $id,
                    'order' => $order,
                    'comments' => $comments
                ]
            ]
        );
    }

    public function user_landing_dashboard(): View
    {
        $user = userAllDataMeta();

        return view('/admin/index',
            [
                'data'  => [
                    'temp' => 'landing',
                    'title' => 'User landing',
                    'description' => 'User landing description',
                    'mod' => 'dashboard',
                    'user' => $user
                ]
            ]
        );
    }

    public function site_settings()
    {
        $allPost = Request::allPost();
        unset($allPost['_token']);
        $message = [];

        $site_settings = AdminModel::get_site_settings('site_settings');
        if (count($site_settings)) {
            AdminModel::update_site_settings(
                [
                    'option_name'  => 'site_settings',
                    'option_value' => json_encode($allPost, JSON_UNESCAPED_UNICODE)
                ]
            );
        } else {
            AdminModel::set_site_settings(
                [
                    'option_name'  => 'site_settings',
                    'option_value' => json_encode($allPost, JSON_UNESCAPED_UNICODE)
                ]
            );
        }

        $message['allPost'] = $allPost;
        $message['site_settings'] = $site_settings;

        $message_fin = json_encode($message, JSON_UNESCAPED_UNICODE);
        echo $message_fin;
    }

    public function site_settings_pay()
    {
        $allPost = Request::allPost();
        unset($allPost['_token']);
        $message = [];

        $allPost['pay_pass'] = bin2hex($allPost['pay_pass']);

        $site_settings = AdminModel::get_site_settings('site_settings_pay');
        if ($site_settings) {
            AdminModel::update_site_settings(
                [
                    'option_name'  => 'site_settings_pay',
                    'option_value' => json_encode($allPost, JSON_UNESCAPED_UNICODE)
                ]
            );
        } else {
            AdminModel::set_site_settings(
                [
                    'option_name'  => 'site_settings_pay',
                    'option_value' => json_encode($allPost, JSON_UNESCAPED_UNICODE)
                ]
            );
        }

        $message['allPost'] = $allPost;
        $message['site_settings'] = $site_settings;

        $message_fin = json_encode($message, JSON_UNESCAPED_UNICODE);
        echo $message_fin;
    }
}
