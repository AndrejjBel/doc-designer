<?php

namespace App\Controllers\Auth;

use Hleb\Base\Controller;
use Hleb\Constructor\Data\View;
use App\Models\Myorm\MyormModel;
use Hleb\Static\Redirect;

class RegController extends Controller
{
    public function index() //: void
    {
        if (isset($_POST)) {
    		if (isset($_POST['actions'])) {
                $db = MyormModel::dbc();
                $auth = new \Delight\Auth\Auth($db);
    			if ($_POST['actions'] === 'signin') {
                    $selector = \Delight\Auth\Auth::createRandomString();
                    $token = \Delight\Auth\Auth::createUuid();
                    // $username = translit_sef($_POST['username']);

                    if (!isset($_POST['pryvasi'])) {
                        Redirect::to('/signin?error=pryvasi');
                    }

                    if (!check($_POST['username'])) {
                        Redirect::to('/signin?error=username_novalid');
                    } else {
                        try {
                            $userId = $auth->registerWithUniqueUsername($_POST['email'], $_POST['password'], $_POST['username'], function ($selector, $token) {
                                $to  = $_POST['email'];
                                $subject = "Регистрация на сайте";
                                $url = 'https://do.developer-creatsites.h1n.ru/verify?type=email_reg&selector=' . \urlencode($selector) . '&token=' . \urlencode($token);

                                $message = '<p>Для подтвеждения E-mail перейдите по ссылке: </p>' . "\r\n";
                                $message .= $url;

                                $headers  = 'MIME-Version: 1.0' . "\r\n";
                                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                                $headers .= 'To: <' . $to . '>' . "\r\n";
                                $headers .= 'From: do.developer-creatsites.h1n.ru <admin@do.developer-creatsites.h1n.ru>' . "\r\n";
                                $headers .= 'Cc: admin@do.developer-creatsites.h1n.ru' . "\r\n";
                                $headers .= 'Bcc: admin@do.developer-creatsites.h1n.ru' . "\r\n";

                                mail($to, $subject, $message, $headers);
                            });

                            update_user_role($user_id);

                            Redirect::to('/verify?email=' . $_POST['email']);
                        }
                        catch (\Delight\Auth\InvalidEmailException $e) {
                            // die('Invalid email address');
                            Redirect::to('/signin?error=email');
                        }
                        catch (\Delight\Auth\InvalidPasswordException $e) {
                            // die('Invalid password');
                            Redirect::to('/signin?error=password');
                        }
                        catch (\Delight\Auth\UserAlreadyExistsException $e) {
                            // die('User already exists');
                            Redirect::to('/signin?error=email_exists');
                        }
                        catch (\Delight\Auth\TooManyRequestsException $e) {
                            // die('Too many requests');
                            Redirect::to('/signin?error=many_requests');
                        }
                        catch (\Delight\Auth\DuplicateUsernameException $e) {
                            // die('Too many requests');
                            Redirect::to('/signin?error=username_exists');
                        }
                    }
    			}
            }
        }
    }
}
