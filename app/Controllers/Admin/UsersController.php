<?php

namespace App\Controllers\Admin;

use Hleb\Base\Controller;
use Hleb\Constructor\Data\View;
use App\Models\Admin\AdminUsersModel;
use App\Models\Myorm\MyormModel;

class UsersController extends Controller
{
    public function index(): View
    {
        $user_all = AdminUsersModel::getUsersAll(1, 20);
        $current_user = AdminUsersModel::getUser();

        return view('/admin/index',
            [
                'data'  => [
                    'temp' => 'users',
                    'title' => 'Пользователи',
                    'description' => 'Admin users description',
                    'mod' => 'admin',
                    'user_all' => $user_all,
                    'current_user' => $current_user
                ]
            ]
        );
    }

    public function users_admins(): View
    {
        $user_all = AdminUsersModel::getUsersAdmins(1, 20);
        $current_user = AdminUsersModel::getUser();

        return view('/admin/index',
            [
                'data'  => [
                    'temp' => 'users',
                    'title' => 'Администраторы',
                    'description' => 'Admin users description',
                    'mod' => 'admin',
                    'user_all' => $user_all,
                    'current_user' => $current_user
                ]
            ]
        );
    }

    public function users_lawyers(): View
    {
        $user_all = AdminUsersModel::getUsersLawyers(1, 20);
        $current_user = AdminUsersModel::getUser();

        return view('/admin/index',
            [
                'data'  => [
                    'temp' => 'users',
                    'title' => 'Юристы',
                    'description' => 'Admin users description',
                    'mod' => 'admin',
                    'user_all' => $user_all,
                    'current_user' => $current_user
                ]
            ]
        );
    }
}
