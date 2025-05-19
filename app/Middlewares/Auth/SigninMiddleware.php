<?php

namespace App\Middlewares\Auth;

use Hleb\Base\Middleware;
use App\Models\{Admin\AdminModel};
use Hleb\Reference\RedirectInterface;

class SigninMiddleware extends Middleware
{
    public function index()
    {
        $site_settings = json_decode(site_settings('site_settings'));
        $is_logged = AdminModel::is_logged();
        if ($is_logged) {
            hl_redirect('/');
        }
        if (!isset($site_settings->signin_vision)) {
            hl_redirect('/login');
        }
    }
}
