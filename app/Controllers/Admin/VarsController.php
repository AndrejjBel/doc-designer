<?php

namespace App\Controllers\Admin;

use Hleb\Static\Request;
use Hleb\Base\Controller;
use Hleb\Constructor\Data\View;
use App\Models\{
    VarsModel
};
use App\Content\ArrayPaginator;

class VarsController extends Controller
{
    public function index(): View
    {
        // $post_limit = LIMIT_POSTS_ADMIN;
        // $postCount = GlampingModel::getPostsCount();
        // $pagesCount = ceil($postCount/$post_limit);
        // $cur_page = Request::get('page')->asInt();
        // if (!$cur_page) {
        //     $cur_page = 1;
        // }
        // $glampings = GlampingModel::getPosts($cur_page, $post_limit, 'id', 'DESC', '');
        // $locations = LocationModel::getLocationsIst();
        // return view('/admin/index',
        //     [
        //         'data'  => [
        //             'temp' => 'glampings',
        //             'title' => 'Admin glampings',
        //             'description' => 'Admin glampings description',
        //             'mod' => 'admin',
        //             'glampings' => $glampings,
        //             'locations' => $locations,
        //             'pagesCount' => $pagesCount,
        //             'cur_page' => $cur_page
        //         ]
        //     ]
        // );
    }

    public function vars_item(): View
    {
        $var_id = Request::param('id')->asPositiveInt();
        $vars_parent = VarsModel::getVarsParentSections($var_id);

        $userId = userId();
        return view('/admin/index',
            [
                'data'  => [
                    'temp' => 'var-section',
                    'title' => 'Var',
                    'description' => 'Var description',
                    'mod' => 'admin',
                    'userId' => $userId,
                    'var_id' => $var_id,
                    'vars_parent' => $vars_parent
                ]
            ]
        );
    }

    public function vars_group(): View
    {
        $userId = userId();
        $vars = VarsModel::getVarsAll();
        return view('/admin/index',
            [
                'data'  => [
                    'temp' => 'var-group',
                    'title' => 'Var group',
                    'description' => 'Var group description',
                    'mod' => 'admin',
                    'userId' => $userId,
                    'vars' => $vars,
                ]
            ]
        );
    }

    public function vars_add(): View
    {
        $userId = userId();
        $vars = VarsModel::getVarsAll();
        return view('/admin/index',
            [
                'data'  => [
                    'temp' => 'var-add',
                    'title' => 'Var add',
                    'description' => 'Var add description',
                    'mod' => 'admin',
                    'userId' => $userId,
                    'vars' => $vars,
                ]
            ]
        );
    }
}
