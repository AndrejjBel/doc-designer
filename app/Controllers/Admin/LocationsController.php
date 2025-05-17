<?php

namespace App\Controllers\Admin;

use Hleb\Static\Request;
use Hleb\Base\Controller;
use Hleb\Constructor\Data\View;
use App\Models\LocationModel;

class LocationsController extends Controller
{
    public function index(): View
    {
        $post_limit = LIMIT_POSTS_ADMIN;
        $postCount = LocationModel::getLocationsCount();
        $pagesCount = ceil($postCount/$post_limit);
        $cur_page = Request::get('page')->asInt();
        if (!$cur_page) {
            $cur_page = 1;
        }
        $locations = LocationModel::getLocationsPage($cur_page, $post_limit, 'title', 'ASC');
        // $locations = LocationModel::getLocations();

        return view('/admin/index',
            [
                'data'  => [
                    'temp' => 'location',
                    'title' => 'Admin locations',
                    'description' => 'Admin locations description',
                    'mod' => 'admin',
                    'locations' => $locations,
                    'pagesCount' => $pagesCount,
                    'cur_page' => $cur_page
                ]
            ]
        );
    }

    public function add_location()
    {
        $message = [];
        $message['error'] = [];

        $allPost = Request::allPost();

        if ($allPost['action'] == 'add') {
            $post_slug_abs = translit_friendly_url($allPost['location_title']);
            $is_post_slug = unicValue('location', 'slug', $post_slug_abs);
            if (count($is_post_slug) == 0) {
                $post_slug = $post_slug_abs;
            } elseif (count($is_post_slug) == 1) {
                $post_slug = $post_slug_abs . '-2';
            } elseif (count($is_post_slug) > 1) {
                $arr = [];
                foreach ($is_post_slug as $key => $value) {
                    if ($value != $post_slug_abs) {
                        $arr[] = (int)str_replace($post_slug_abs . '-', '', $value);
                    }
                }
                $post_slug = $post_slug_abs . '-' . max($arr)+1;
            }

            $img = '';
            $seo = '';

            // $last_post_id = LocationModel::create(
            //     [
            //         'title'           => $allPost['location_title'],
            //         'slug'            => $post_slug,
            //         'description'     => $allPost['location_description'],
            //         'img'             => $allPost['img'],
            //         'seo'             => $seo
            //     ]
            // );

            $message['type'] = 'success';
            $message['success']['text'] = 'Опубликовано';
        } elseif ($allPost['action'] == 'edit') {
            $seo = [
                'title' => $allPost['location_meta_title'],
                'description' => $allPost['location_meta_description'],
                'keywords' => $allPost['location_meta_keywords']
            ];

            LocationModel::edit(
                [
                    'id'              => $allPost['loc_id'],
                    'title'           => $allPost['location_title'],
                    'slug'            => $allPost['location_link'],
                    'description'     => $allPost['location_description'],
                    'img'             => $allPost['img'],
                    'seo'             => json_encode($seo, JSON_UNESCAPED_UNICODE)
                ]
            );

            $message['type'] = 'success';
            $message['success']['text'] = 'Изменено';
        }

        $message['allPost'] = $allPost;
        // $message['post_id'] = $last_post_id;
        $message_fin = json_encode($message, JSON_UNESCAPED_UNICODE);
        echo $message_fin;
    }

    public function edit_location()
    {}
}
