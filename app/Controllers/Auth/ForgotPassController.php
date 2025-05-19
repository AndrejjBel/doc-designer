<?php

namespace App\Controllers\Auth;

use Hleb\Base\Controller;
use Hleb\Constructor\Data\View;
use App\Models\Myorm\MyormModel;
use Hleb\Static\Redirect;

class ForgotPassController extends Controller
{
    public function showPasswordForm(): View
    {
        $options = [
            'data'  => [
                'title' => 'Reset password',
                'description' => 'Reset password description',
                'mod' => 'auth',
                'body_classes' => 'authentication-bg'
            ]
        ];
        return view('/auth/forgot-password', $options);
    }

    public function showRemindForm()
    {}

    public function passReset()
    {
        $options = [
            'data'  => [
                'title' => 'Reset password',
                'description' => 'Reset password description',
                'mod' => 'auth',
                'body_classes' => 'authentication-bg'
            ]
        ];

        if (isset($_POST)) {
    		if (isset($_POST['actions'])) {
                $db = MyormModel::dbc();
                $auth = new \Delight\Auth\Auth($db);
    			if ($_POST['actions'] == 'forgot_password') {
                    $selector = \Delight\Auth\Auth::createRandomString();
                    $token = \Delight\Auth\Auth::createUuid();
                    try {
                        $auth->forgotPassword($_POST['email'], function ($selector, $token) {
                            $to  = $_POST['email'];
                            $subject = "Восстановление пароля";
                            $url = 'https://do.developer-creatsites.h1n.ru/verify?type=forgot_password&selector=' . \urlencode($selector) . '&token=' . \urlencode($token);

                            $message = ' <p>Для подтвеждения E-mail перейдите по ссылке: </p>' . "\r\n";
                            $message .= $url;

                            $headers  = 'MIME-Version: 1.0' . "\r\n";
                            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                            $headers .= 'To: <' . $to . '>' . "\r\n";
                            $headers .= 'From: do.developer-creatsites.h1n.ru <admin@do.developer-creatsites.h1n.ru>' . "\r\n";
                            $headers .= 'Cc: admin@do.developer-creatsites.h1n.ru' . "\r\n";
                            $headers .= 'Bcc: admin@do.developer-creatsites.h1n.ru' . "\r\n";

                            mail($to, $subject, $message, $headers);
                        });

                        // echo 'Request has been generated';
                        $options['data']['success'] = 'На '. $_POST['email'] . ' отправлена инструкция.';
                        return view('/auth/forgot-password', $options);
                    }
                    catch (\Delight\Auth\InvalidEmailException $e) {
                        // die('Invalid email address');
                        $options['data']['error'] = 'Ошибка';
                        $options['data']['error_type'] = 'Invalid email address';
                        return view('/auth/forgot-password', $options);
                    }
                    catch (\Delight\Auth\EmailNotVerifiedException $e) {
                        // die('Email not verified');
                        $options['data']['error'] = 'Ошибка';
                        $options['data']['error_type'] = 'Email not verified';
                        return view('/auth/forgot-password', $options);
                    }
                    catch (\Delight\Auth\ResetDisabledException $e) {
                        // die('Password reset is disabled');
                        $options['data']['error'] = 'Ошибка';
                        $options['data']['error_type'] = 'Password reset is disabled';
                        return view('/auth/forgot-password', $options);
                    }
                    catch (\Delight\Auth\TooManyRequestsException $e) {
                        // die('Too many requests');
                        $options['data']['error'] = 'Ошибка';
                        $options['data']['error_type'] = 'Too many requests';
                        return view('/auth/forgot-password', $options);
                    }
    			} elseif ($_POST['actions'] == 'reset_password') {
                    if ($_POST['new_password'] == $_POST['new_password_again']) {
                        try {
                            $auth->resetPassword($_POST['selector'], $_POST['token'], $_POST['new_password']);

                            // $options['data']['success'] = 'password_changed';
                            // return view('/auth/forgot-password', $options);

                            Redirect::to('/login?pass=yes');
                        }
                        catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
                            die('Invalid token');
                            $options['data']['success'] = 'Too many requests';
                            return view('/auth/forgot-password', $options);
                        }
                        catch (\Delight\Auth\TokenExpiredException $e) {
                            // die('Token expired');
                            $options['data']['success'] = 'Token expired';
                            return view('/auth/forgot-password', $options);
                        }
                        catch (\Delight\Auth\ResetDisabledException $e) {
                            // die('Password reset is disabled');
                            $options['data']['success'] = 'Password reset is disabled';
                            return view('/auth/forgot-password', $options);
                        }
                        catch (\Delight\Auth\InvalidPasswordException $e) {
                            // die('Invalid password');
                            $options['data']['success'] = 'Invalid password';
                            return view('/auth/forgot-password', $options);
                        }
                        catch (\Delight\Auth\TooManyRequestsException $e) {
                            // die('Too many requests');
                            $options['data']['success'] = 'Too many requests';
                            return view('/auth/forgot-password', $options);
                        }
                    } else {
                        $options['data']['success'] = 'new_password';
                        $options['data']['selector'] = $_POST['selector'];
                        $options['data']['token'] = $_POST['token'];
                        $options['data']['warning'] = 'Пароли не совпадают';
                        return view('/auth/forgot-password', $options);
                    }
                }
            }
        }
    }
}
