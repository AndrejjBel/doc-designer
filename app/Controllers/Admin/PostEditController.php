<?php

namespace App\Controllers\Admin;

use Hleb\Static\Request;
use Hleb\Base\Controller;
use Hleb\Constructor\Data\View;
use Hleb\Static\Redirect;
use App\Models\Myorm\MyormModel;
use App\Content\UploadImage;
use App\Models\{
    Admin\AdminModel,
    FileModel,
    PostModel
};

class PostEditController extends Controller
{
    public function editPost()
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
            $message['allPost'] = $allPost;
            $error = json_encode($message, JSON_UNESCAPED_UNICODE);
            echo $error;
        } else {
            // $files_thumbnail = $allPost['thumbnail'];

            $files_thumbnail = json_decode($allPost['thumbnail'], true);
            if (count($files_thumbnail)) {
                $files = $files_thumbnail[0];
                $file_thumb = FileModel::getFile($files['id']);
                if ($file_thumb) {
                    $thumb = [
                        'id' => $file_thumb['id'],
                        'link' => json_decode($file_thumb['file_files'], true)
                    ];
                    $thumbnail = json_encode($thumb, JSON_UNESCAPED_UNICODE);
                } else {
                    $thumbnail = NULL;
                }
            } else {
                $thumbnail = NULL;
            }

            if ($allPost['imagesItems']) {
                $gallery = json_decode($allPost['imagesItems'], true);
                $fg = [];
                foreach ($gallery as $img) {
                    $fg[] = FileModel::getFileNew($img['id']);
                }
                $fgf = [];
                foreach ($fg as $g) {
                    $fgf[] = [
                        'id' => $g['id'],
                        'link' => json_decode($g['file_files'], true)
                    ];
                }
                $galleryItems = json_encode($fgf);
            } else {
                $galleryItems = NULL;
            }

            $pContent = htmlspecialchars_decode($allPost['editor_html']);
            $pContent = strip_tags($pContent);
            $pContent = str_replace("&nbsp;", '', $pContent);
            if ($pContent) {
                $post_content = htmlspecialchars_decode($allPost['editor_html']);
                $post_content = str_replace("&nbsp;", ' ', $post_content);
            } else {
                $post_content = '';
            }

            $post_seo = [
                'title' => $allPost['post_meta_title'],
                'description' => $allPost['post_meta_description'],
                'keywords' => $allPost['post_meta_keywords']
            ];

            $post_meta_obj = [];

            $post_status = (isset($allPost['post_status']))? $allPost['post_status'] : 'pending';
            if (! AdminModel::is_admin_allowed()) {
                $post_status = 'pending';
            }

            $cur_date = date('Y-m-d H:i:s');

            $last_post_id = PostModel::edit(
                [
                    'id'                    => $allPost['post_id'],
                    'post_title'            => $allPost['post_title'],
                    'post_content'          => $post_content,
                    'post_status'           => $post_status,
                    'post_term'             => $allPost['post_term'],
                    'post_tags'             => $allPost['tags'] ?? '',
                    'post_thumb_img'        => $thumbnail,
                    'post_gallery_img'      => $galleryItems,
                    'post_seo'              => json_encode($post_seo, JSON_UNESCAPED_UNICODE),
                    'post_meta'             => json_encode($post_meta_obj, JSON_UNESCAPED_UNICODE),
                    'post_modified'         => $cur_date
                ]
            );

            $message['fg'] = $fg;

            $message['type'] = 'success';
            $message['allPost'] = $allPost;
            $message['success']['text'] = 'Опубликовано';
            $message_fin = json_encode($message, JSON_UNESCAPED_UNICODE);
            echo $message_fin;
        }
    }
}
