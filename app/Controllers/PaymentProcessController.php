<?php

namespace App\Controllers;

use Hleb\Base\Controller;
use Hleb\Constructor\Data\View;
use Hleb\Static\Request;
use App\Models\{
    ProductsModel,
    OrdersModel,
    VarsModel,
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
        $product = ProductsModel::getProductForId($order['productid']);
        $clientmeta = json_decode($order['clientmeta']);
        $document_drafting = config('main', 'document_drafting');

        // if ($product['parentid'] == 14556) {}

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

        if ($product['parentid'] == 14556) { //in_array($allPost['productid'], $document_drafting)
            OrdersModel::orderPayEdit($orderid, 2, $sum, json_encode($allPost, JSON_UNESCAPED_UNICODE));
            $vars = VarsModel::getVarsAll();
            $strjson = json_decode($order['strjson']);
            $userMeta = json_decode($order['clientmeta']);

            unset($strjson['summ']);
            $nsrtl = '';
            foreach ($strjson as $key => $value) {
                if (is_array($value)) {
                    $nsrtl .= '<p>' . varDescr($vars, $key) . ': <strong>' . implode(', ', $value) . '</strong></p>';
                } else {
                    $nsrtl .= '<p>' . varDescr($vars, $key) . ': <strong>' . $value . '</strong></p>';
                }
            }

            $site_name = 'Конструктор документов';
            $subject = 'Заявка на составление документа';

            $body = '';
            $body .= '<p>Имя: <strong>' . $userMeta['name'] . '</strong></p>';
            $body .= '<p>Телефон: <strong>' . $userMeta['phone'] . '</strong></p>';
            $body .= '<p>E-mail: <strong>' . $userMeta['email'] . '</strong></p>';
            $body .= '<p>Документ:</p>';
            $body .= $nsrtl;
            $body .= '<p><strong>Отправлено с сайта ' . $site_name . '</strong></p>';

            $result = MailSmtpNew::send($site_name, $subject, $body);

            $home_url = config('main', 'home_url');
            $to  = $clientmeta->email;
            $subject = 'Заказ №' . $orderid . '. ' . $site_name;
            $body = '';
            $body .= '<p>Здравствуйте ' . $allPost['clientid'] . '!</p>';
            $body .= '<p>Оплата по закзазу №' . $orderid . ' прошла успешно.</p>';
            $body .= '<p>Юрист перезвонит вам в течении рабочего дня для уточнения данных по документу.</p>';
            $body .= '<p>Благодарим за заказ!</p>';
            $body .= '<p><strong>Отправлено с сайта <a href="' . $home_url . '">' . $site_name . '</a></strong></p>';

            $resultMail = MailSmtpNew::send($site_name, $subject, $body, $to);

            echo "OK " . md5($id.$secret_seed);

        } else {
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
