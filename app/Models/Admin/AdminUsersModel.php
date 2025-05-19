<?php

namespace App\Models\Admin;

use Hleb\Base\Model;
use Hleb\Static\DB;
use App\Models\Myorm\MyormModel;
use PDO;

class AdminUsersModel extends Model
{
    public static function getUsersAll(int $page, int $limit, $sheet = ''): array|false
    {
        $string = "ORDER BY id ASC LIMIT";
        $start  = ($page - 1) * $limit;
        $sql = "SELECT * FROM users $string :start, :limit";
        return DB::run($sql, ['start' => $start, 'limit' => $limit])->fetchAll();
    }

    public static function getUser()
    {
        $db = MyormModel::dbc();
        $auth = new \Delight\Auth\Auth($db);
        $id = $auth->getUserId();

        $sth = $db->prepare("SELECT * FROM `users` WHERE `id` = ?");
        $sth->execute(array($id));
        $array = $sth->fetch(PDO::FETCH_ASSOC);
        return $array;
    }

    public static function userId()
    {
        $db = MyormModel::dbc();
        $auth = new \Delight\Auth\Auth($db);
        return $auth->getUserId();
    }
}
