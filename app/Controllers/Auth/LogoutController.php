<?php

namespace App\Controllers\Auth;

use Hleb\Base\Controller;
use Hleb\Constructor\Data\View;
use App\Models\Myorm\MyormModel;
use Hleb\Static\Redirect;

class LogoutController extends Controller
{
    public function index() //: void
    {
        if (isset($_POST)) {
    		if (isset($_POST['actions'])) {
                $db = MyormModel::dbc();
                $auth = new \Delight\Auth\Auth($db);
    			if ($_POST['actions'] == 'logOut') {
                    $auth->logOut();
                    $auth->destroySession();
                    Redirect::to('/');
    			}
            }
        }
    }
}
