<?php

namespace App\Controllers;

use Hleb\Base\Controller;
use Hleb\Constructor\Data\View;
use Hleb\Static\Request;
use App\Models\{
    PostModel,
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
        } elseif ($allPost['action'] == 'promt') {
            $this->promt($allPost);
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
}
