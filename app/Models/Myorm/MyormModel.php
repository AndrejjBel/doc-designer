<?php

namespace App\Models\Myorm;

use Hleb\Base\Model;
use PDO;

class MyormModel extends Model
{
    public static function dbc()
    {
        $array = hl_db_active_connection();
        $user = $array['user'];
        $pass = $array['pass'];
        unset($array['user'], $array['pass'], $array['options']);
        $options = implode(";", $array);
        $db = new PDO($options, $user, $pass);
        // $db = new PDO('mysql:dbname='.DBNAME.';host='.DBHOST.';charset=utf8mb4', $user, $pass);
        return $db;
    }
}
