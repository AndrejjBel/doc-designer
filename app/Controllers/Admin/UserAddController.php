<?php

namespace App\Controllers\Admin;

use Hleb\Base\Controller;
use Hleb\Constructor\Data\View;
use App\Models\Myorm\MyormModel;
use Hleb\Static\Redirect;

class UserAddController extends Controller
{
    public function index(): View
    {
        return view('/admin/index',
            [
                'data'  => [
                    'temp' => 'user-add',
                    'title' => 'Admin user add',
                    'description' => 'Admin user add description',
                    'mod' => 'admin'
                ]
            ]
        );
    }

    public function addUser()
    {
        $error = [];
        $error['inputs'] = [];
        if ( !$_POST['name'] ) {
            array_push($error['inputs'], 'name');
        }

        if ( !$_POST['email'] ) {
            array_push($error['inputs'], 'email');
        }

        if ( count( $error['inputs'] ) > 0 ) {
            $error['class'] = 'error';
            $error['text'] = 'Заполните все обязательные поля';
            $error_fin = json_encode($error, JSON_UNESCAPED_UNICODE);
            echo $error_fin;
        } else {
            if (!check($_POST['name'])) {
                $error['class'] = 'error';
                $error['text'] = 'Логин может состоять из латинских букв и цифр, символов "_" и "-", начало и окончание буква';
                $error_fin = json_encode($error, JSON_UNESCAPED_UNICODE);
                echo $error_fin;
            } else {
                // $username = translit_sef($_POST['name']);
                $pass = $_POST['password'];
                if (!$_POST['password']) {
                    $pass = gen_password(8);
                }
                try {
                    $db = MyormModel::dbc();
                    $auth = new \Delight\Auth\Auth($db);
                    // $userId = $auth->admin()->createUser($_POST['email'], $pass, $username);
                    $userId = $auth->admin()->createUserWithUniqueUsername($_POST['email'], $pass, $_POST['name']);

                    update_user_reg_admin($userId, '', $_POST['role']);

                    if (isset($_POST['send_email'])) {
                        $to  = $_POST['email'];
                        $subject = "Регистрация на сайте";
                        $message = '<p>Вы зарегистрированы на сайте: </p>' . "\r\n";
                        $message .= '<p>Для авторизации используйте: </p>' . "\r\n";
                        $message .= '<p>Логин: </p>' . "\r\n";
                        $message .= $username . ' или ' . $_POST['email'] . "\r\n";
                        $message .= '<p>Пароль: </p>' . "\r\n";
                        $message .= $pass . "\r\n";
                        $headers  = 'MIME-Version: 1.0' . "\r\n";
                        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                        $headers .= 'To: <' . $to . '>' . "\r\n";
                        $headers .= 'From: do.developer-creatsites.h1n.ru <admin@do.developer-creatsites.h1n.ru>' . "\r\n";
                        $headers .= 'Cc: admin@do.developer-creatsites.h1n.ru' . "\r\n";
                        $headers .= 'Bcc: admin@do.developer-creatsites.h1n.ru' . "\r\n";
                        mail($to, $subject, $message, $headers);
                    }

                    $error['class'] = 'success';
                    $error['post'] = $_POST;
                    $error['userId'] = $userId;
                    $error['text'] = 'Пользователь успешно добавлен';
                    $error_fin = json_encode($error, JSON_UNESCAPED_UNICODE);
                    echo $error_fin;
                }
                catch (\Delight\Auth\InvalidEmailException $e) {
                    // die('Invalid email address');
                    $error['class'] = 'error';
                    $error['post'] = $_POST;
                    $error['text'] = 'Неверный адрес электронной почты';
                    $error_fin = json_encode($error, JSON_UNESCAPED_UNICODE);
                    echo $error_fin;
                }
                catch (\Delight\Auth\InvalidPasswordException $e) {
                    // die('Invalid password');
                    $error['class'] = 'error';
                    $error['post'] = $_POST;
                    $error['text'] = 'Неверный пароль';
                    $error_fin = json_encode($error, JSON_UNESCAPED_UNICODE);
                    echo $error_fin;
                }
                catch (\Delight\Auth\UserAlreadyExistsException $e) {
                    // die('User already exists');
                    $error['class'] = 'error';
                    $error['post'] = $_POST;
                    $error['text'] = 'Пользователь с таким E-mail уже существует';
                    $error_fin = json_encode($error, JSON_UNESCAPED_UNICODE);
                    echo $error_fin;
                }
                catch (\Delight\Auth\DuplicateUsernameException $e) {
                    $error['class'] = 'error';
                    $error['post'] = $_POST;
                    $error['text'] = 'Пользователь с таким Логином уже существует';
                    $error_fin = json_encode($error, JSON_UNESCAPED_UNICODE);
                    echo $error_fin;
                }
            }
        }
    }
}
