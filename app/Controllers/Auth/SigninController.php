<?php

namespace App\Controllers\Auth;

use Hleb\Base\Controller;
use Hleb\Constructor\Data\View;
use App\Controllers\HomeController;

class SigninController extends Controller
{
    public function index(): View
    {
        $site_settings = json_decode(site_settings('site_settings'));
        if (isset($site_settings->signin_vision)) {
            return view('/auth/signin',
                [
                    'data'  => [
                        'temp' => 'generale',
                        'title' => 'Signin',
                        'description' => 'Signin description',
                        'mod' => 'auth',
                        'body_classes' => 'authentication-bg'
                    ]
                ]
            );
        } else {
            return (new HomeController())->index();
        }
    }
}
