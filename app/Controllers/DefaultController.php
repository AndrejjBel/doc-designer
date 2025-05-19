<?php

namespace App\Controllers;

use Hleb\Base\Controller;
use Hleb\Constructor\Data\View;

class DefaultController extends Controller
{
    public function index(): View
    {
        return view('/admin/admin', ['title' => 'Home', 'description' => 'Home description']);
    }
}
