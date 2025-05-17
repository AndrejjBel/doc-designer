<?php

namespace App\Controllers\Auth;

use Hleb\Base\Controller;
use Hleb\Constructor\Data\View;
use App\Models\Myorm\MyormModel;
use Hleb\Static\Redirect;

class VerifyController extends Controller
{
    public function index(): View
    {
        $options = [
            'data'  => [
                'temp' => 'generale',
                'title' => 'Verify',
                'description' => 'Verify description',
                'mod' => 'auth',
                'body_classes' => 'authentication-bg'
            ]
        ];
        if (isset($_GET)) {
    		if (isset($_GET['type'])) {
                if ($_GET['type'] == 'email_reg') {
                    $db = MyormModel::dbc();
                    $auth = new \Delight\Auth\Auth($db);
                    try {
                        $auth->confirmEmail($_GET['selector'], $_GET['token']);
                        // echo 'Email address has been verified';
                        $options['data']['success'] = 'Адрес электронной почты подтвержден';
                        return view('/auth/verify', $options);
                    }
                    catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
                        // die('Invalid token');
                        $options['data']['error'] = 'Ошибка';
                        $options['data']['error_type'] = 'Недействительный токен';
                        return view('/auth/verify', $options);
                    }
                    catch (\Delight\Auth\TokenExpiredException $e) {
                        // die('Token expired');
                        $options['data']['error'] = 'Ошибка';
                        $options['data']['error_type'] = 'Срок действия токена истек';
                        return view('/auth/verify', $options);
                    }
                    catch (\Delight\Auth\UserAlreadyExistsException $e) {
                        // die('Email address already exists');
                        $options['data']['error'] = 'Ошибка';
                        $options['data']['error_type'] = 'Адрес электронной почты уже существует';
                        return view('/auth/verify', $options);
                    }
                    catch (\Delight\Auth\TooManyRequestsException $e) {
                        // die('Too many requests');
                        $options['data']['error'] = 'Ошибка';
                        $options['data']['error_type'] = 'Слишком много запросов';
                        return view('/auth/verify', $options);
                    }
                } elseif ($_GET['type'] == 'forgot_password') {
                    $db = MyormModel::dbc();
                    $auth = new \Delight\Auth\Auth($db);
                    if ($auth->canResetPassword($_GET['selector'], $_GET['token'])) {
                        $options_pass = [
                            'data'  => [
                                'temp' => 'generale',
                                'title' => 'Reset password',
                                'description' => 'Reset password description',
                                'mod' => 'auth',
                                'success' => 'new_password',
                                'body_classes' => 'authentication-bg'
                            ]
                        ];
                        return view('/auth/forgot-password', $options_pass);

                        // $options['success'] = 'new_password';
                        // return view('/auth/verify', $options);
                    } else {
                        // $options_pass = [
                        //     'title' => 'Reset password',
                        //     'description' => 'Reset password description',
                        //     'mod' => 'auth',
                        //     'success' => 'Ошибка'
                        // ];
                        // return view('/auth/forgot-password', $options_pass);

                        $options['data']['error'] = 'Ошибка';
                        return view('/auth/verify', $options);
                    }
                }
            } else {
                $options['data']['error'] = 'Ошибка';
                return view('/auth/verify', $options);
            }
        } else {
            $options['data']['error'] = 'Ошибка';
            return view('/auth/verify', $options);
        }
    }
}
