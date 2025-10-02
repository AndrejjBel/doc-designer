<?php

namespace App\Controllers;

use Hleb\Base\Controller;
use Hleb\Constructor\Data\View;
use Hleb\Static\Request;
use App\Models\{
    VarsModel,
    ProductsModel,
    PagesModel,
    OrdersModel
};

class AdminFetchController extends Controller
{
    public function index()
    {
        $allPost = Request::allPost();
        if ($allPost['action'] == 'edit_order_status') {
            $this->edit_order_status($allPost);
        }
        if ($allPost['action'] == 'change_vars') {
            $this->change_vars($allPost);
        }
        if ($allPost['action'] == 'create_vargr') {
            $this->create_vargr($allPost);
        }
        if ($allPost['action'] == 'create_var') {
            $this->create_var($allPost);
        }
        if ($allPost['action'] == 'edit_var') {
            $this->edit_var($allPost);
        }
        if ($allPost['action'] == 'delete_var') {
            $this->delete_var($allPost);
        }
        if ($allPost['action'] == 'productStatusChange') {
            $this->productStatusChange($allPost);
        }
        if ($allPost['action'] == 'filterGroupChange') {
            $this->filterGroupChange($allPost);
        }
        if ($allPost['action'] == 'edit_product') {
            $this->edit_product($allPost);
        }
        if ($allPost['action'] == 'create_group_prod') {
            $this->create_group_prod($allPost);
        }
        if ($allPost['action'] == 'add_product') {
            $this->add_product($allPost);
        }
        if ($allPost['action'] == 'delete_product') {
            $this->delete_product($allPost);
        }
        if ($allPost['action'] == 'deleteProductGroup') {
            $this->deleteProductGroup($allPost);
        }
        if ($allPost['action'] == 'slugUnicAdd') {
            $this->slugUnicAdd($allPost);
        }
        if ($allPost['action'] == 'slugUnicEdit') {
            $this->slugUnicEdit($allPost);
        }

        if ($allPost['action'] == 'add_page') {
            $this->add_page($allPost);
        }
        if ($allPost['action'] == 'edit_page') {
            $this->edit_page($allPost);
        }
        if ($allPost['action'] == 'pageStatusChange') {
            $this->pageStatusChange($allPost);
        }
        if ($allPost['action'] == 'delete_page') {
            $this->delete_page($allPost);
        }
        if ($allPost['action'] == 'block_cont_render') {
            $this->block_cont_render($allPost);
        }
        if ($allPost['action'] == 'ssi_save') {
            $this->ssi_save($allPost);
        }
    }

    public function edit_order_status($allPost)
    {
        $order_status = [];
        $order_status[] = OrdersModel::orderStatusEdit($allPost['id'], $allPost['status']);
        $order_status['type'] = 'success';
        echo json_encode($order_status, JSON_UNESCAPED_UNICODE);
    }

    public function change_vars($allPost)
    {
        $res = [];
        $userRoles = getUserRoles();
        $res['userRoles'] = array_slice($userRoles, 0, 1)[0];
        $id = $allPost['var_id'];
        $res['vars'] = VarsModel::getVarsParent($id);
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
    }

    public function create_vargr($allPost)
    {
        $message = [];

        if ($allPost['parentid'] == 'no') {
            $message['parentid'] = 'Выберите группу';
        }

        if (!$allPost['title']) {
            $message['title'] = 'Заполните имя раздела';
        }

        if ( count( $message ) > 0 ) {
            $message['type'] = 'error';
        } else {
            if (array_key_exists('var_gr_id', $allPost)) {
                $message['var_gr_id'] = $allPost['var_gr_id'];
                if ($allPost['var_gr_id']) {
                    $res = VarsModel::edit_var(
                        [
                            'id'         => $allPost['var_gr_id'],
                            'parentid'   => $allPost['parentid'],
                            'isgr'       => 1,
                            'title'      => trim($allPost['title']),
                            'descr'      => '',
                            'active'     => 1,
                            'type'       => 0,
                            'typedata'   => 0,
                            'captholder' => 0,
                            'exthtml'    => '',
                            'extdata'    => ''
                        ]
                    );
                    $message['type'] = 'success';
                    $message['text'] = 'Раздел изменен';
                } else {
                    $last_post_id = VarsModel::create_var(
                        [
                            'parentid'   => $allPost['parentid'],
                            'isgr'       => 1,
                            'title'      => trim($allPost['title']),
                            'descr'      => '',
                            'active'     => 1,
                            'type'       => 0,
                            'typedata'   => 0,
                            'captholder' => 0,
                            'exthtml'    => '',
                            'extdata'    => ''
                        ]
                    );
                    if ($last_post_id) {
                        $message['type'] = 'success';
                        $message['id'] = $last_post_id;
                        $message['text'] = 'Раздел создан';
                    } else {
                        $message['type'] = 'error';
                    }
                }
            } else {
                $last_post_id = VarsModel::create_var(
                    [
                        'parentid'   => $allPost['parentid'],
                        'isgr'       => 1,
                        'title'      => trim($allPost['title']),
                        'descr'      => '',
                        'active'     => 1,
                        'type'       => 0,
                        'typedata'   => 0,
                        'captholder' => 0,
                        'exthtml'    => '',
                        'extdata'    => ''
                    ]
                );
                if ($last_post_id) {
                    $message['type'] = 'success';
                    $message['id'] = $last_post_id;
                    $message['text'] = 'Раздел создан';
                } else {
                    $message['type'] = 'error';
                }
            }
        }

        $message['post'] = $allPost;

        echo json_encode($message, JSON_UNESCAPED_UNICODE);
    }

    public function create_var($allPost)
    {
        $message = [];

        if (!$allPost['title']) {
            $message['title'] = 'Заполните имя переменной';
        }

        if ( count( $message ) > 0 ) {
            $message['type'] = 'error';
        } else {
            $last_post_id = VarsModel::create_var(
                [
                    'parentid'   => $allPost['parentid'],
                    'isgr'       => 0,
                    'title'      => trim($allPost['title']),
                    'descr'      => $allPost['descr'] ?? '',
                    'active'     => 1,
                    'type'       => $allPost['type'],
                    'typedata'   => $allPost['typedata'],
                    'captholder' => $allPost['captholder'] ?? '',
                    'exthtml'    => $allPost['exthtml'] ?? '',
                    'extdata'    => $allPost['extdata'] ?? ''
                ]
            );
            if ($last_post_id) {
                $message['type'] = 'success';
                $message['id'] = $last_post_id;
            } else {
                $message['type'] = 'error';
            }
        }

        echo json_encode($message, JSON_UNESCAPED_UNICODE);
    }

    public function edit_var($allPost)
    {
        $message = [];

        if (!$allPost['title']) {
            $message['title'] = 'Заполните имя переменной';
        }

        if ( count( $message ) > 0 ) {
            $message['type'] = 'error';
        } else {
            $res = VarsModel::edit_var(
                [
                    'id'         => $allPost['var_id'],
                    'parentid'   => $allPost['parentid'],
                    'isgr'       => 0,
                    'title'      => trim($allPost['title']),
                    'descr'      => $allPost['descr'] ?? '',
                    'active'     => 1,
                    'type'       => $allPost['type'],
                    'typedata'   => $allPost['typedata'],
                    'captholder' => $allPost['captholder'] ?? '',
                    'exthtml'    => $allPost['exthtml'] ?? '',
                    'extdata'    => $allPost['extdata'] ?? ''
                ]
            );
            if ($res) {
                $message['type'] = 'success';
                $message['text'] = 'Изменения сохранены успешно';
            } else {
                $message['type'] = 'error';
                $message['text'] = 'Ошибка, попробуйте позже';
            }
        }

        $message['post'] = $allPost;

        echo json_encode($message, JSON_UNESCAPED_UNICODE);
    }

    public function delete_var($allPost)
    {
        $id = $allPost['var_id'];
        $message = [];
        $fin = [];
        if (array_key_exists('root', $allPost)) {
            $res = [];
            if ($allPost['root'] == 'yes') {
                $vars_parent = VarsModel::getVarsParentIdGr($id);
                foreach ($vars_parent as $value) {
                    $res = array_merge($res, VarsModel::getVarsParentId($value['id']));
                }
                $message['text'] = 'Группа удалена';
            } else if ($allPost['root'] == 'no') {
                $vars_parent = VarsModel::getVarsParentId($id);
                $message['text'] = 'Раздел удален';
            } else {
                $vars_parent = VarsModel::getVarsParentId($id);
            }
            $res = array_merge($res, $vars_parent);
            foreach ($res as $value) {
                $fin[] = $value['id'];
            }
            if (count($fin)) {
                $vp = implode(',', $fin);
                $del_par = VarsModel::delete_var_parent($vp);
            }
            $del_var = VarsModel::delete_var($id);
        } else {
            $del_var = VarsModel::delete_var($id);
            $message['text'] = 'Переменная удалена';
        }
        echo json_encode(['res' => $fin, 'message' => $message, 'post' => $allPost], JSON_UNESCAPED_UNICODE);
    }

    public function productStatusChange($allPost)
    {
        $res = ProductsModel::editStatus([
            'id' => $allPost['product_id'],
            'active' => $allPost['status']
        ]);
        if ($res) {
            $result = 'success';
        } else {
            $result = 'error';
        }
        echo json_encode(['result' => $result], JSON_UNESCAPED_UNICODE);
    }

    public function filterGroupChange($allPost)
    {
        $res = ProductsModel::getProductsGroupParent([
            'parentid' => $allPost['group']
        ]);
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
    }

    public function edit_product($allPost)
    {
        $message = [];
        $error = [];

        if (!$allPost['title']) {
            $message['result'] = 'error';
            $error['type'] = 'title';
            $error['text'] = 'Заполните поле Наименование шаблона';
        }

        if (!$allPost['allsit']) {
            $message['result'] = 'error';
            $error['type'] = 'allsit';
            $error['text'] = 'Заполните поле Постоянная ссылка';
        }

        if (count($error)) {
            $message['result'] = 'error';
        } else {
            $favor = 0;
            $active = 0;
            if (array_key_exists('favor', $allPost)) {
                $favor = 1;
            }
            if (array_key_exists('active', $allPost)) {
                $active = 1;
            }

            $pContent = htmlspecialchars_decode($allPost['descr']);
            $pContent = strip_tags($pContent);
            $pContent = str_replace("&nbsp;", '', $pContent);
            if ($pContent) {
                $post_content = htmlspecialchars_decode($allPost['descr']);
                $post_content = str_replace("&nbsp;", ' ', $post_content);
            } else {
                $post_content = '';
            }

            $calc = [
                'calc' => $allPost['calc'],
                'dateStart' => $allPost['date-start'],
                'dateEnd' => $allPost['date-end'],
                'cost' => $allPost['cost'],
                'calculation' => $allPost['calculation'],
                'keyRate' => SITE_KEYRATE
            ];

            $post_seo = [
                'title' => $allPost['seo_title'],
                'description' => $allPost['seo_description'],
                // 'keywords' => $allPost['post_meta_keywords']
            ];

            // $is_post_slug = unicValue('products', 'allsit', $allPost['allsit']);
            $old_link = explode('-', $allPost['allsit']);
            $is_post_slug = unicValueNotId('products', 'allsit', $allPost['product_id'], $allPost['allsit']);
            if (count($is_post_slug) == 0) {
                $allsit = $allPost['allsit'];
            } elseif (count($is_post_slug) == 1) {
                if ($is_post_slug[0] == $allPost['allsit']) {
                    $allsit = $allPost['allsit'] . '-2';
                } else {
                    $allsit = $allPost['allsit'];
                }
                // $allsit = $allPost['allsit'] . '-2';
            } elseif (count($is_post_slug) > 1) {
                $arr = [];
                foreach ($is_post_slug as $key => $value) {
                    if ($value != $allPost['allsit']) {
                        $arr[] = (int)str_replace($allPost['allsit'] . '-', '', $value);
                    }
                }
                $allsit = $old_link[0] . '-' . max($arr)+1;
            }

            // $is_post_slug = unicValueNotId('products', 'allsit', 14465, 'bytovaya-tekhnika');

            $res = ProductsModel::edit([
                'id'          => $allPost['product_id'],
                'isgr'        => 0,
                'parentid'    => $allPost['parentid'],
                'ceo'         => json_encode($post_seo, JSON_UNESCAPED_UNICODE),
                'title'       => $allPost['title'],
                'description' => $allPost['description'] ?? '',
                'favor'       => $favor,
                'descr'       => $post_content,
                'price'       => $allPost['price'] ?? 0,
                'active'      => $active,
                'calc'        => json_encode($calc, JSON_UNESCAPED_UNICODE),
                'allsit'      => $allsit,
                'vars'        => $allPost['vars'] ?? ''
            ]);

            if ($res) {
                $message['result'] = 'success';
                $message['text'] = 'Изменения сохранены успешно';
            } else {
                $message['result'] = 'error';
                $message['text'] = 'Ошибка, попробуйте позже';
            }
        }

        $message['post'] = $allPost;
        $message['allsit'] = $allsit;

        // $message['calc'] = $calc;
        $result = ['error' => $error, 'message' => $message];

        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    public function add_product($allPost)
    {
        $message = [];
        $error = [];

        if (!$allPost['title']) {
            $message['result'] = 'error';
            $error['type'] = 'title';
            $error['text'] = 'Заполните Наименование шаблона';
        }

        if (count($error)) {
            $message['result'] = 'error';
        } else {
            $favor = 0;
            $active = 0;
            if (array_key_exists('favor', $allPost)) {
                $favor = 1;
            }
            if (array_key_exists('active', $allPost)) {
                $active = 1;
            }

            $pContent = htmlspecialchars_decode($allPost['descr']);
            $pContent = strip_tags($pContent);
            $pContent = str_replace("&nbsp;", '', $pContent);
            if ($pContent) {
                $post_content = htmlspecialchars_decode($allPost['descr']);
                $post_content = str_replace("&nbsp;", ' ', $post_content);
            } else {
                $post_content = '';
            }

            $calc = [
                'calc' => $allPost['calc'],
                'dateStart' => $allPost['date-start'],
                'dateEnd' => $allPost['date-end'],
                'cost' => $allPost['cost'],
                'calculation' => $allPost['calculation'],
                'keyRate' => SITE_KEYRATE
            ];

            $post_seo = [
                'title' => $allPost['seo_title'],
                'description' => $allPost['seo_description'],
                // 'keywords' => $allPost['post_meta_keywords']
            ];

            // $allsit = $allPost['allsit'];
            if ($allPost['allsit']) {
                $is_post_slug = unicValue('products', 'allsit', $allPost['allsit']);
                if (count($is_post_slug) == 0) {
                    $allsit = $allPost['allsit'];
                } elseif (count($is_post_slug) == 1) {
                    if ($is_post_slug[0] == $allPost['slug']) {
                        $allsit = $allPost['allsit'] . '-2';
                    } else {
                        $allsit = $allPost['allsit'];
                    }
                } elseif (count($is_post_slug) > 1) {
                    $arr = [];
                    foreach ($is_post_slug as $key => $value) {
                        if ($value != $allPost['allsit']) {
                            $arr[] = (int)str_replace($allPost['allsit'] . '-', '', $value);
                        }
                    }
                    $allsit = $allPost['allsit'] . '-' . max($arr)+1;
                }
            } else {
                $allsit_title = translit_friendly_url($allPost['title']);
                $is_post_slug = unicValue('products', 'allsit', $allPost['allsit']);
                if (count($is_post_slug) == 0) {
                    $allsit = $allsit_title;
                } elseif (count($is_post_slug) == 1) {
                    $allsit = $allsit_title . '-2';
                } elseif (count($is_post_slug) > 1) {
                    $arr = [];
                    foreach ($is_post_slug as $key => $value) {
                        if ($value != $allsit_title) {
                            $arr[] = (int)str_replace($allsit_title . '-', '', $value);
                        }
                    }
                    $allsit = $allsit_title . '-' . max($arr)+1;
                }
            }

            $res = ProductsModel::create([
                'isgr'        => 0,
                'parentid'    => $allPost['parentid'],
                'ceo'         => json_encode($post_seo, JSON_UNESCAPED_UNICODE),
                'title'       => $allPost['title'],
                'description' => $allPost['description'],
                'favor'       => $favor,
                'descr'       => $post_content,
                'price'       => $allPost['price'],
                'active'      => $active,
                'calc'        => json_encode($calc, JSON_UNESCAPED_UNICODE),
                'allsit'      => $allsit,
                'vars'        => $allPost['vars']
            ]);

            if ($res) {
                $message['result'] = 'success';
                $message['text'] = 'Шаблон создан успешно';
            } else {
                $message['result'] = 'error';
                $message['text'] = 'Ошибка, попробуйте позже';
            }
        }

        $message['post'] = $allPost;
        $result = ['error' => $error,'message' => $message];

        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    public function delete_product($allPost)
    {
        $id = $allPost['product_id'];
        $message = [];

        $del_var = ProductsModel::delete_product($id);
        $message['text'] = 'Шаблон удален';

        echo json_encode(['message' => $message], JSON_UNESCAPED_UNICODE);
    }

    public function create_group_prod($allPost)
    {
        $message = [];

        if ($allPost['parentid'] == 'no') {
            $message['parentid'] = 'Выберите группу';
        }

        if (!$allPost['title']) {
            $message['title'] = 'Заполните имя раздела';
        }

        if ( count( $message ) > 0 ) {
            $message['type'] = 'error';
        } else {
            if (array_key_exists('prod_gr_id', $allPost)) {
                if ($allPost['prod_gr_id']) {
                    $editGr = ProductsModel::edit_gr([
                        'id'          => $allPost['prod_gr_id'],
                        'isgr'        => 1,
                        'parentid'    => $allPost['parentid'],
                        'title'       => $allPost['title'],
                        'description' => $allPost['description']
                    ]);
                    $message['type'] = 'success';
                    $message['text'] = 'Группа шаблонов изменена';

                    $message['post'] = $allPost;
                } else {
                    $last_post_id = ProductsModel::create_gr([
                        'isgr'        => 1,
                        'parentid'    => $allPost['parentid'],
                        'title'       => $allPost['title'],
                        'description' => $allPost['description']
                    ]);
                    if ($last_post_id) {
                        $message['type'] = 'success';
                        $message['id'] = $last_post_id;
                        $message['text'] = 'Группа шаблонов создана';
                    } else {
                        $message['type'] = 'error';
                    }
                }
            }
        }

        echo json_encode($message, JSON_UNESCAPED_UNICODE);
    }

    public function deleteProductGroup($allPost)
    {
        $id = $allPost['prod_id'];
        $message = [];
        $fin = [];
        $vp = '';
        if (array_key_exists('root', $allPost)) {
            $res = [];
            if ($allPost['root'] == 'yes') {
                $vars_parent = ProductsModel::getProductsParentIdGr($id);
                foreach ($vars_parent as $value) {
                    $res = array_merge($res, ProductsModel::getProductsParentId($value['id']));
                }
                $del_prod = ProductsModel::delete_product($id);
                $message['text'] = 'Группа удалена';
            } else if ($allPost['root'] == 'no') {
                $vars_parent = ProductsModel::getProductsParentId($id);
                $del_prod = ProductsModel::delete_product($id);
                $message['text'] = 'Раздел удален';
            } else {
                $vars_parent = ProductsModel::getProductsParentId($id);
            }
            $res = array_merge($res, $vars_parent);
            foreach ($res as $value) {
                $fin[] = $value['id'];
            }
            if (count($fin)) {
                $vp = implode(',', $fin);
                $del_par = ProductsModel::delete_product_parent($vp);
            }
            // $del_var = ProductsModel::delete_product($id);
            // $message['text'] = 'Группа шаблонов удалена';
        }
        // else {
        //     $del_var = ProductsModel::delete_product($id);
        //     $message['text'] = 'Группа шаблонов удалена';
        // }
        echo json_encode(['res' => $fin, 'vp' => $vp, 'message' => $message, 'post' => $allPost], JSON_UNESCAPED_UNICODE);
    }

    public function add_page($allPost)
    {
        $message = [];
        $error = [];

        if (!$allPost['title']) {
            $message['result'] = 'error';
            $error['title'] = 'Заполните Заголовок страницы';
        }

        if ($allPost['page_gr'] == 'cont_page') {
            $product_id = 0;
        } else {
            if ($allPost['product_id'] == 0) {
                $message['result'] = 'error';
                $error['product'] = 'Выберите шаблон';
            } else {
                $product_id = $allPost['product_id'];
            }
        }

        if (count($error)) {
            $message['result'] = 'error';
            $message['post'] = $allPost;
            $result = ['error' => $error,'message' => $message];

            echo json_encode($result, JSON_UNESCAPED_UNICODE);
        } else {
            $link = '';
            // if ($allPost['link']) {
            //     $link = $allPost['link'];
            // } else {
            //     $link = translit_friendly_url($allPost['title']);
            // }

            if ($allPost['link']) {
                $is_post_slug = unicValue('pages', 'slug', $allPost['link']);
                if (count($is_post_slug) == 0) {
                    $link = $allPost['link'];
                } elseif (count($is_post_slug) == 1) {
                    if ($is_post_slug[0] == $allPost['link']) {
                        $link = $allPost['link'] . '-2';
                    } else {
                        $link = $allPost['link'];
                    }
                } elseif (count($is_post_slug) > 1) {
                    $arr = [];
                    foreach ($is_post_slug as $key => $value) {
                        if ($value != $allPost['link']) {
                            $arr[] = (int)str_replace($allPost['link'] . '-', '', $value);
                        }
                    }
                    $link = $allPost['link'] . '-' . max($arr)+1;
                }
            } else {
                $allsit_title = translit_friendly_url($allPost['title']);
                $is_post_slug = unicValue('pages', 'slug', $allsit_title);
                if (count($is_post_slug) == 0) {
                    $link = $allsit_title;
                } elseif (count($is_post_slug) == 1) {
                    $link = $allsit_title . '-2';
                } elseif (count($is_post_slug) > 1) {
                    $arr = [];
                    foreach ($is_post_slug as $key => $value) {
                        if ($value != $allsit_title) {
                            $arr[] = (int)str_replace($allsit_title . '-', '', $value);
                        }
                    }
                    $link = $allsit_title . '-' . max($arr)+1;
                }
            }

            $post_seo = [
                'title' => $allPost['seo_title'],
                'description' => $allPost['seo_description'],
                // 'keywords' => $allPost['post_meta_keywords']
            ];

            $favor = 0;
            $status = 0;
            if (array_key_exists('favor', $allPost)) {
                $favor = 1;
            }
            if (array_key_exists('active', $allPost)) {
                $status = 1;
            }

            $blocks = [];
            if ($allPost['bloks']) {
                $blocks_arr = explode(',', $allPost['bloks']);

                foreach ($blocks_arr as $key => $block) {
                    $blocks[$block] = $allPost[$block];
                }
            }

            // $pContent = htmlspecialchars_decode($allPost['descr']);
            // $pContent = strip_tags($pContent);
            // $pContent = str_replace("&nbsp;", '', $pContent);
            // if ($pContent) {
            //     $post_content = htmlspecialchars_decode($allPost['descr']);
            //     $post_content = str_replace("&nbsp;", ' ', $post_content);
            // } else {
            //     $post_content = '';
            // }

            $res = PagesModel::create([
                'title'       => $allPost['title'],
                'content'     => '',
                'slug'        => $link,
                'url'         => '',
                'status'      => $status,
                'favor'       => $favor,
                'product_id'  => $product_id,
                'terms'       => $allPost['page_gr'],
                'blocks'      => json_encode($blocks, JSON_UNESCAPED_UNICODE),
                'thumb_img'   => '',
                'gallery_img' => '',
                'seo'         => json_encode($post_seo, JSON_UNESCAPED_UNICODE),
                'meta'        => '',
                'views'       => 0
            ]);

            if ($res) {
                $message['result'] = 'success';
                $message['text'] = 'Страница создана успешно';
            } else {
                $message['result'] = 'error';
                $message['text'] = 'Ошибка, попробуйте позже';
            }
        }

        $message['link'] = $link;

        $message['post'] = $allPost;
        $result = ['error' => $error,'message' => $message];

        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    public function edit_page($allPost)
    {
        $message = [];
        $error = [];

        if (!$allPost['title']) {
            $message['result'] = 'error';
            $error['title'] = 'Заполните поле Заголовок страницы';
        }

        if (!$allPost['link']) {
            $message['result'] = 'error';
            $error['link'] = 'Заполните поле Постоянная ссылка';
        }

        if ($allPost['page_gr'] == 'cont_page') {
            $product_id = 0;
        } else {
            if ($allPost['product_id'] == 0) {
                $message['result'] = 'error';
                $error['product'] = 'Выберите шаблон';
            }
            $product_id = $allPost['product_id'];
        }

        if (count($error)) {
            $message['result'] = 'error';
        } else {
            $post_seo = [
                'title' => $allPost['seo_title'],
                'description' => $allPost['seo_description'],
                // 'keywords' => $allPost['post_meta_keywords']
            ];

            $favor = 0;
            $status = 0;
            if (array_key_exists('favor', $allPost)) {
                $favor = 1;
            }
            if (array_key_exists('active', $allPost)) {
                $status = 1;
            }
            $date_modified = date('Y-m-d H:i:s');

            $is_post_slug = unicValueNotId('pages', 'slug', $allPost['page_id'], $allPost['link']);
            if (count($is_post_slug) == 0) {
                $link = $allPost['link'];
            } elseif (count($is_post_slug) == 1) {
                if ($is_post_slug[0] == $allPost['slug']) {
                    $link = $allPost['link'] . '-2';
                } else {
                    $link = $allPost['link'];
                }
                $link = $allPost['link'] . '-2';
            } elseif (count($is_post_slug) > 1) {
                $arr = [];
                foreach ($is_post_slug as $key => $value) {
                    if ($value != $allPost['link']) {
                        $arr[] = (int)str_replace($allPost['link'] . '-', '', $value);
                    }
                }
                $link = $allPost['link'] . '-' . max($arr)+1;
            }

            $blocks_arr = explode(',', $allPost['bloks']);

            $blocks = [];

            foreach ($blocks_arr as $key => $block) {
                $blocks[$block] = $allPost[$block];
            }

            $res = PagesModel::edit([
                'id'          => $allPost['page_id'],
                'title'       => $allPost['title'],
                'content'     => '',
                'slug'        => $link,
                'url'         => '',
                'status'      => $status,
                'favor'       => $favor,
                'product_id'  => $product_id,
                'terms'       => $allPost['page_gr'],
                'blocks'      => json_encode($blocks, JSON_UNESCAPED_UNICODE),
                'thumb_img'   => '',
                'gallery_img' => '',
                'seo'         => json_encode($post_seo, JSON_UNESCAPED_UNICODE),
                'meta'        => '',
                'views'       => 0,
                'modified'    => $date_modified
            ]);

            $message['result'] = 'successEdit';
            $message['text'] = 'Страница сохранена успешно';
        }

        $message['post'] = $allPost;
        $result = ['error' => $error,'message' => $message];

        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    public function pageStatusChange($allPost)
    {
        $res = PagesModel::editStatus([
            'id' => $allPost['page_id'],
            'status' => $allPost['status']
        ]);
        if ($res) {
            $result = 'success';
        } else {
            $result = 'error';
        }
        echo json_encode(['result' => $result], JSON_UNESCAPED_UNICODE);
    }

    public function delete_page($allPost)
    {
        $id = $allPost['page_id'];
        $message = [];
        $del_var = PagesModel::delete_page($id);
        $message['text'] = 'Страница удалена';

        echo json_encode(['message' => $message], JSON_UNESCAPED_UNICODE);
    }

    public function slugUnicAdd($allPost)
    {
        $message = [];
        $is_post_slug = unicValue($allPost['post_type'], $allPost['post_slug'], $allPost['slug']);
        if (count($is_post_slug) == 0) {
            $message['slug'] = $allPost['slug'];
            $message['type'] = 'success';
        } elseif (count($is_post_slug) == 1) {
            // $message['slug'] = $allPost['slug'] . '-2';
            // $message['type'] = 'warning';
            $message['count'] = $is_post_slug;
            if ($is_post_slug[0] == $allPost['slug']) {
                $message['slug'] = $allPost['slug'] . '-2';
                $message['type'] = 'warning';
            } else {
                $message['slug'] = $allPost['slug'];
                $message['type'] = 'success';
            }
        } elseif (count($is_post_slug) > 1) {
            // $message['count'] = $is_post_slug;
            $arr = [];
            foreach ($is_post_slug as $key => $value) {
                if ($value != $allPost['slug']) {
                    $arr[] = (int)str_replace($allPost['slug'] . '-', '', $value);
                }
            }
            $message['slug'] = $allPost['slug'] . '-' . max($arr)+1;
            $message['type'] = 'warning';
        }

        echo json_encode($message, JSON_UNESCAPED_UNICODE);
    }

    public function slugUnicEdit($allPost)
    {
        $message = [];

        if ($allPost['post_type'] == 'products') {
            $product = ProductsModel::getProductForId($allPost['id']);
            $old_slug = $product['allsit'];
        }
        if ($allPost['post_type'] == 'pages') {
            $page = PagesModel::getPageForId($allPost['id']);
            $old_slug = $page['slug'];
        }

        if ($old_slug == $allPost['slug']) {
            $message['slug'] = $allPost['slug'];
            $message['type'] = 'success';
        } else {
            $is_post_slug = unicValue($allPost['post_type'], $allPost['post_slug'], $allPost['slug']);
            if (count($is_post_slug) == 0) {
                $message['slug'] = $allPost['slug'];
                $message['type'] = 'success';
            } elseif (count($is_post_slug) == 1) {
                if ($is_post_slug[0] == $allPost['slug']) {
                    $message['slug'] = $allPost['slug'] . '-2';
                    $message['type'] = 'warning';
                } else {
                    $message['slug'] = $allPost['slug'];
                    $message['type'] = 'success';
                }
            } elseif (count($is_post_slug) > 1) {
                $arr = [];
                foreach ($is_post_slug as $key => $value) {
                    if ($value != $allPost['slug']) {
                        $arr[] = (int)str_replace($allPost['slug'] . '-', '', $value);
                    }
                }
                $message['slug'] = $allPost['slug'] . '-' . max($arr)+1;
                $message['type'] = 'warning';
            }
        }

        echo json_encode($message, JSON_UNESCAPED_UNICODE);
    }

    public function block_cont_render($allPost)
    {
        $page = PagesModel::getPageForId($allPost['page_id']);
        $blocks = json_decode($page['blocks'], true);
        if ($blocks) {
            if (array_key_exists('ssi', $blocks)) {
                $ssi = json_decode($blocks['ssi']);
                $modal_html = blocks_modal_render($ssi);
            } else {
                $file_name = $allPost['block_name'];
                $modal_html = template('/templates/modals/' . $file_name);
            }
        } else {
            $file_name = $allPost['block_name'];
            $modal_html = template('/templates/modals/' . $file_name);
        }

        echo json_encode(['modal_html' => $modal_html, 'allPost' => $allPost], JSON_UNESCAPED_UNICODE);
    }

    public function ssi_save($allPost)
    {
        $page = PagesModel::getPageForId($allPost['page_id']);
        if ($page['blocks']) {
            $blocks = json_decode($page['blocks'], true);
            $blocks[$allPost['block_id']] = $allPost['block_value'];
        } else {
            $blocks = [];
            $blocks[$allPost['block_id']] = $allPost['block_value'];
        }

        $res = PagesModel::editBlocks([
            'id' => $allPost['page_id'],
            'blocks' => json_encode($blocks, JSON_UNESCAPED_UNICODE)
        ]);
        if ($res) {
            $result = 'success';
        } else {
            $result = 'error';
        }
        echo json_encode(['allPost' => $allPost], JSON_UNESCAPED_UNICODE);
    }
}
