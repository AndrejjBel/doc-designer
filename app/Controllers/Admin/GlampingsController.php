<?php

namespace App\Controllers\Admin;

use Hleb\Static\Request;
use Hleb\Base\Controller;
use Hleb\Constructor\Data\View;
use App\Models\{
    PostModel,
    GlampingModel,
    LocationModel
};
use App\Content\ArrayPaginator;

class GlampingsController extends Controller
{
    public function index(): View
    {
        $post_limit = LIMIT_POSTS_ADMIN;
        $postCount = GlampingModel::getPostsCount();
        $pagesCount = ceil($postCount/$post_limit);
        $cur_page = Request::get('page')->asInt();
        if (!$cur_page) {
            $cur_page = 1;
        }
        $glampings = GlampingModel::getPosts($cur_page, $post_limit, 'id', 'DESC', '');
        $locations = LocationModel::getLocationsIst();
        return view('/admin/index',
            [
                'data'  => [
                    'temp' => 'glampings',
                    'title' => 'Admin glampings',
                    'description' => 'Admin glampings description',
                    'mod' => 'admin',
                    'glampings' => $glampings,
                    'locations' => $locations,
                    'pagesCount' => $pagesCount,
                    'cur_page' => $cur_page
                ]
            ]
        );
    }

    public function dashboard(): View
    {
        $post_limit = LIMIT_POSTS_ADMIN;
        $postCount = GlampingModel::getPostsCount();
        $pagesCount = ceil($postCount/$post_limit);
        $cur_page = Request::get('page')->asInt();
        if (!$cur_page) {
            $cur_page = 1;
        }
        $userId = userId();
        $glampings = GlampingModel::getPosts($cur_page, $post_limit, 'id', 'DESC', '');
        return view('/admin/index',
            [
                'data'  => [
                    'temp' => 'glampings',
                    'title' => 'Dashboard glampings',
                    'description' => 'Dashboard glampings description',
                    'mod' => 'dashboard',
                    'glampings' => $glampings,
                    'pagesCount' => $pagesCount,
                    'cur_page' => $cur_page
                ]
            ]
        );
    }
}
