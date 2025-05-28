<?php

namespace App\Controllers;

use Hleb\Base\Controller;
use Hleb\Constructor\Data\View;
use Hleb\Static\Request;
use App\Models\{
    VarsModel
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
}
