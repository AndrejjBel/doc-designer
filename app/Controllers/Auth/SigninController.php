<?php

namespace App\Controllers\Auth;

use Hleb\Base\Controller;
use Hleb\Constructor\Data\View;

class SigninController extends Controller
{
    public function index(): View
    {
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
    }
}
