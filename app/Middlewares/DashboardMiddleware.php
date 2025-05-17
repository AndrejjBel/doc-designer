<?php

namespace App\Middlewares;

use Hleb\Base\Middleware;
use Hleb\Reference\RedirectInterface;
use Hleb\Static\Redirect;
use App\Models\{
    Admin\AdminModel
};

class DashboardMiddleware extends Middleware
{
    public function index()
    {
        if (! AdminModel::is_logged()) { // is_logged is_admin_allowed
            Redirect::to('/');
        }
    }
}
