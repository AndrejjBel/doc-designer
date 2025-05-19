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
    PostModel,
    GlampingModel,
    LocationModel
};

class GlampingAddController extends Controller
{
    public function index(): View
    {
        $locations = LocationModel::getLocations();
        return view('/admin/index',
            [
                'data'  => [
                    'temp' => 'glamping-add',
                    'title' => 'Admin glamping add',
                    'description' => 'Admin glamping add description',
                    'mod' => 'admin',
                    'br' => 'Консоль',
                    'locations' => $locations
                ]
            ]
        );
    }

    public function dashboard(): View
    {
        return view('/admin/index',
            [
                'data'  => [
                    'temp' => 'glamping-add',
                    'title' => 'Dashboard glamping add',
                    'description' => 'Dashboard glamping add description',
                    'mod' => 'dashboard',
                    'br' => 'Личный кабинет'
                ]
            ]
        );
    }

    public function addGlamping()
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
            if (in_array('working_hours', $allPost)) {
                $message['working_hours'] = $allPost['working_hours'];
            } else {
                $message['working_hours'] = 'No working_hours';
            }
            $error = json_encode($message, JSON_UNESCAPED_UNICODE);
            echo $error;
        } else {
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

            $post_slug_abs = translit_friendly_url($allPost['post_title']);
            $is_post_slug = unicValue('glampings', 'post_slug', $post_slug_abs);
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
                $post_content = str_replace("&nbsp;", ' ', $post_content);
            } else {
                $post_content = '';
            }

            $post_meta_key = [
                'glamping_allocation',
                'number_nights',
                'capacity',
                'checkin_glamping',
                'checkout_glamping',
                'email_glamping',
                'phone_glamping',
                'site_glamping',
                'affiliate_link',
                'glc_notes',
                'address',
                'coordinates',
                'glamping_nature_around',
                'options_home',
                'options_bathroom',
                'options_children',
                'pets',
                'internet',
                'parking',
                'nutrition',
                'bedroom',
                'territory',
                'spa',
                'entertainment',
                'additional_features'
            ];

            $post_meta = '';
            $post_meta_obj = [];
            foreach ($allPost as $key => $value) {
                if (in_array($key, $post_meta_key)) {
                    $post_meta_obj[$key] = $value;
                }
            }

            $post_meta_acc = '';
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
                'acc_imagesItems'
            ];

            $post_meta_acc_obj = [];
            foreach ($allPost as $key => $value) {
                if (in_array($key, $post_meta_acc_key)) {
                    $post_meta_acc_obj[$key] = $value;
                }
            }

            $post_seo = [
                'title' => $allPost['post_meta_title'],
                'description' => $allPost['post_meta_description'],
                'keywords' => $allPost['post_meta_keywords']
            ];

            $post_status = $allPost['post_status'];
            if (! AdminModel::is_admin_allowed()) {
                $post_status = 'pending';
            }

            // $post_term = LocationModel::getLocationForSlug($allPost['post_term'])[0];

            $last_post_id = GlampingModel::create(
                [
                    'post_title'            => $allPost['post_title'],
                    'post_content'          => $post_content,
                    'post_slug'             => $post_slug,
                    'post_url'              => '/glampings/' . $post_slug,
                    'post_status'           => $post_status,
                    'post_author'           => $userId,
                    'post_term'             => $allPost['post_term'],
                    'post_tags'             => $allPost['tags'] ?? '',
                    'post_thumb_img'        => $thumbnail,
                    'post_gallery_img'      => $galleryItems,
                    'post_price'            => $allPost['post_price'] ?? NULL,
                    'post_working'          => (in_array('working_hours', $allPost))? json_encode($allPost['working_hours'], JSON_UNESCAPED_UNICODE) : NULL,
                    'post_seo'              => json_encode($post_seo, JSON_UNESCAPED_UNICODE),
                    'post_meta'             => json_encode($post_meta_obj, JSON_UNESCAPED_UNICODE),
                    'post_meta_acc'         => json_encode($post_meta_acc_obj, JSON_UNESCAPED_UNICODE)
                ]
            );

            locationsCount();

            $message['type'] = 'success';
            $message['success']['text'] = 'Опубликовано';
            $message_fin = json_encode($message, JSON_UNESCAPED_UNICODE);
            echo $message_fin;
        }
    }
}
