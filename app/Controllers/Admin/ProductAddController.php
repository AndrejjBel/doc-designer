<?php

namespace App\Controllers\Admin;

use Hleb\Static\Request;
use Hleb\Base\Controller;
use Hleb\Constructor\Data\View;
use Hleb\Static\Redirect;
use App\Models\Myorm\MyormModel;
use App\Content\UploadImage;
use App\Models\{FileModel, PostModel};

class ProductAddController extends Controller
{
    public function index(): View
    {
        return view('/admin/index',
            [
                'data'  => [
                    'temp' => 'product-add',
                    'title' => 'Admin product add',
                    'description' => 'Admin product add description',
                    'mod' => 'admin'
                ]
            ]
        );
    }

    public function dashboard(): View
    {
        return view('/admin/index',
            [
                'data'  => [
                    'temp' => 'product-add',
                    'title' => 'Dashboard product add',
                    'description' => 'Dashboard product add description',
                    'mod' => 'dashboard'
                ]
            ]
        );
    }

    public function addProduct()
    {
        $message = [];
        $message['error'] = [];
        $userId = userId();
        $allPost = Request::allPost();
        $data = [];

        if ($userId == 0) {
            $message['error']['user'] = 'no';
        }

        if (!$allPost['post_title']) {
            $message['error']['post_title'] = 'Заполните поле Заголовок';
        }

        if ( count( $message['error'] ) > 0 ) {
            $message['type'] = 'error';
            $error = json_encode($message, JSON_UNESCAPED_UNICODE);
            echo $error;
        } else {
            $files_thumbnail = $allPost['thumbnail'];

            if ($allPost['imagesItems']) {
                $gallery = json_decode($allPost['imagesItems'], true);
                $galleryItems = json_encode($gallery);
            } else {
                $galleryItems = NULL;
            }

            $post_slug_abs = translit_friendly_url($allPost['post_title']);
            $is_post_slug = unicValue('posts', 'post_slug', $post_slug_abs);
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

            $pContent = htmlspecialchars_decode($allPost['editor_html']);
            $pContent = strip_tags($pContent);
            $pContent = str_replace("&nbsp;", '', $pContent);
            if ($pContent) {
                $post_content = htmlspecialchars_decode($allPost['editor_html']);
            } else {
                $post_content = '';
            }

            $last_post_id = PostModel::create(
                [
                    'post_title'            => $allPost['post_title'],
                    'post_slug'             => $post_slug,
                    'post_url'              => '/' . $allPost['post_type'] . '/' . $post_slug,
                    'post_type'             => $allPost['post_type'],
                    'post_status'           => $allPost['post_status'],
                    'post_author_id'        => $userId,
                    'post_content'          => $post_content,
                    'post_term'             => $allPost['post_term'],
                    'post_tags'             => $allPost['tags'] ?? '',
                    'post_thumb_img'        => $files_thumbnail,
                    'post_gallery_img'      => $galleryItems,
                    'post_price'            => $allPost['post_price'] ?? NULL,
                    'shop_id'               => $allPost['shop_id'] ?? NULL,
                    'post_meta_title'       => $allPost['post_meta_title'] ?? NULL,
                    'post_meta_description' => $allPost['post_meta_description'] ?? NULL,
                    'post_meta_keywords'    => $allPost['post_meta_keywords'] ?? NULL
                ]
            );

            $message['type'] = 'success';
            $message['success']['text'] = 'Опубликовано';
            $message_fin = json_encode($message, JSON_UNESCAPED_UNICODE);
            echo $message_fin;
        }
    }
}
