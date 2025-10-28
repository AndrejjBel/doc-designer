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
use App\Content\{
    MailSmtpNew
};

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

        if (number_format($order['summ'], 2, ".", "") == number_format($sum, 2, ".", "")) {
            OrdersModel::orderPayEdit($orderid, 2, $sum, json_encode($allPost, JSON_UNESCAPED_UNICODE));

            $home_url = config('main', 'home_url');
            $to  = $clientmeta->email;
            $site_name = 'Конструктор документов';
            $subject = 'Заказ №' . $orderid . '. ' . $site_name;
            $body = '';
            $body .= '<p>Здравствуйте ' . $allPost['clientid'] . '!</p>';
            $body .= '<p>Высылаем заказаный Вами документ по закзазу №' . $orderid . '.</p>';
            $body .= '<p><a href="'$home_url . $order['doc_url'] . '">Документ</a></p>';
            $body .= '<p>Благодарим за заказ!</p>';
            $body .= '<p><strong>Отправлено с сайта <a href="' . $home_url . '">' . $site_name . '</a></strong></p>';

            $resultMail = MailSmtpNew::send($site_name, $subject, $body, $to);
        }

        echo "OK " . md5($id.$secret_seed);
    }

    public function getPayLinks()
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
        $payment_data = array (
            "pay_amount" => 42.50, // $allPost['pay_amount'];
            "clientid" => "Иванов Иван Иванович", // $allPost['clientid'];
            "orderid" => "Заказ № 10", // $allPost['orderid'];
            "client_email" => "test@example.com", // $allPost['client_email'];
            "service_name" => "Услуга", // $allPost['service_name'];
            "client_phone" => "8 (910) 123-45-67" // $allPost['client_phone'];
        );

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
        $ret = ['link' => $link];
        echo json_encode($ret, true);
    }
}
