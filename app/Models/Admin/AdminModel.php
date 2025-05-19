<?php

namespace App\Models\Admin;

use Hleb\Static\DB;
use Hleb\Base\Model;
use App\Models\Myorm\MyormModel;
use PDO;

class AdminModel extends Model
{
    public static function is_logged()
    {
        $db = MyormModel::dbc();
        $auth = new \Delight\Auth\Auth($db);
        return $auth->isLoggedIn();
    }

    public static function is_admin_allowed()
    {
        $db = MyormModel::dbc();
        $auth = new \Delight\Auth\Auth($db);
        return $auth->hasAnyRole(
            \Delight\Auth\Role::ADMIN,
            \Delight\Auth\Role::SUPER_ADMIN
        );
    }

    public static function is_superadmin()
    {
        $db = MyormModel::dbc();
        $auth = new \Delight\Auth\Auth($db);
        return $auth->hasRole(\Delight\Auth\Role::SUPER_ADMIN);
    }

    public static function set_site_settings($params)
    {
        $sql = "INSERT INTO options(
                    option_name,
                    option_value)
                       VALUES(
                       :option_name,
                       :option_value)";

        DB::run($sql, $params);
        $sql_last_id =  DB::run("SELECT LAST_INSERT_ID() as last_id")->fetch();
        return $sql_last_id['last_id'];
    }

    public static function update_site_settings($params)
    {
        $sql = "UPDATE options SET option_value = :option_value WHERE option_name = :option_name";
        return DB::run($sql, $params);
    }

    public static function get_site_settings($option_name)
    {
        $sql = "SELECT option_value FROM options WHERE option_name = :option_name";
        return DB::run($sql, ['option_name' => $option_name])->fetch();
    }
}
