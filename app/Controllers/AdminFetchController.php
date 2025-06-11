<?php

namespace App\Controllers;

use Hleb\Base\Controller;
use Hleb\Constructor\Data\View;
use Hleb\Static\Request;
use App\Models\{
    VarsModel,
    ProductsModel
};

class AdminFetchController extends Controller
{
    public function index()
    {
        $allPost = Request::allPost();
        if ($allPost['action'] == 'edit_status') {
            $this->edit_status($allPost);
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
    }

    public function change_vars($allPost)
    {
        $id = $allPost['var_id'];
        $vars = VarsModel::getVarsParent($id);
        echo json_encode($vars, JSON_UNESCAPED_UNICODE);
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
            $last_post_id = VarsModel::create_var(
                [
                    'parentid'   => $allPost['parentid'],
                    'isgr'       => 1,
                    'title'      => $allPost['title'],
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
            } else {
                $message['type'] = 'error';
            }
        }

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
                    'title'      => $allPost['title'],
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

        $res = ProductsModel::edit([
            'id'          => $allPost['product_id'],
            'isgr'        => 0,
            'parentid'    => $allPost['parentid'],
            'title'       => $allPost['title'],
            'description' => $allPost['description'] ?? '',
            'favor'       => $favor,
            'descr'       => $post_content,
            'price'       => $allPost['price'] ?? 0,
            'active'      => $active,
            'calc'        => $allPost['calc'],
            'allsit'      => $allPost['allsit'] ?? '',
            'vars'        => $allPost['vars'] ?? ''
        ]);

        if ($res) {
            $message['result'] = 'success';
            $message['text'] = 'Изменения сохранены успешно';
        } else {
            $message['result'] = 'error';
            $message['text'] = 'Ошибка, попробуйте позже';
        }

        $message['post'] = $allPost;

        echo json_encode($message, JSON_UNESCAPED_UNICODE);
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

            $res = ProductsModel::create([
                'isgr'        => 0,
                'parentid'    => $allPost['parentid'],
                'title'       => $allPost['title'],
                'description' => $allPost['description'],
                'favor'       => $favor,
                'descr'       => $post_content,
                'price'       => $allPost['price'],
                'active'      => $active,
                'calc'        => $allPost['calc'],
                'allsit'      => $allPost['allsit'],
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

        $del_var = ProductsModel::delete_var($id);
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
            $last_post_id = ProductsModel::create_gr([
                'isgr'        => 1,
                'parentid'    => $allPost['parentid'],
                'title'       => $allPost['title'],
                'description' => $allPost['description']
            ]);
            if ($last_post_id) {
                $message['type'] = 'success';
                $message['id'] = $last_post_id;
            } else {
                $message['type'] = 'error';
            }
        }

        echo json_encode($message, JSON_UNESCAPED_UNICODE);
    }
}
