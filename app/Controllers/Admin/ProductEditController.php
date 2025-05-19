<?php

namespace App\Controllers\Admin;

use Hleb\Static\Request;
use Hleb\Base\Controller;
use Hleb\Constructor\Data\View;
use Hleb\Static\Redirect;
use App\Models\Myorm\MyormModel;
use App\Content\UploadImage;
use App\Content\Upload\Upload;
use App\Models\{FileModel, PostModel};

class ProductEditController extends Controller
{
    public function index(): View
    {
        $post_id = Request::get('id')->asPositiveInt();
        $post_data = PostModel::getPostForId($post_id);
        return view('/admin/index',
            [
                'data'  => [
                    'temp' => 'product-edit',
                    'title' => 'Admin product edit',
                    'description' => 'Admin product edit description',
                    'mod' => 'admin',
                    'post_data' => $post_data
                ]
            ]
        );
    }

    public function dashboard(): View
    {
        $post_id = Request::get('id')->asPositiveInt();
        $post_data = PostModel::getPostForId($post_id);
        return view('/admin/index',
            [
                'data'  => [
                    'temp' => 'product-edit',
                    'title' => 'AdDashboardmin product edit',
                    'description' => 'Dashboard product edit description',
                    'mod' => 'dashboard',
                    'post_data' => $post_data
                ]
            ]
        );
    }

    public function editProduct()
    {
        $allPost = Request::allPost();
        $post_data = PostModel::getPostForId($allPost['post_id']);
        $message = [];
        $message['error'] = [];
        $userId = userId();
        $data = [];

        if ($allPost['thumbnail']) {
            $thumbnail = json_decode($allPost['thumbnail'], true);
            if (count($thumbnail)) {
                $files_thumbnail = json_encode($thumbnail);
            } else {
                $files_thumbnail = NULL;
            }
        } else {
            $files_thumbnail = NULL;
        }

        $pContent = htmlspecialchars_decode($allPost['editor_html']);
        $pContent = strip_tags($pContent);
        $pContent = str_replace("&nbsp;", '', $pContent);
        if ($pContent) {
            $post_content = htmlspecialchars_decode($allPost['editor_html']);
        } else {
            $post_content = '';
        }

        if ($allPost['imagesItems']) {
            $gallery = json_decode($allPost['imagesItems'], true);
            if (count($gallery)) {
                $galleryItems = json_encode($gallery);
            } else {
                $galleryItems = NULL;
            }
        } else {
            $galleryItems = NULL;
        }

        $last_post_id = PostModel::edit(
            [
                'post_id'               => $allPost['post_id'],
                'post_title'            => $allPost['post_title'],
                'post_status'           => $allPost['post_status'],
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

        if ($files_thumbnail) {
            $fileThumb = json_decode($files_thumbnail, true);
            $file_id = $fileThumb[0]['id'];
            FileModel::edit($file_id, 'permanent');
        }

        if ($gallery) {
            foreach ($gallery as $key => $value) {
                $file_id = $value['id'];
                FileModel::edit($file_id, 'permanent');
            }
        }

        $message['type'] = 'success';
        $message['success']['text'] = 'Обновлено успешно';
        $message['allPost'] = $allPost;
        $message_fin = json_encode($message, JSON_UNESCAPED_UNICODE);
        echo $message_fin;
    }
}
