<?php

namespace App\Middlewares\Auth;

use Hleb\Base\Middleware;
use App\Models\{Admin\AdminModel};
use Hleb\Reference\RedirectInterface;

class AuthMiddleware extends Middleware
{
    public function index()
    {
        $is_logged = AdminModel::is_logged();
        if ($is_logged) {
            // $this->container->redirect()->to('/');
            hl_redirect('/');
        }
    }
}
