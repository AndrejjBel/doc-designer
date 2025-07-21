<?php

namespace App\Controllers\Admin;

use Hleb\Static\Request;
use Hleb\Static\Cookies;
use Hleb\Base\Controller;
use Hleb\Constructor\Data\View;
use App\Models\{
    ProductsModel,
    VarsModel
};
use App\Content\ArrayPaginator;

class ProductsController extends Controller
{
    public function index(): View
    {
        $cookie = Cookies::get('docDesProd')->value();
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
            $postCount = ProductsModel::getProductsAbs();
            $pagesCount = ceil($postCount/$post_limit);
            $cur_page = Request::get('page')->asInt();
            if (!$cur_page) {
                $cur_page = 1;
            }
            $products_list = ProductsModel::getProductsPage($cur_page, $post_limit, 'id', 'DESC', '');
        }
        return view('/admin/index',
            [
                'data'  => [
                    'temp' => 'products',
                    'title' => 'Admin products',
                    'description' => 'Admin products description',
                    'mod' => 'admin',
                    'products_list' => $products_list,
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

    public function product_edit(): View
    {
        $id = Request::get('id')->asInt();
        $product = ProductsModel::getProductForId($id);
        $varsProduct = ProductsModel::getVarsForProduct($id);
        $prodSlugNotId = ProductsModel::getProdSlugNotId(['id' => $id]);

        $userId = userId();
        return view('/admin/index',
            [
                'data'  => [
                    'temp' => 'product-edit',
                    'title' => 'Product edit',
                    'description' => 'Product edit description',
                    'mod' => 'admin',
                    'userId' => $userId,
                    'product_id' => $id,
                    'product' => $product,
                    'varsProduct' => $varsProduct,
                    'prodSlugNotId' => $prodSlugNotId
                ]
            ]
        );
    }

    public function product_add(): View
    {
        $duplicate = Request::get('duplicate')->asInt();
        $userId = userId();
        $vars = VarsModel::getVarsAll();

        if ($duplicate) {
            $product = ProductsModel::getProductForId($duplicate);
            $varsProduct = ProductsModel::getVarsForProduct($duplicate);

            return view('/admin/index',
                [
                    'data'  => [
                        'temp' => 'product-add',
                        'title' => 'Product add',
                        'description' => 'Product add description',
                        'mod' => 'admin',
                        'userId' => $userId,
                        'vars' => $vars,
                        'duplicate' => $duplicate,
                        'product' => $product,
                        'varsProduct' => $varsProduct
                    ]
                ]
            );
        } else {
            return view('/admin/index',
                [
                    'data'  => [
                        'temp' => 'product-add',
                        'title' => 'Product add',
                        'description' => 'Product add description',
                        'mod' => 'admin',
                        'userId' => $userId,
                        'vars' => $vars,
                        'duplicate' => $duplicate
                    ]
                ]
            );
        }
    }

    public function products_group(): View
    {
        $products = ProductsModel::getProductsAll();

        $userId = userId();
        return view('/admin/index',
            [
                'data'  => [
                    'temp' => 'products-group',
                    'title' => 'Products group',
                    'description' => 'Products group description',
                    'mod' => 'admin',
                    'products' => $products
                ]
            ]
        );
    }
}
