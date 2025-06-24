<?php

namespace App\Controllers\Admin;

use Hleb\Static\Request;
use Hleb\Static\Cookies;
use Hleb\Base\Controller;
use Hleb\Constructor\Data\View;
use App\Models\{
    PagesModel,
    ProductsModel,
    VarsModel
};
use App\Content\ArrayPaginator;

class PagesController extends Controller
{
    public function index(): View
    {
        $cookie = Cookies::get('docDesPage')->value();
        $site_settings = SITE_SETTINGS;
        $post_limit = $site_settings->post_limit_admin;
        if ($cookie) {
            if ((int)json_decode($cookie)->chapter !=0) {
                $postCount = ProductsModel::getProductsGroupAbs((int)json_decode($cookie)->chapter);
                $pagesCount = ceil($postCount/$post_limit);
                $cur_page = Request::get('page')->asInt();
                if (!$cur_page) {
                    $cur_page = 1;
                }
                $products_list = ProductsModel::getProductsPageGroup($cur_page, $post_limit, 'id', 'DESC', (int)json_decode($cookie)->chapter);
            } elseif ((int)json_decode($cookie)->group && (int)json_decode($cookie)->chapter == 0) {
                $parents = ProductsModel::getProductsGroupParent([
                    'parentid' => (int)json_decode($cookie)->group
                ]);
                $parentids = [];
                foreach ($parents as $key => $parent) {
                    $parentids[] = $parent['id'];
                }
                $postCount = ProductsModel::getProductsGroupAbs(implode(', ', $parentids));
                $pagesCount = ceil($postCount/$post_limit);
                $cur_page = Request::get('page')->asInt();
                if (!$cur_page) {
                    $cur_page = 1;
                }
                $products_list = ProductsModel::getProductsPageGroup($cur_page, $post_limit, 'id', 'DESC', implode(', ', $parentids));
            } else {
                $postCount = ProductsModel::getProductsAbs();
                $pagesCount = ceil($postCount/$post_limit);
                $cur_page = Request::get('page')->asInt();
                if (!$cur_page) {
                    $cur_page = 1;
                }
                $products_list = ProductsModel::getProductsPage($cur_page, $post_limit, 'id', 'DESC', '');
            }
        } else {
            $postCount = PagesModel::getPagesAbs();
            $pagesCount = ceil($postCount/$post_limit);
            $cur_page = Request::get('page')->asInt();
            if (!$cur_page) {
                $cur_page = 1;
            }
            $pages_list = PagesModel::getPagesPage($cur_page, $post_limit, 'id', 'DESC', '');
        }
        return view('/admin/index',
            [
                'data'  => [
                    'temp' => 'pages',
                    'title' => 'Admin pages',
                    'description' => 'Admin pages description',
                    'mod' => 'admin',
                    'pages_list' => $pages_list,
                    'post_limit' => $post_limit,
                    'postCount' => $postCount,
                    'pagesCount' => $pagesCount,
                    'cur_page' => $cur_page,
                    'site_settings' => $site_settings,
                    'cookie' => $cookie
                    // 'cookie' => json_decode($cookie)
                ]
            ]
        );
    }

    public function page_edit(): View
    {
        $id = Request::get('id')->asInt();
        $page = PagesModel::getPageForId($id);
        $product = ProductsModel::getProductForId($page['product_id']);

        $userId = userId();
        return view('/admin/index',
            [
                'data'  => [
                    'temp' => 'page-edit',
                    'title' => 'Page edit',
                    'description' => 'Page edit description',
                    'mod' => 'admin',
                    'userId' => $userId,
                    'page_id' => $id,
                    'page' => $page,
                    'product' => $product
                ]
            ]
        );
    }

    public function page_add(): View
    {
        $duplicate = Request::get('duplicate')->asInt();
        $userId = userId();
        $vars = VarsModel::getVarsAll();

        if ($duplicate) {
            $page = PagesModel::getPageForId($duplicate);

            return view('/admin/index',
                [
                    'data'  => [
                        'temp' => 'page-add',
                        'title' => 'Page add',
                        'description' => 'Page add description',
                        'mod' => 'admin',
                        'userId' => $userId,
                        'vars' => $vars,
                        'duplicate' => $duplicate,
                        'page' => $page
                    ]
                ]
            );
        } else {
            return view('/admin/index',
                [
                    'data'  => [
                        'temp' => 'page-add',
                        'title' => 'Page add',
                        'description' => 'Page add description',
                        'mod' => 'admin',
                        'userId' => $userId,
                        'vars' => $vars,
                        'duplicate' => $duplicate
                    ]
                ]
            );
        }
    }
}
