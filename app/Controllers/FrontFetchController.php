<?php

namespace App\Controllers;

use Hleb\Base\Controller;
use Hleb\Constructor\Data\View;
use Hleb\Static\Request;
use App\Models\{
    PostModel,
    ProductsModel,
    OrdersModel,
    User\UsersModel,
    Myorm\MyormModel
};

use App\Content\MailSmtpNew;

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
        if ($allPost['action'] == 'contactForm') {
            $this->contactForm($allPost);
        }
    }

    public function buyDocumentTest($allPost)
    {
        $message = [];
        $message['post'] = $allPost;

        $user = UsersModel::getUser();
        $message['user'] = $user;

        if ($user) {
            $user_id = $user['id'];
        } else {
            $userForEmail = UsersModel::getUserForEmail($allPost['user_email']);
            $message['userForEmail'] = $userForEmail;
            if ($userForEmail) {
                $user_id = $userForEmail['id'];
                $message['user_id'] = $user_id;
            } else {
                // $loginsEmails = UsersModel::getLoginsEmails();

                $password = gen_password(8);

                $email_str = strstr($allPost['user_email'], '@', true);

                $is_post_slug = unicValue('users', 'username', $email_str);
                if (count($is_post_slug) == 0) {
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

                // $user_id = $auth->admin()->createUser($allPost['user_email'], $password, $username);
                $user_meta = [];
                $user_meta['phone'] = $allPost['user_phone'];
                $user_meta['description'] = '';
                // UsersModel::updateUserMeta(
                //     [
                //         'id' => $user_id,
                //         'fio' => $allPost['user_fio'],
                //         'meta' =>json_encode($user_meta, JSON_UNESCAPED_UNICODE)
                //     ]
                // );

                $message['password'] = $password;
                $message['username'] = $username;
                $message['is_post_slug'] = $is_post_slug;
            }
        }

        echo json_encode($message, true);
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
            $userForEmail = UsersModel::getUserForEmail($allPost['user_email']);
            if ($userForEmail) {
                $user_id = $userForEmail['id'];
            } else {
                // $loginsEmails = UsersModel::getLoginsEmails();

                $password = gen_password(8);

                $email_str = strstr($allPost['user_email'], '@', true);

                $is_post_slug = unicValue('users', 'username', $email_str);
                if (count($is_post_slug) == 0) {
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

                $db = MyormModel::dbc();
                $auth = new \Delight\Auth\Auth($db);

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
                $home_url = config('main', 'home_url');
                $to = $allPost['user_email'];
                $site_name = 'Конструктор документов';
                $subject = 'Регистрация на сайте';

                $body = '';
                $body .= '<p><strong>Вы зарегистрированы на сайте: ' . $site_name . '</strong></p>';
                $body .= '<p>Для авторизации используйте: </p>';
                $body .= '<p>Логин: </p>';
                $body .= $username . ' или ' . $allPost['user_email'];
                $body .= '<p>Пароль: ' . $password . '</p>';
                $body .= '<p><strong>Отправлено с сайта <a href="' . $home_url . '">' . $site_name . '</a></strong></p>';

                $resultMail = MailSmtpNew::send($site_name, $subject, $body, $to);
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

        $payment_data = [
            "pay_amount" => number_format($allPost['summ'], 2, '.', ''),
            "clientid" => $allPost['user_fio'], // $allPost['clientid'];
            "orderid" => $order_id, // $allPost['orderid'];
            "client_email" => $allPost['user_email'], // $allPost['client_email'];
            "service_name" => $product['title'] . ' (' . $allPost['productid'] . ')', // $allPost['service_name'];
            "client_phone" => $allPost['user_phone'] // $allPost['client_phone'];
        ];
        $pay_link = $this->getPayLink($payment_data);

        $message['post'] = $allPost;
        $message['user'] = $user;
        $message['doc_url'] = $doc_url;
        $message['pay_link'] = $pay_link;
        $message['payment_data'] = $payment_data;
        echo json_encode($message, true);
    }

    public function getPayLink($payment_data)
    {
        $allPost = Request::allPost();
        $site_settings = json_decode(site_settings('site_settings_pay'));
        $user = $site_settings->pay_user;
        $password = hex2bin($site_settings->pay_pass);
        $base64 = base64_encode("$user:$password");
        $headers = Array();
        array_push($headers,'Content-Type: application/x-www-form-urlencoded');
        array_push($headers,'Authorization: Basic '.$base64);
        $server_paykeeper = $site_settings->server_paykeeper;
        // $payment_data = array (
        //     "pay_amount" => 42.50, // $allPost['pay_amount'];
        //     "clientid" => "Иванов Иван Иванович", // $allPost['clientid'];
        //     "orderid" => "Заказ № 10", // $allPost['orderid'];
        //     "client_email" => "test@example.com", // $allPost['client_email'];
        //     "service_name" => "Услуга", // $allPost['service_name'];
        //     "client_phone" => "8 (910) 123-45-67" // $allPost['client_phone'];
        // );

        $uri = "/info/settings/token/";
        $curl = curl_init();
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_URL,$server_paykeeper.$uri);
        curl_setopt($curl,CURLOPT_CUSTOMREQUEST,'GET');
        curl_setopt($curl,CURLOPT_HTTPHEADER,$headers);
        curl_setopt($curl,CURLOPT_HEADER,false);
        $response = curl_exec($curl);
        $php_array = json_decode($response,true);
        if (isset($php_array['token'])) $token = $php_array['token']; else die();
        $uri = "/change/invoice/preview/";
        $request = http_build_query(array_merge($payment_data, array ('token'=>$token)));

        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_URL,$server_paykeeper.$uri);
        curl_setopt($curl,CURLOPT_CUSTOMREQUEST,'POST');
        curl_setopt($curl,CURLOPT_HTTPHEADER,$headers);
        curl_setopt($curl,CURLOPT_HEADER,false);
        curl_setopt($curl,CURLOPT_POSTFIELDS,$request);

        $response = json_decode(curl_exec($curl),true);
        if (isset($response['invoice_id'])) $invoice_id = $response['invoice_id']; else die();
        $link = "$server_paykeeper/bill/$invoice_id/";
        // $ret = ['link' => $link];
        // echo json_encode($ret, true);

        return $link;
    }

    public function contactForm($allPost)
    {
        $message = [];
        if ($allPost['email']) {
            $message['type'] = 'succes';
            echo json_encode($message, true);
            die();
        } else {
            if (!$allPost['name']) {
                $message['name'] = 'no';
            }
            if (!$allPost['phone']) {
                $message['phone'] = 'no';
            }
            if (!$allPost['message']) {
                $message['message'] = 'no';
            }
            if (isset($allPost['privacy'])) {
                if (!$allPost['privacy']) {
                    $message['privacy'] = 'no';
                }
            } else {
                $message['privacy'] = 'no';
            }
            if (count($message)) {
                $message['type'] = 'error';
                $message['post'] = $allPost;
                echo json_encode($message, true);
                die();
            } else {
                $message['type'] = 'succes';
                $message['post'] = $allPost;

                $site_name = 'Конструктор документов';
                $subject = 'Контакная форма';

                $body = '';
                $body .= '<p>Имя: <strong>' . $allPost['name'] . '</strong></p>';
                $body .= '<p>Телефон: <strong>' . $allPost['phone'] . '</strong></p>';
                $body .= '<p>Сообщение:</p>';
                $body .= '<p><strong>' . $allPost['message'] . '</strong></p><br>';
                $body .= '<p><strong>Отправлено с сайта ' . $site_name . '</strong></p>';

                $result = MailSmtpNew::send($site_name, $subject, $body);

                $message['result'] = $result;

                echo json_encode($message, true);
                die();
            }
        }
    }
}
