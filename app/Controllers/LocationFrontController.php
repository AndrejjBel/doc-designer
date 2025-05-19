<?php

namespace App\Controllers;

use Hleb\Base\Controller;
use Hleb\Constructor\Data\View;
use Hleb\Static\Request;
use App\Models\{
    GlampingModel,
    LocationModel
};
use App\Content\{
    Breadcrumb,
    Paginator
};

class LocationFrontController extends Controller
{
    public function index(): View
    {
        $post_limit = LIMIT_POSTS_FRONT;
        $postCount = LocationModel::getLocationsCount();
        $pagesCount = ceil($postCount/$post_limit);
        $cur_page = Request::param('page')->asPositiveInt();
        if (!$cur_page) {
            $cur_page = 1;
            Breadcrumb::add('/location/', 'Регионы', 0);
        } else {
            Breadcrumb::add('/location/', 'Регионы');
            Breadcrumb::add('/location/page/' . $cur_page . '/', 'Страница ' . $cur_page, 0);
        }
        $locations = LocationModel::getLocationsPageFront($cur_page, $post_limit, 'title', 'ASC');
        $breadcrumbs = Breadcrumb::out();

        $totalItems = $postCount;
        $itemsPerPage = $post_limit;
        $currentPage = $cur_page;
        $urlPattern = '/location/page/(:num)/';
        $urlGen = '/location/';
        $paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern, $urlGen);
        $paginator->setMaxPagesToShow(5);

        $locations_json = LocationModel::getLocationsFront();

        $scriptJson = json_encode($locations_json, JSON_UNESCAPED_UNICODE);

        return view('locations',
            [
                'data'  => [
                    'body_classes' => 'home',
                    'temp_header' => 'header-pages',
                    'title' => 'Каталог регионов',
                    'description' => '',
                    'mod' => 'locations',
                    'locations' => $locations,
                    'post_limit' => $post_limit,
                    'postsCount' => $postCount,
                    'pagesCount' => $pagesCount,
                    'cur_page' => $cur_page,
                    'breadcrumbs' => $breadcrumbs,
                    'paginator' => $paginator,
                    'scriptJson' => $scriptJson
                ]
            ]
        );
    }

    public function location_item(): View
    {
        $cur_page = Request::param('page')->asPositiveInt();
        $loc_slug = Request::param('slug')->asString();
        $locations_arr = LocationModel::getLocationForSlug($loc_slug);

        $post_limit = LIMIT_POSTS_FRONT;
        $postCount = GlampingModel::getPostsCountLocation($loc_slug);
        $pagesCount = ceil($postCount/$post_limit);
        if (!$cur_page) {
            $cur_page = 1;
            Breadcrumb::add('/glampings/', 'Глэмпинги');
            Breadcrumb::add('/location/' . $loc_slug . '/', $locations_arr[0]['title'], 0);
        } else {
            Breadcrumb::add('/glampings/', 'Глэмпинги');
            Breadcrumb::add('/location/' . $loc_slug . '/', $locations_arr[0]['title']);
            Breadcrumb::add('/location/' . $loc_slug . '/' . $cur_page . '/', 'Страница ' . $cur_page, 0);
        }
        $breadcrumbs = Breadcrumb::out();

        $glampings = GlampingModel::getPostsLocation($cur_page, $post_limit, 'post_date', 'DESC', $loc_slug);

        $totalItems = $postCount;
        $itemsPerPage = $post_limit;
        $currentPage = $cur_page;
        $urlPattern = '/location/' . $loc_slug . '/page/(:num)/';
        $urlGen = '/location/' . $loc_slug . '/';
        $paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern, $urlGen);
        $paginator->setMaxPagesToShow(5);
        return view('location',
            [
                'data'  => [
                    'body_classes' => 'home',
                    'temp_header' => 'header-pages',
                    'title' => $locations_arr[0]['title'],
                    'description' => '',
                    'mod' => 'location',
                    'glampings' => $glampings,
                    'post_limit' => $post_limit,
                    'postsCount' => $postCount,
                    'pagesCount' => $pagesCount,
                    'cur_page' => $cur_page,
                    'breadcrumbs' => $breadcrumbs,
                    'paginator' => $paginator
                ]
            ]
        );
    }
}
