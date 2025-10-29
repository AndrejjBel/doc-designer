<?php

namespace App\Controllers;

use Hleb\Base\Controller;
use Hleb\Constructor\Data\View;

class Sitemap extends Controller
{
    public function index(): View
    {
        // header('Content-Type: application/xml;');
        //
        // insertCacheTemplate(
        //     '/sitemap',
        //     [
        //         'data' => [
        //             'title' => 'Home',
        //             'description' => 'Home description'
        //         ]
        //     ]
        // );
        return view('/sitemap', ['title' => 'Home', 'description' => 'Home description']);
    }
}
