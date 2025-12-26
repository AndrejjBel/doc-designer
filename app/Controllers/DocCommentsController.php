<?php

namespace App\Controllers;

use Hleb\Static\Request;
use Hleb\Base\Controller;
use Hleb\Constructor\Data\View;
use App\Content\Upload\Upload;
use App\Models\{
    DocCommentsModel,
    User\UsersModel
};

class DocCommentsController extends Controller
{
    public function index()
    {
        $allPost = Request::allPost();
        if ($allPost['action'] == 'doc_lawyer_upload') {
            $this->doc_lawyer_upload($allPost);
        }
        if ($allPost['action'] == 'doc_comment_create') {
            $this->doc_comment_create($allPost);
        }
        if ($allPost['action'] == 'doc_comment_views_update') {
            $this->doc_comment_views_update($allPost);
        }
    }

    public function doc_lawyer_upload($allPost)
    {
        $message = [];
        $user = UsersModel::getUser();
        $uploadSubdir = date('m-Y');
        $dir = '/public/upload/' . $uploadSubdir . '/';
        $dir_dest = HLEB_GLOBAL_DIR . '/public/upload/' . $uploadSubdir . '/';

        $handle = new Upload($_FILES['comment_file']);
        if ($handle->uploaded) {
            $handle->file_new_name_body = translit_file($handle->file_src_name_body);

            $handle->process($dir_dest);
            if ($handle->processed) {
                $last_comment_id = DocCommentsModel::create([
                    'doc_order_id'      => $allPost['doc_order'],
                    'author'      => $user['id'],
                    'content'     => nl2br($allPost['comment']),
                    'type'        => 'doc_upload',
                    'parent'      => 0,
                    'attachments' => $dir.$handle->file_dst_name,
                    'views'        => $user['id']
                ]);

                $message['file'] = [
                    'comment_id' => $last_comment_id,
                    'link' => $dir.$handle->file_dst_name,
                    'file_path' => $handle->file_dst_pathname,
                    'file_name' => $handle->file_dst_name
                ];
                $message['type'] = 'success';
            } else {
                $message['type'] = 'error';
                $message['error'] = $handle->error;
            }
        } else {
            $message['type'] = 'error';
            $message['error'] = $handle->error;
        }
        echo json_encode($message, JSON_UNESCAPED_UNICODE);
    }

    public function doc_comment_create($allPost)
    {
        $message = [];
        $attachments = '';
        $user = UsersModel::getUser();
        $uploadSubdir = date('m-Y');
        $dir = '/public/upload/' . $uploadSubdir . '/';
        $dir_dest = HLEB_GLOBAL_DIR . '/public/upload/' . $uploadSubdir . '/';

        $handle = new Upload($_FILES['message_file']);
        $message['handle'] = $handle->uploaded;
        if ($handle->uploaded) {
            $handle->file_new_name_body = translit_file($handle->file_src_name_body);

            $handle->process($dir_dest);
            if ($handle->processed) {
                $message['file'] = [
                    'link' => $dir.$handle->file_dst_name,
                    'file_path' => $handle->file_dst_pathname,
                    'file_name' => $handle->file_dst_name
                ];
                $attachments = $dir.$handle->file_dst_name;
            } else {
                $message['type_file'] = 'error';
                $message['file_error'] = $handle->error;
            }
        }

        $last_comment_id = DocCommentsModel::create([
            'doc_order_id' => $allPost['doc_order'],
            'author'       => $user['id'],
            'content'      => nl2br($allPost['message']),
            'type'         => 'comments',
            'parent'       => 0,
            'attachments'  => $attachments,
            'views'        => $user['id']
        ]);

        if ($last_comment_id) {
            $message['type'] = 'success';
            $message['message'] = $last_comment_id;
        } else {
            $message['type'] = 'error';
            $message['message'] = $last_comment_id;
        }

        echo json_encode($message, JSON_UNESCAPED_UNICODE);
    }

    public function doc_comment_views_update($allPost)
    {
        $message = [];
        $user = UsersModel::getUser();
        $comment_id = explode('-', $allPost['comment_id'])[1];
        $comment = DocCommentsModel::getCommentOrder($comment_id);
        $views_ids = explode(',', $comment['views']);
        array_walk($views_ids, function(&$elem) {
            $elem = (int)$elem;
        });
        if (!in_array($user['id'], $views_ids)) {
            array_push($views_ids, $user['id']);

            DocCommentsModel::editViewsStatus([
                'comment_id' => $comment_id,
                'views'      => implode(',', $views_ids)
            ]);

            $message['type'] = 'success';
            $message['text'] = 'Отмечено просмотренным';
            $message['views_ids'] = $views_ids;
        } else {
            $message['type'] = 'warning';
            $message['text'] = 'Уже просмотрено';
            $message['views_ids'] = $views_ids;
        }
        echo json_encode($message, JSON_UNESCAPED_UNICODE);
    }
}
