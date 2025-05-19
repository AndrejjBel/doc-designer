<?php

namespace App\Controllers\Auth;

use Hleb\Base\Controller;
use Hleb\Constructor\Data\View;

class LoginController extends Controller
{
    public function index(): View
    {
        return view('/auth/login',
            [
                'data'  => [
                    'temp' => 'generale',
                    'title' => 'Login',
                    'description' => 'Login description',
                    'mod' => 'auth',
                    'body_classes' => 'authentication-bg position-relative'
                ]
            ]
        );
    }
}
