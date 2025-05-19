<?php

namespace App\Models;

use Hleb\Base\Model;
use Hleb\Static\DB;

class LocationModel extends Model
{
    public static function create(array $params): int
    {
        $sql = "INSERT INTO location(title,
                                    description,
                                    slug,
                                    img,
                                    seo)

                                VALUES(:title,
                                    :description,
                                    :slug,
                                    :img,
                                    :seo)";
        DB::run($sql, $params);
        $sql_last_id =  DB::run("SELECT LAST_INSERT_ID() as last_id")->fetch();
        return $sql_last_id['last_id'];
    }

    public static function edit($params)
    {
        $sql = "UPDATE location SET
                title        = :title,
                description  = :description,
                slug         = :slug,
                img          = :img,
                seo          = :seo
                    WHERE id  = :id";

        return DB::run($sql, $params);
    }

    public static function updateCount($params)
    {
        $sql = "UPDATE location SET count = :count WHERE id  = :id";
        return DB::run($sql, $params);
    }

    public static function getLocations()
    {
        $sql = "SELECT * FROM location";
        return DB::run($sql)->fetchAll();
    }

    public static function getLocationsFront()
    {
        $sql = "SELECT
                    id,
                    title,
                    description,
                    slug,
                    img,
                    count
                        FROM location";
        return DB::run($sql)->fetchAll();
    }

    public static function getLocationsIst()
    {
        $sql = "SELECT id, title, slug FROM location";
        return DB::run($sql)->fetchAll();
    }

    public static function getLocationsIs()
    {
        $sql = "SELECT id, slug FROM location";
        return DB::run($sql)->fetchAll();
    }

    public static function getLocationsTsc()
    {
        $string = "ORDER BY count DESC";
        $sql = "SELECT title, slug, count FROM location $string";
        return DB::run($sql)->fetchAll();
    }

    public static function getLocationForSlug($slug)
    {
        $sql = "SELECT * FROM location WHERE slug = :slug";
        return DB::run($sql, ['slug' => $slug])->fetchAll();
    }

    public static function getLocationForId($id)
    {
        $sql = "SELECT * FROM location WHERE id = :id";
        return DB::run($sql, ['id' => $id])->fetch();
    }

    public static function getLocationsForId(string|null $locations)
    {
        if (empty($locations)) return false;
        $sql = "SELECT
                    id,
                    title,
                    description,
                    slug,
                    img,
                    seo
                        FROM location
                           WHERE id IN(" . $locations . ")";
        return DB::run($sql)->fetchAll();
    }

    public static function getLocationsPage($page, $limit, $order, $order_by)
    {
        $start = ($page - 1) * $limit;
        $params = [
            'start' => $start,
            'limit' => $limit
        ];
        $string = "ORDER BY $order $order_by LIMIT";

        $sql = "SELECT *
                    FROM location
                    $string
                    :start, :limit";

        return DB::run($sql, $params)->fetchAll();
    }

    public static function getLocationsPageFront($page, $limit, $order, $order_by)
    {
        $start = ($page - 1) * $limit;
        $params = [
            'start' => $start,
            'limit' => $limit
        ];
        $string = "ORDER BY $order $order_by LIMIT";

        $sql = "SELECT
                    id,
                    title,
                    description,
                    slug,
                    img,
                    count
                        FROM location
                        $string
                        :start, :limit";

        return DB::run($sql, $params)->fetchAll();
    }

    public static function getLocationsCount()
    {
        $sql = "SELECT id FROM location";
        return  DB::run($sql)->rowCount();
    }
}
