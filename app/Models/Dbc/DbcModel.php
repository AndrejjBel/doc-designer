<?php

namespace App\Models\Dbc;

use Hleb\Base\Model;
use PDO;

class DbcModel extends Model
{
    public static function dbc()
    {
        $array = hl_db_active_connection();
        $user = $array['user'];
        $pass = $array['pass'];
        unset($array['user'], $array['pass'], $array['options']);
        $options = implode(";", $array);
        $db = new PDO($options, $user, $pass);
        return $db;
    }
}
