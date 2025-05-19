<?php

namespace App\Controllers;

use Hleb\Base\Controller;
use Hleb\Constructor\Data\View;
use Hleb\Static\Request;
use App\Models\GlampingModel;
use App\Content\{
    Breadcrumb,
    Paginator
};

class GlampingsFrontController extends Controller
{
    public function index(): View
    {
        $post_limit = LIMIT_POSTS_FRONT;
        $postsCount = GlampingModel::getPostsCount();
        $pagesCount = ceil($postsCount/$post_limit);
        $cur_page = Request::param('page')->asPositiveInt();
        if (!$cur_page) {
            $cur_page = 1;
            Breadcrumb::add('/glampings/', 'Глэмпинги', 0);
        } else {
            Breadcrumb::add('/glampings/', 'Глэмпинги');
            Breadcrumb::add('/glampings/page/' . $cur_page . '/', 'Страница ' . $cur_page, 0);
        }
        $glampings = GlampingModel::getPosts($cur_page, $post_limit, 'post_date', 'DESC');
        $breadcrumbs = Breadcrumb::out();

        $totalItems = $postsCount;
        $itemsPerPage = $post_limit;
        $currentPage = $cur_page;
        $urlPattern = '/glampings/page/(:num)/';
        $urlGen = '/glampings/';
        $paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern, $urlGen);
        $paginator->setMaxPagesToShow(5);

        return view('glampings',
            [
                'data'  => [
                    'body_classes' => 'home',
                    'temp_header' => 'header-pages',
                    'title' => 'Глэмпинги',
                    'description' => 'Глэмпинги России, актуальная информация, рейтинг и отзывы',
                    'mod' => 'glampings',
                    'glampings' => $glampings,
                    'post_limit' => $post_limit,
                    'postsCount' => $postsCount,
                    'pagesCount' => $pagesCount,
                    'cur_page' => $cur_page,
                    'breadcrumbs' => $breadcrumbs,
                    'paginator' => $paginator
                ]
            ]
        );
    }
}
