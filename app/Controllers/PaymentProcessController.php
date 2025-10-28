<?php

namespace App\Controllers;

use Hleb\Base\Controller;
use Hleb\Constructor\Data\View;
use Hleb\Static\Request;
use App\Models\{
    ProductsModel,
    OrdersModel,
    User\UsersModel
};
use App\Controllers\MailSmtpNew;

class PaymentProcessController extends Controller
{
    public function payCallback()
    {
        $allPost = Request::allPost();
        $site_settings = json_decode(site_settings('site_settings_pay'));
        $secret_seed = $site_settings->secret_seed;
        $id = $allPost['id'];
        $sum = $allPost['sum'];
        $clientid = $allPost['clientid'];
        $orderid = $allPost['orderid'];
        $key = $allPost['key'];

        if ($key != md5($id.number_format($sum, 2, ".", "").$clientid.$orderid.$secret_seed))
        {
            echo "Error! Hash mismatch";
            exit;
        }

        $order = OrdersModel::getOrder($orderid);
        $clientmeta = json_decode($order['clientmeta']);

        // if (number_format($order['summ'], 2, ".", "") == number_format($sum, 2, ".", "")) {
        //     OrdersModel::orderPayEdit($orderid, 2, $sum, json_encode($allPost, JSON_UNESCAPED_UNICODE));
        //
        //     $home_url = config('main', 'home_url');
        //     $to  = $clientmeta->email;
        //     $site_name = 'Конструктор документов';
        //     $subject = 'Заказ №' . $orderid . '. ' . $site_name;
        //     $body = '';
        //     $body .= '<p>Здравствуйте ' . $allPost['clientid'] . '!</p>';
        //     $body .= '<p>Высылаем заказаный Вами документ по закзазу №' . $orderid . '.</p>';
        //     $body .= '<p><a href="'$home_url . $order['doc_url'] . '">Документ</a></p>';
        //     $body .= '<p>Благодарим за заказ!</p>';
        //     $body .= '<p><strong>Отправлено с сайта <a href="' . $home_url . '">' . $site_name . '</a></strong></p>';
        //
        //     $resultMail = MailSmtpNew::send($site_name, $subject, $body, $to);
        // }

        OrdersModel::orderPayEdit($orderid, 2, $sum, json_encode($allPost, JSON_UNESCAPED_UNICODE));

        $home_url = config('main', 'home_url');
        $to  = $clientmeta->email;
        $site_name = 'Конструктор документов';
        $subject = 'Заказ №' . $orderid . '. ' . $site_name;
        $body = '';
        $body .= '<p>Здравствуйте ' . $allPost['clientid'] . '!</p>';
        $body .= '<p>Высылаем заказаный Вами документ по закзазу №' . $orderid . '.</p>';
        $body .= '<p><a href="' . $home_url . $order['doc_url'] . '">Документ</a></p>';
        $body .= '<p>Благодарим за заказ!</p>';
        $body .= '<p><strong>Отправлено с сайта <a href="' . $home_url . '">' . $site_name . '</a></strong></p>';

        $resultMail = MailSmtpNew::send($site_name, $subject, $body, $to);

        echo "OK " . md5($id.$secret_seed);
    }

    public function payCallbackTest()
    {
        $allPost = Request::allPost();
        $message = [];
        $message['post'] = $allPost;

        $home_url = config('main', 'home_url');
        $to  = 'belandr.sites@gmail.com';
        $site_name = 'Конструктор документов';
        $subject = 'Заказ №1';
        $body = '';
        $body .= '<p>Здравствуйте</p>';
        $body .= '<p>Высылаем документ по закзазу №1.</p>';
        $body .= '<p><a href="#">Документ</a></p>';
        $body .= '<p>Благодарим за заказ!</p>';
        $body .= '<p><strong>Отправлено с сайта <a href="#">Конструктор документов</a></strong></p>';

        $resultMail = MailSmtpNew::send($site_name, $subject, $body, $to);

        echo json_encode($message, true);
    }
}
