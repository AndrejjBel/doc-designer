<?php

namespace App\Middlewares\Admin;

use Hleb\Base\Middleware;
use Hleb\Reference\RedirectInterface;
use Hleb\Static\Redirect;
use App\Models\{
    Admin\AdminModel
};

class AdminMiddleware extends Middleware
{
    public function index()
    {
        if (! AdminModel::is_admin_allowed()) { // is_logged is_admin_allowed
            Redirect::to('/');
        }
    }
}
