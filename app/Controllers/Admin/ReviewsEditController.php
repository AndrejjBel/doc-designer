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
    Admin\AdminUsersModel,
    FileModel,
    PostModel,
    ReviewsModel,
    GlampingModel
};

class ReviewsEditController extends Controller
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

        if ( count( $message['error'] ) > 0 ) {
            $message['type'] = 'error';
            $message['allPost'] = $allPost;
            $error = json_encode($message, JSON_UNESCAPED_UNICODE);
            echo $error;
        } else {
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

            $post_meta_obj = [];

            $post_parent = (isset($allPost['post_parent']))? $allPost['post_parent'] : '';
            $glamping = GlampingModel::getPostForId($post_parent);
            $user_id = (isset($allPost['post_author']))? $allPost['post_author'] : $userId;

            $post_status = (isset($allPost['post_status']))? $allPost['post_status'] : '';
            if ($allPost['mod'] == 'dashboard') {
                $post_status = 'pending';
                $review = ReviewsModel::getPostForId((int)$allPost['post_id']);
                $glamping = GlampingModel::getPostForId((int)$review['post_parent']);
                $post_parent = $review['post_parent'];
                $user_id = $review['post_author'];
            }


            $user = AdminUsersModel::getUserForId($user_id);

            $post_title = $user['username'] . ' - ' . '(#' . $glamping['id'] . ')' . $glamping['post_title'];

            ReviewsModel::edit(
                [
                    'id'                    => $allPost['post_id'],
                    'post_parent'           => $post_parent,
                    'post_title'            => $post_title,
                    'post_content'          => $post_content,
                    'post_status'           => $post_status,
                    'post_author'           => $user_id,
                    'post_gallery_img'      => $galleryItems,
                    'post_meta'             => NULL,
                    'post_rating'           => $allPost['post_rating']
                ]
            );

            $message['allPost'] = $allPost;
            $message['user_id'] = $user_id;

            $message['type'] = 'success';
            $message['success']['text'] = 'Изменено';
            $message_fin = json_encode($message, JSON_UNESCAPED_UNICODE);
            echo $message_fin;
        }
    }
}
