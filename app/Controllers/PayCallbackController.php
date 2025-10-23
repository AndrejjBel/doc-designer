<?php

namespace App\Controllers;

use Hleb\Base\Controller;
use Hleb\Constructor\Data\View;
use Hleb\Static\Request;

class PayCallbackController extends Controller
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

        # Рекомендуем проверять, существует ли заказ $orderid,
        # принадлежит ли он пользователю $clientid,
        # совпадает ли его сумма с переданной $sum
        // ...

        # Заказ $orderid можно считать оплаченным,
        # нужно отметить, что он оплачен
        // ...

        echo "OK " . md5($id.$secret_seed);
    }

    public function getPayLink()
    {
        $allPost = Request::allPost();
        $site_settings = json_decode(site_settings('site_settings_pay'));
        # Логин и пароль от личного кабинета PayKeeper
        $user = $site_settings->pay_user;
        $password = hex2bin($site_settings->pay_pass);

        # Basic-авторизация передаётся как base64
        $base64 = base64_encode("$user:$password");
        $headers = Array();
        array_push($headers,'Content-Type: application/x-www-form-urlencoded');

        # Подготавливаем заголовок для авторизации
        array_push($headers,'Authorization: Basic '.$base64);

        # Укажите адрес ВАШЕГО сервера PayKeeper, адрес demo.paykeeper.ru - пример!
        $server_paykeeper = $site_settings->server_paykeeper;

        # Параметры платежа, сумма - обязательный параметр
        # Остальные параметры можно не задавать
        $payment_data = array (
            "pay_amount" => 42.50, // $allPost['pay_amount'];
            "clientid" => "Иванов Иван Иванович", // $allPost['clientid'];
            "orderid" => "Заказ № 10", // $allPost['orderid'];
            "client_email" => "test@example.com", // $allPost['client_email'];
            "service_name" => "Услуга", // $allPost['service_name'];
            "client_phone" => "8 (910) 123-45-67" // $allPost['client_phone'];
        );

        # Готовим первый запрос на получение токена безопасности
        $uri = "/info/settings/token/";

        # Для сетевых запросов в этом примере используется cURL
        $curl = curl_init();

        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_URL,$server_paykeeper.$uri);
        curl_setopt($curl,CURLOPT_CUSTOMREQUEST,'GET');
        curl_setopt($curl,CURLOPT_HTTPHEADER,$headers);
        curl_setopt($curl,CURLOPT_HEADER,false);

        # Инициируем запрос к API
        $response = curl_exec($curl);
        $php_array = json_decode($response,true);

        # В ответе должно быть заполнено поле token, иначе - ошибка
        if (isset($php_array['token'])) $token = $php_array['token']; else die();


        # Готовим запрос 3.4 JSON API на получение счёта
        $uri = "/change/invoice/preview/";

        # Формируем список POST параметров
        $request = http_build_query(array_merge($payment_data, array ('token'=>$token)));

        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_URL,$server_paykeeper.$uri);
        curl_setopt($curl,CURLOPT_CUSTOMREQUEST,'POST');
        curl_setopt($curl,CURLOPT_HTTPHEADER,$headers);
        curl_setopt($curl,CURLOPT_HEADER,false);
        curl_setopt($curl,CURLOPT_POSTFIELDS,$request);


        $response = json_decode(curl_exec($curl),true);
        # В ответе должно быть поле invoice_id, иначе - ошибка
        if (isset($response['invoice_id'])) $invoice_id = $response['invoice_id']; else die();

        # В этой переменной прямая ссылка на оплату с заданными параметрами
        $link = "$server_paykeeper/bill/$invoice_id/";

        # Теперь её можно использовать как угодно, например, выводим ссылку на оплату
        echo $link;
    }
}
