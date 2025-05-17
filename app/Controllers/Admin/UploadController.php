<?php

namespace App\Controllers\Admin;

use Hleb\Static\Request;
use Hleb\Base\Controller;
use App\Content\Upload\Upload;
use App\Models\{
    FileModel,
    PostModel,
    GlampingModel,
    LocationModel
};

class UploadController extends Controller
{
    public function uploadFiles()
    {
        $allPost = Request::allPost();
        $userId = userId();

        $message = [];
        $message['error'] = [];

        $uploadSubdir = date('Y') . '/' . date('m');
        $dir = 'public/uploads/' . $uploadSubdir . '/';
        $dir_dest = HLEB_GLOBAL_DIR . '/public/uploads/' . $uploadSubdir . '/';

        if ($allPost['loadingType'] == 'one') {
            $handle = new Upload($_FILES[$allPost['action']], 'ru_RU');
            if ($handle->uploaded) {
                $handle->allowed   = array('jpeg', 'jpg', 'jpe', 'png', 'webp');
                $handle->file_new_name_body   = translit_file($handle->file_src_name_body);
                $handle->image_convert        = 'webp';
                $handle->webp_quality         = 80;

                $handle->process($dir_dest);
                $f = $handle->file_dst_name;
                if ($handle->processed) {
                    $handle->allowed   = array('jpeg', 'jpg', 'jpe', 'png', 'webp');
                    $handle->file_new_name_body   = $handle->file_src_name_body;
                    $handle->process($dir_dest);
                    $fw = $handle->file_dst_name;

                    // $files_arr = $dir.$fw . ',' . $dir.$f;

                    $files_arr = [
                        'g' => $dir.$fw,
                        'w' => $dir.$f
                    ];

                    $last_file_id = FileModel::set(
                        [
                            'file_path'            => $handle->file_dst_pathname,
                            'file_url'             => $dir.$handle->file_dst_name,
                            'file_files'           => json_encode($files_arr, JSON_UNESCAPED_UNICODE),
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
                        'file_name' => $handle->file_dst_name,
                        'f' => $f,
                        'fw' => $fw
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
                $handle = new Upload($file, 'ru_RU');

                if ($handle->uploaded) {
                    $handle->allowed   = array('jpeg', 'jpg', 'jpe', 'png', 'webp');
                    $handle->file_new_name_body   = translit_file($handle->file_src_name_body);
                    $handle->image_convert        = 'webp';
                    $handle->webp_quality         = 80;

                    $handle->process($dir_dest);
                    $f = $handle->file_dst_name;
                    if ($handle->processed) {
                        $handle->allowed   = array('jpeg', 'jpg', 'jpe', 'png', 'webp');
                        $handle->file_new_name_body   = $handle->file_src_name_body;
                        $handle->process($dir_dest);
                        $fw = $handle->file_dst_name;

                        $files_arr = [
                            'g' => $dir.$fw,
                            'w' => $dir.$f
                        ];
                        $last_file_id = FileModel::set(
                            [
                                'file_path'            => $handle->file_dst_pathname,
                                'file_url'             => $dir.$handle->file_dst_name,
                                'file_files'           => json_encode($files_arr, JSON_UNESCAPED_UNICODE),
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
            echo $message_fin;
        }
    }

    public function deleteFiles()
    {
        $message = [];
        $allPost = Request::allPost();
        if ($allPost['action'] == 'delete_files') {
            $file_obj = json_decode($allPost['file'], true);
            if ((int)$file_obj['file_id'] != 0) {
                $file = FileModel::getFile($file_obj['file_id']);
                $files = $file['file_files'];

                if ($files) {
                    $files_arr = json_decode($files, true);
                    foreach ($files_arr as $key => $value) {
                        unlink(HLEB_GLOBAL_DIR . '/' . $value);
                    }
                }

                FileModel::delete($file_obj['file_id']);
            }

            if ($allPost['post_type'] == 'glampings') {
                if ($file_obj['file_position'] == 'thumbnail') {
                    if (isset($allPost['thumbnail'])) {
                        $files_thumbnail = $allPost['thumbnail'];
                    } else {
                        $files_thumbnail = NULL;
                    }
                    GlampingModel::editThumb(
                        [
                            'id'                    => $allPost['post_id'],
                            'post_thumb_img'        => NULL
                        ]
                    );
                } elseif ($file_obj['file_position'] == 'gallery') {
                    if (isset($allPost['imagesItems'])) {
                        $gallery = json_decode($allPost['imagesItems'], true);
                        $fg = [];
                        foreach ($gallery as $img) {
                            if ($img['id'] != 0) {
                                $fg[] = FileModel::getFileNew($img['id']);
                            } else {
                                $fg[] = $img;
                            }
                        }
                        $fgf = [];
                        foreach ($fg as $g) {
                            if ($g['id'] != 0) {
                                $fgf[] = [
                                    'id' => $g['id'],
                                    'link' => json_decode($g['file_files'], true)
                                ];
                            } else {
                                $fgf[] = [
                                    'id' => $g['id'],
                                    'link' => ['g' => $g['link']]
                                ];
                            }
                        }
                        $galleryItems = json_encode($fgf);
                    } else {
                        $galleryItems = NULL;
                    }
                    GlampingModel::editGallery(
                        [
                            'id'                    => $allPost['post_id'],
                            'post_gallery_img'      => $galleryItems
                        ]
                    );
                } elseif ($file_obj['file_position'] == 'acc-gallery') {
                    $post_meta_acc_key = [
                        'acc_type_vision',
                        'acc_type_title',
                        'acc_type_text',
                        'acc_type_area',
                        'acc_type_places',
                        'acc_type_price',
                        'acc_options_home',
                        'acc_options_bathroom',
                        'acc_options_children',
                        'acc_pets',
                        'acc_internet',
                        'acc_nutrition',
                        'acc_bedroom',
                        'acc_spa',
                        // 'acc_imagesItems'
                    ];

                    $post_meta_acc_obj = [];
                    foreach ($allPost as $key => $value) {
                        if (in_array($key, $post_meta_acc_key)) {
                            $post_meta_acc_obj[$key] = $value;
                        }
                    }

                    if ($allPost['acc_imagesItems']) {
                        $acc_gallery = json_decode($allPost['acc_imagesItems'], true);
                        $ag = [];
                        foreach ($acc_gallery as $key => $gallery) {
                            $fg = [];
                            foreach ($gallery as $img) {
                                if ($img['id'] != 0) {
                                    $fg[] = FileModel::getFileNew($img['id']);
                                } else {
                                    $fg[] = $img;
                                }
                            }
                            $fgf = [];
                            foreach ($fg as $g) {
                                if ($g['id'] != 0) {
                                    $fgf[] = [
                                        'id' => $g['id'],
                                        'link' => json_decode($g['file_files'], true)
                                    ];
                                } else {
                                    $fgf[] = [
                                        'id' => $g['id'],
                                        'link' => ['g' => $g['link']]
                                    ];
                                }
                            }
                            $ag[$key] = $fgf;
                        }
                        $acc_galleryItems = json_encode($ag);
                    } else {
                        $acc_galleryItems = NULL;
                    }
                    $post_meta_acc_obj['acc_imagesItems'] = $acc_galleryItems;

                    GlampingModel::editAcc(
                        [
                            'id'                 => $allPost['post_id'],
                            'post_meta_acc'      => json_encode($post_meta_acc_obj, JSON_UNESCAPED_UNICODE)
                        ]
                    );
                }
            }

            if ($allPost['post_type'] == 'reviews') {
                if (isset($allPost['imagesItems'])) {
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
                ReviewsModel::editGallery(
                    [
                        'id'                    => $allPost['post_id'],
                        'post_gallery_img'      => $galleryItems
                    ]
                );
            }

            // if ($allPost['post_type'] == 'location') {}

            if ($allPost['post_type'] == 'posts') {
                if ($file_obj['file_position'] == 'thumbnail') {
                    if (isset($allPost['thumbnail'])) {
                        $files_thumbnail = $allPost['thumbnail'];
                    } else {
                        $files_thumbnail = NULL;
                    }
                    PostModel::editThumb(
                        [
                            'id'                    => $allPost['post_id'],
                            'post_thumb_img'        => $files_thumbnail
                        ]
                    );
                } elseif ($file_obj['file_position'] == 'gallery') {
                    if (isset($allPost['imagesItems'])) {
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
                    PostModel::editGallery(
                        [
                            'id'                    => $allPost['post_id'],
                            'post_gallery_img'      => $galleryItems
                        ]
                    );
                }
            }

            $message['type'] = 'success';
            $message['allPost'] = $allPost;
            // $message['post_meta_acc_obj'] = $post_meta_acc_obj;
            // $message['files_arr'] = $files_arr;
            $message_fin = json_encode($message, JSON_UNESCAPED_UNICODE);
            echo $message_fin;
        }
    }

    public function deleteFilesT()
    {
        $message = [];
        $allPost = Request::allPost();
        $file_obj = json_decode($allPost['file'], true);


        $message['allPost'] = $allPost;
        $message['file_obj'] = $file_obj;
        $message_fin = json_encode($message, JSON_UNESCAPED_UNICODE);
        echo $message_fin;
    }

    public function deleteFiles_def()
    {
        $message = [];
        $allPost = Request::allPost();
        if ($allPost['action'] == 'delete_files') {
            $file = json_decode($allPost['file'], true);
            FileModel::delete($file['file_id']);
            unlink(HLEB_GLOBAL_DIR.$file['file_path']);
            $message['type'] = 'success';
            $message['file'] = $file;
            $message_fin = json_encode($message, JSON_UNESCAPED_UNICODE);
            echo $message_fin;
        }
    }

    public static function uploadFilesLink($link)
    {
        $userId = userId();
        $message = [];
        $message['error'] = [];

        $uploadSubdir = date('Y') . '/' . date('m');
        $dir = 'public/uploads/' . $uploadSubdir . '/';
        $dir_dest = HLEB_GLOBAL_DIR . '/public/uploads/' . $uploadSubdir . '/';

        $handle = new Upload($link, 'ru_RU');
        if ($handle->uploaded) {
            $handle->allowed   = array('jpeg', 'jpg', 'jpe', 'png');
            $handle->file_new_name_body   = translit_file($handle->file_src_name_body);
            $handle->image_convert        = 'webp';
            $handle->webp_quality         = 80;

            $handle->process($dir_dest);
            $f = $handle->file_dst_name;
            if ($handle->processed) {
                $handle->allowed   = array('jpeg', 'jpg', 'jpe', 'png');
                $handle->file_new_name_body   = $handle->file_src_name_body;
                $handle->process($dir_dest);
                $fw = $handle->file_dst_name;

                // $files_arr = $dir.$fw . ',' . $dir.$f;

                $files_arr = [
                    'g' => $dir.$fw,
                    'w' => $dir.$f
                ];

                $last_file_id = FileModel::set(
                    [
                        'file_path'            => $handle->file_dst_pathname,
                        'file_url'             => $dir.$handle->file_dst_name,
                        'file_files'           => json_encode($files_arr, JSON_UNESCAPED_UNICODE),
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
                    'file_name' => $handle->file_dst_name,
                    'f' => $f,
                    'fw' => $fw,
                    'file_files' => $files_arr,
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
        return $message_fin;
    }
}
