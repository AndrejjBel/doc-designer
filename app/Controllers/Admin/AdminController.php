<?php

namespace App\Controllers\Admin;

use Hleb\Base\Controller;
use Hleb\Constructor\Data\View;
use Hleb\Static\Request;
use App\Models\Admin\AdminModel;

class AdminController extends Controller
{
    public function index(): View
    {
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
}
