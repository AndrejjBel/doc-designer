<?php

namespace App\Controllers\Admin;

use Hleb\Base\Controller;
use Hleb\Constructor\Data\View;
use App\Models\Myorm\MyormModel;
use App\Models\User\UsersModel;
use Hleb\Static\Redirect;
use Hleb\Static\Request;

class UserEditController extends Controller
{
    public function index()
    {}

    public function editUser()
    {
        if (isset($_POST)) {
    		if (isset($_POST['action'])) {
    			if ($_POST['action'] == 'user_edit') {
                    $error = [];

                    $user_id = str_replace('user', '', $_POST['user_id']);

                    if ( !$_POST['email'] ) {
                        $error['text'] = 'Заполните поле E-mail';
                    }
                    else {
                        if (unicUserEmail($_POST['email'])) {
                            if (unicUserEmail($_POST['email'])['id'] != $user_id) {
                                $error['text'] = 'Пользователь с таким E-mail уже существует';
                            }
                        }
                    }

                    if ( count( $error ) > 0 ) {
                        $error['class'] = 'error';
                        $error_fin = json_encode($error, JSON_UNESCAPED_UNICODE);
                        echo $error_fin;
                    } else {
                        update_user($user_id, $_POST['email'], $_POST['first_name'], $_POST['roles_mask']);
                        $error['class'] = 'success';
                        $error['text'] = 'Сохранено';
                        $error_fin = json_encode($error, JSON_UNESCAPED_UNICODE);
                        echo $error_fin;
                    }
                }
            }
        }
    }

    public function editUserMeta()
    {
        $allPost = Request::allPost();
        $userId = userId();
        $meta = [];
        $meta['phone'] = $allPost['phone'];
        $meta['description'] = $allPost['description'];
        UsersModel::updateUserSettings(
            [
                'id'  => $userId,
                'first_name'     => $allPost['first_name'],
                'last_name'     => $allPost['last_name']
            ]
        );
        $meta_id = UsersModel::setUserMeta(
            [
                'user_id'  => $userId,
                'meta'     => json_encode($meta, JSON_UNESCAPED_UNICODE),
                'meta2'     => json_encode($meta, JSON_UNESCAPED_UNICODE)
            ]
        );
        $ret = ['post' => $allPost, 'meta_id' => $meta_id];
        echo json_encode($ret, true);
    }

    public function editUserPass()
    {
        $allPost = Request::allPost();
        $userId = userId();
        $error = [];
        $error['message'] = [];
        if (!$allPost['password_old']) {
            $error['type'] = 'error';
            $error['message'][] = 'Не указан старый пароль';
        }
        if (!$allPost['password_new']) {
            $error['type'] = 'error';
            $error['message'][] = 'Не указан новый пароль';
        } else {
            if ($allPost['password_new'] != $allPost['password_re']) {
                $error['type'] = 'error';
                $error['message'][] = 'Пароли не совпадают';
            }
        }
        if (!$allPost['password_re']) {
            $error['type'] = 'error';
            $error['message'][] = 'Не указан повтор нового пароля';
        } else {
            if ($allPost['password_new'] != $allPost['password_re']) {
                $error['type'] = 'error';
                $error['message'][] = 'Пароли не совпадают';
            }
        }

        if (count($error['message'])) {
            echo json_encode($error, true);
        } else {
            // $error['type'] = 'success';
            $error = UsersModel::updateUserPass($allPost['user_id'], $allPost['password_new']);
            echo json_encode($error, true);
        }
    }

    public function adminEditUserPass()
    {
        $allPost = Request::allPost();
        $error = UsersModel::updateUserPassAdmin($allPost['user_id'], $allPost['password_new']);
        echo json_encode($error, true);
    }
}
