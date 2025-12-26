<?php

namespace App\Models;

use Hleb\Base\Model;
use Hleb\Static\DB;

class DocOrdersModel extends Model
{
    public static function create(array $params): int
    {
        $sql = "INSERT INTO doc_orders(
                    order_id,
                    productid,
                    status,
                    summ,
                    descr,
                    clientid,
                    clientmeta,
                    strjson,
                    doc_url)
                       VALUES(
                       :order_id,
                       :productid,
                       :status,
                       :summ,
                       :descr,
                       :clientid,
                       :clientmeta,
                       :strjson,
                       :doc_url)";

        DB::run($sql, $params);
        $sql_last_id =  DB::run("SELECT LAST_INSERT_ID() as last_id")->fetch();
        return $sql_last_id['last_id'];
    }

    public static function orderStatusEdit($params)
    {
        $sql = "UPDATE doc_orders SET status = :status, lawyer = :lawyer WHERE id = :id";
        return DB::run($sql, $params);
    }

    public static function getOrdersUser($clientid)
    {
        $sql = "SELECT * FROM doc_orders WHERE clientid = :clientid";
        return DB::run($sql, ['clientid' => $clientid])->fetchAll();
    }

    public static function getOrdersUserPagin($page, $limit, $order, $order_by, $user_id)
    {
        $start = ($page - 1) * $limit;
        $params = [
            'start' => $start,
            'limit' => $limit,
            'clientid' => $user_id
        ];
        $string = "ORDER BY $order $order_by LIMIT";

        $sql = "SELECT *
                    FROM doc_orders
                    WHERE clientid = :clientid
                    $string
                    :start, :limit";

        // $sql = "SELECT * FROM orders WHERE clientid = :clientid";
        return DB::run($sql, $params)->fetchAll();
    }

    public static function getOrder(int $id)
    {
        $sql = "SELECT * FROM doc_orders WHERE id = :id";
        return DB::run($sql, ['id' => $id])->fetch();
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
                    FROM doc_orders
                    WHERE nomer = 0
                    $string
                    :start, :limit";

        return DB::run($sql, $params)->fetchAll();
    }

    public static function getOrdersDoc($page, $limit, $order, $order_by)
    {
        $start = ($page - 1) * $limit;
        $params = [
            'start' => $start,
            'limit' => $limit
        ];
        $string = "ORDER BY $order $order_by LIMIT";

        $sql = "SELECT *
                    FROM doc_orders
                    $string
                    :start, :limit";

        return DB::run($sql, $params)->fetchAll();
    }

    public static function getOrdersDocCount()
    {
        $sql = "SELECT id FROM doc_orders";
        return  DB::run($sql)->rowCount();
    }

    public static function getOrdersUserCount(int $user_id)
    {
        $sql = "SELECT * FROM doc_orders WHERE clientid = :clientid";
        return DB::run($sql, ['clientid' => $user_id])->rowCount();
    }
}
