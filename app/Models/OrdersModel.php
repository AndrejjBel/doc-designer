<?php

namespace App\Models;

use Hleb\Base\Model;
use Hleb\Static\DB;

class OrdersModel extends Model
{
    public static function create(array $params): int
    {
        $sql = "INSERT INTO orders(
                    user_id,
                    order_products,
                    user_info)
                       VALUES(
                       :user_id,
                       :order_products,
                       :user_info)";

        // $sql = "INSERT INTO orders user_id, order_products VALUES :user_id, :order_products";
        DB::run($sql, $params);
        $sql_last_id =  DB::run("SELECT LAST_INSERT_ID() as last_id")->fetch();
        return $sql_last_id['last_id'];
    }

    public static function edit($params)
    {
        $sql = "UPDATE orders SET user_id = :user_id, order_products = :order_products, status = :status WHERE id = :id";
        return DB::run($sql, $params);
    }

    public static function orderStatusEdit($id, $status)
    {
        $sql = "UPDATE orders SET status = :status WHERE id = :id";
        return DB::run($sql, ['id' => $id, 'status' => $status]);
    }

    public static function getOrdersUser(int $user_id)
    {
        $sql = "SELECT * FROM orders WHERE user_id = :user_id";
        return DB::run($sql, ['user_id' => $user_id])->fetchAll();
    }

    public static function getOrders($page, $limit, $order, $order_by)
    {
        $start = ($page - 1) * $limit;
        $params = [
            'start' => $start,
            'limit' => $limit
        ];
        $string = "ORDER BY $order $order_by LIMIT";
        $sql = "SELECT *
                    FROM orders
                    $string
                    :start, :limit";
        return DB::run($sql, $params)->fetchAll();
    }

    public static function getOrdersCount()
    {
        $sql = "SELECT id FROM orders";
        return  DB::run($sql)->rowCount();
    }
}
