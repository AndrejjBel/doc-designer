<?php

namespace App\Controllers;

use Hleb\Base\Controller;
use Hleb\Constructor\Data\View;
use Hleb\Static\Request;
use App\Models\{
    PostModel,
    ProductsModel,
    OrdersModel,
    User\UsersModel
};

class FrontFetchController extends Controller
{
    public function index()
    {
        $allPost = Request::allPost();

        if ($allPost['action'] == 'place_order') {
            $this->place_order($allPost);
        }
        if ($allPost['action'] == 'promt') {
            $this->promt($allPost);
        }
        if ($allPost['action'] == 'buyDocument') {
            $this->buyDocument($allPost);
        }
    }

    public function place_order($allPost)
    {
        $message = [];
        $userId = userId();
        $userIdOrder = ($userId)? $userId : 0;
        $orderList = json_decode($allPost['orderList'], true);

        $last_post_id = OrdersModel::create(
            [
                'user_id'        => $userIdOrder,
                'order_products' => $allPost['orderList'],
                'user_info'      => $allPost['name'] . ';' . $allPost['phone'] . ';' . preg_replace('/[^0-9+]/', '', $allPost['phone'])
            ]
        );

        if ($last_post_id) {
            $prod_id = [];
            foreach ($orderList as $key => $value) {
                $prod_id[] = $value['id'];
            }

            $prod_id_count = [];
            foreach ($orderList as $key => $value) {
                $prod_id_count[$value['id']] = $value['count'];
            }

            $products = PostModel::getPostsForId(implode(',', $prod_id));

            $products_data_cart = [];
            foreach ($products as $key => $product) {
                if (in_array($product['post_id'], $prod_id)) {
                    $product['count'] = (int)$prod_id_count[(int)$product['post_id']];
                }
                $products_data_cart[] = $product;
            }

            $text_tg = '<b>Заказ</b>' . "\n";
            foreach ($products_data_cart as $key => $product) {
                $text_tg .= '#' . $product['post_id'] . ' ';
                $text_tg .= $product['post_title'] . ' - ';
                $text_tg .= $product['count'] . "\n";
            }

            message_to_telegram($text_tg, '477875115');
            $message['type'] = 'success';
        } else {
            $message['type'] = 'error';
        }

        echo json_encode($message, true);
    }

    public function buyDocument($allPost)
    {
        $message = [];

        $user = UsersModel::getUser();

        if ($user) {
            $user_id = $user['id'];
        } else {
            $userForEmail = getUserForEmail($allPost['user_email']);
            if ($userForEmail) {
                $user_id = $userForEmail['id'];
            } else {
                $loginsEmails = UsersModel::getLoginsEmails();

                $password = gen_password(8);

                $email_str = strstr($allPost['user_email'], '@', true);

                $is_post_slug = unicValue('users', 'username', $email_str);
                if (count($email_str) == 0) {
                    $username = $email_str;
                } elseif (count($email_str) == 1) {
                    $username = $email_str . '-2';
                } elseif (count($email_str) > 1) {
                    $arr = [];
                    foreach ($email_str as $key => $value) {
                        if ($value != $email_str) {
                            $arr[] = (int)str_replace($email_str . '-', '', $value);
                        }
                    }
                    $username = $email_str . '-' . max($arr)+1;
                }

                $user_id = $auth->admin()->createUser($allPost['user_email'], $password, $username);
                $user_meta = [];
                $user_meta['phone'] = $allPost['user_phone'];
                $user_meta['description'] = '';
                UsersModel::updateUserMeta(
                    [
                        'id' => $user_id,
                        'fio' => $allPost['user_fio'],
                        'meta' =>json_encode($user_meta, JSON_UNESCAPED_UNICODE)
                    ]
                );

                // отправляем письмо о регистрации и необходимости подтверждения Email
                // $home_url = config('main', 'home_url');
                // $to  = $allPost['user_email'];
                // $subject = "Регистрация на сайте";
                // $message = '<p>Вы зарегистрированы на сайте: </p>' . "\r\n";
                // $message .= '<p>Для авторизации используйте: </p>' . "\r\n";
                // $message .= '<p>Логин: </p>' . "\r\n";
                // $message .= $username . ' или ' . $allPost['user_email'] . "\r\n";
                // $message .= '<p>Пароль: </p>' . "\r\n";
                // $message .= $password . "\r\n";
                // $headers  = 'MIME-Version: 1.0' . "\r\n";
                // $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                // $headers .= 'To: <' . $to . '>' . "\r\n";
                // $headers .= 'From: administrator@urist-master.ru <administrator@urist-master.ru>' . "\r\n";
                // $headers .= 'Cc: administrator@urist-master.ru' . "\r\n";
                // $headers .= 'Bcc: administrator@urist-master.ru' . "\r\n";
                // mail($to, $subject, $message, $headers);
            }
        }

        $clientmeta = [
            'name'  => $allPost['user_fio'],
            'phone' => $allPost['user_phone'],
            'email' => $allPost['user_email'],
        ];

        $strjson = $allPost;
        unset($strjson['action']);
        unset($strjson['productid']);
        unset($strjson['user_fio']);
        unset($strjson['user_phone']);
        unset($strjson['user_email']);
        unset($strjson['user_cbaccept']);
        unset($strjson['user_cbaccept_ret']);
        unset($strjson['_token']);

        $order_id = OrdersModel::create(
            [
                'productid'  => $allPost['productid'],
                'nomer'      => 0,
                'status'     => 1,
                'summ'       => $allPost['summ'],
                'sumpay'     => '',
                'typepay'    => 4,
                'descr'      => '',
                'clientid'   => $user_id,
                'clientmeta' => json_encode($clientmeta, JSON_UNESCAPED_UNICODE),
                'useropen'   => 0,
                'strjson'    => json_encode($strjson, JSON_UNESCAPED_UNICODE),
                'doc_url'    => ''
            ]
        );

        $product = ProductsModel::getProductForId($allPost['productid']);

        $html = '<style type="text/css">
        body {
            font-family: DejaVu Serif;
            margin-top: 10px;
            margin-bottom: 10px;
            position: relative;
            line-height: 1.2;
        }
        .ql-editor .ql-align-justify {
            text-align: justify;
        }
        .ql-editor p {
            margin: 0;
            padding-top: 0;
            padding-bottom: 0;
        }
        .ql-editor .ql-align-center {
            text-align: center;
        }
        .ql-indent-8 {
            padding-left: 25em;
        }
        .ql-align-justify {
            text-indent: 30px;
        }
        .ql-editor .ql-align-right {
            text-align: right;
        }
        </style>
        <div class="product-block ql-editor">' . replace_vars_order_content($strjson, $product['descr']) . '</div>';

        $doc_url = html_to_pdf($html, $order_id);

        OrdersModel::orderDocUrlEdit($order_id, $doc_url);

        $message['post'] = $allPost;
        $message['user'] = $user;
        $message['doc_url'] = $doc_url;
        echo json_encode($message, true);
    }
}
