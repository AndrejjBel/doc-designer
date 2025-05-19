<?php

namespace App\Controllers\Auth;

use Hleb\Base\Controller;
use Hleb\Constructor\Data\View;
use App\Models\Myorm\MyormModel;
use Hleb\Static\Redirect;

class AuthController extends Controller
{
    public function index() //: void
    {
        if (isset($_POST)) {
    		if (isset($_POST['actions'])) {
                $db = MyormModel::dbc();
                $auth = new \Delight\Auth\Auth($db);
    			if ($_POST['actions'] === 'login') {
    				if ($_POST['remember'] == 1) {
    					// keep logged in for one year
    					$rememberDuration = (int) (60 * 60 * 24 * 365.25);
    				}
    				else {
    					// do not keep logged in after session ends
    					$rememberDuration = null;
    				}
    				try {
                        if (filter_var($_POST['login'], FILTER_VALIDATE_EMAIL)) {
                            $auth->login($_POST['login'], $_POST['password'], $rememberDuration);
                        } else {
                            $auth->loginWithUsername($_POST['login'], $_POST['password'], $rememberDuration);
                        }
                        Redirect::to('/');
    				}
    				catch (\Delight\Auth\InvalidEmailException $e) {
                        Redirect::to('/login?error=error');
                        // Redirect::to('/login?error=wrong_email');
    				}
    				catch (\Delight\Auth\UnknownUsernameException $e) {
                        Redirect::to('/login?error=error');
                        // Redirect::to('/login?error=unknown_username');
    				}
    				catch (\Delight\Auth\AmbiguousUsernameException $e) {
                        Redirect::to('/login?error=error');
    				}
    				catch (\Delight\Auth\InvalidPasswordException $e) {
                        Redirect::to('/login?error=error');
    				}
    				catch (\Delight\Auth\EmailNotVerifiedException $e) {
                        Redirect::to('/login?error=email_noverifi');
    				}
    			}
            }
        }
    }
}
