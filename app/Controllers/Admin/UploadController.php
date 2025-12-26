<?php

namespace App\Controllers\Admin;

use Hleb\Static\Request;
use Hleb\Base\Controller;
use App\Content\Upload\Upload;
use App\Models\{
    FileModel,
    OrdersModel
};
use App\Controllers\MailSmtpNew;

class UploadController extends Controller
{
    public function uploadFiles()
    {
        $allPost = Request::allPost();
        $userId = userId();

        $message = [];
        $message['error'] = [];

        $uploadSubdir = date('m-Y');
        $dir = '/public/upload-new/' . $uploadSubdir . '/';
        $dir_dest = HLEB_GLOBAL_DIR . '/public/upload-new/' . $uploadSubdir . '/';

        if ($allPost['loadingType'] == 'one') {
            $handle = new Upload($_FILES[$allPost['action']]);
            if ($handle->uploaded) {
                $handle->file_new_name_body   = translit_file($handle->file_src_name_body);

                $handle->process($dir_dest);
                if ($handle->processed) {
                    $last_file_id = FileModel::set(
                        [
                            'file_path'            => $handle->file_dst_pathname,
                            'file_url'             => $dir.$handle->file_dst_name,
                            'file_type'            => 'temporary',
                            'file_mime_type'       => $handle->file_src_mime,
                            'file_post_id'         => 0,
                            'file_author_id'       => $userId
                        ]
                    );
                    $message['file'] = [
                        'id' => $last_file_id,
                        'link' => $dir.$handle->file_dst_name,
                        'file_path' => $handle->file_dst_pathname,
                        'file_name' => $handle->file_dst_name
                    ];
                    $message['type'] = 'success';
                    $message_fin = json_encode($message, JSON_UNESCAPED_UNICODE);
                } else {
                    $message['error'] = $handle->error;
                    $message_fin = json_encode($message, JSON_UNESCAPED_UNICODE);
                }
                $handle-> clean();

            } else {
                $message['error'] = $handle->error;
                $message_fin = json_encode($message, JSON_UNESCAPED_UNICODE);
            }
            // $message['post'] = $allPost;
            // $message_fin = json_encode($message, JSON_UNESCAPED_UNICODE);
            // return $message_fin;
            echo $message_fin;
        } elseif ($allPost['loadingType'] == 'multi') {
            $files = array();
            foreach ($_FILES[$allPost['action']] as $k => $l) {
                foreach ($l as $i => $v) {
                    if (!array_key_exists($i, $files))
                    $files[$i] = array();
                    $files[$i][$k] = $v;
                }
            }

            foreach ($files as $file) {
                $handle = new Upload($file);

                if ($handle->uploaded) {
                    $handle->file_new_name_body   = translit_file($handle->file_src_name_body);
                    // $handle->file_name_body_pre = 'tmp_';

                    $handle->process($dir_dest);
                    if ($handle->processed) {
                        $last_file_id = FileModel::set(
                            [
                                'file_path'            => $handle->file_dst_pathname,
                                'file_url'             => $dir.$handle->file_dst_name,
                                'file_type'            => 'temporary',
                                'file_mime_type'       => $handle->file_src_mime,
                                'file_post_id'         => 0,
                                'file_author_id'       => $userId
                            ]
                        );
                        $message['files'][] = [
                            'id' => $last_file_id,
                            'link' => $dir.$handle->file_dst_name,
                            'file_path' => $handle->file_dst_pathname,
                            'file_name' => $handle->file_dst_name
                        ];
                        $message['type'] = 'success';
                    } else {
                        $message['error'] = $handle->error;
                    }

                } else {
                    $message['error'] = $handle->error;
                }
            }

            $message['post'] = $allPost;
            $message_fin = json_encode($message, JSON_UNESCAPED_UNICODE);
            // return $message_fin;
            echo $message_fin;
        }
    }

    public function uploadDocs()
    {
        $allPost = Request::allPost();
        $userId = userId();

        $message = [];
        $message['error'] = [];

        $uploadSubdir = date('m-Y');
        $dir = '/public/upload/' . $uploadSubdir . '/';
        $dir_dest = HLEB_GLOBAL_DIR . '/public/upload/' . $uploadSubdir . '/';

        $handle = new Upload($_FILES[$allPost['action']]);
        if ($handle->uploaded) {
            $handle->file_new_name_body = translit_file($handle->file_src_name_body);

            $handle->process($dir_dest);
            if ($handle->processed) {
                OrdersModel::orderDocUrlEdit($allPost['order_id'], $dir.$handle->file_dst_name);
                $order = OrdersModel::getOrder($allPost['order_id']);
                $clientmeta = json_decode($order['clientmeta']);

                // $home_url = config('main', 'home_url');
                // $to = $clientmeta->email;
                // $site_name = 'Конструктор документов';
                // $subject = 'Регистрация на сайте';
                //
                // $body = '';
                // $body .= '<p><strong>Вы зарегистрированы на сайте: ' . $site_name . '</strong></p>';
                // $body .= '<p>Для авторизации используйте: </p>';
                // $body .= '<p>Логин: </p>';
                // $body .= $username . ' или ' . $allPost['user_email'];
                // $body .= '<p>Пароль: ' . $password . '</p>';
                // $body .= '<p><strong>Отправлено с сайта <a href="' . $home_url . '">' . $site_name . '</a></strong></p>';
                //
                // $resultMail = MailSmtpNew::send($site_name, $subject, $body, $to);

                $message['file'] = [
                    'order_id' => $allPost['order_id'],
                    'link' => $dir.$handle->file_dst_name,
                    'file_path' => $handle->file_dst_pathname,
                    'file_name' => $handle->file_dst_name
                ];
                $message['type'] = 'success';
                $message_fin = json_encode($message, JSON_UNESCAPED_UNICODE);
            } else {
                $message['error'] = $handle->error;
                $message_fin = json_encode($message, JSON_UNESCAPED_UNICODE);
            }
            $handle-> clean();

        } else {
            $message['error'] = $handle->error;
            $message_fin = json_encode($message, JSON_UNESCAPED_UNICODE);
        }
        echo $message_fin;
    }

    public function deleteFiles()
    {
        $message = [];
        $allPost = Request::allPost();
        if ($allPost['action'] == 'delete_files') {
            $file = json_decode($allPost['file'], true);
            FileModel::delete($file['file_id']);
            unlink(HLEB_GLOBAL_DIR.$file['file_path']);

            $message['type'] = 'success';
            // $message['allPost'] = $allPost;
            $message['file'] = $file;
            $message_fin = json_encode($message, JSON_UNESCAPED_UNICODE);
            echo $message_fin;

            // $files = $allPost['files'];
            // foreach ($files as $file) {
            //     FileModel::delete($file['file_id']);
            //     unlink($file['file_path']);
            // }
        }
    }
}
