<?php

namespace App\Models;

use Hleb\Base\Model;
use Hleb\Static\DB;

class PagesModel extends Model
{
    public static function create(array $params): int
    {
        $sql = "INSERT INTO pages(title,
                                content,
                                slug,
                                url,
                                status,
                                favor,
                                product_id,
                                terms,
                                blocks,
                                thumb_img,
                                gallery_img,
                                seo,
                                meta,
                                views)

                                VALUES(:title,
                                    :content,
                                    :slug,
                                    :url,
                                    :status,
                                    :favor,
                                    :product_id,
                                    :terms,
                                    :blocks,
                                    :thumb_img,
                                    :gallery_img,
                                    :seo,
                                    :meta,
                                    :views)";
        DB::run($sql, $params);
        $sql_last_id =  DB::run("SELECT LAST_INSERT_ID() as last_id")->fetch();
        return $sql_last_id['last_id'];
    }

    public static function edit($params)
    {
        $sql = "UPDATE pages SET
                    title       = :title,
                    content     = :content,
                    slug        = :slug,
                    url         = :url,
                    status      = :status,
                    favor       = :favor,
                    product_id  = :product_id,
                    terms       = :terms,
                    blocks      = :blocks,
                    thumb_img   = :thumb_img,
                    gallery_img = :gallery_img,
                    seo         = :seo,
                    meta        = :meta,
                    views       = :views,
                    modified    = :modified
                        WHERE id  = :id";

        return DB::run($sql, $params);
    }

    public static function editStatus($params)
    {
        $sql = "UPDATE pages SET status = :status WHERE id  = :id";
        return DB::run($sql, $params);
    }

    public static function editBlocks($params)
    {
        $sql = "UPDATE pages SET blocks = :blocks WHERE id  = :id";
        return DB::run($sql, $params);
    }

    public static function getPagesAll()
    {
        $sql = "SELECT * FROM pages";
        return DB::run($sql)->fetchAll();
    }

    public static function getProductsNav()
    {
        $sql = "SELECT * FROM products WHERE isgr = 1";
        return DB::run($sql)->fetchAll();
    }

    public static function getPagesAbs()
    {
        $sql = "SELECT * FROM pages";
        return DB::run($sql)->rowCount();
    }

    public static function getPagesPage($page, $limit, $order, $order_by)
    {
        // $where = "WHERE isgr = 0";
        $start = ($page - 1) * $limit;
        $params = [
            'start' => $start,
            'limit' => $limit
        ];
        $string = "ORDER BY $order $order_by LIMIT";

        $sql = "SELECT *
                    FROM pages
                    $string
                    :start, :limit";

        return DB::run($sql, $params)->fetchAll();
    }

    public static function getPagesGroupAbs($parent_ids)
    {
        $where = "WHERE parentid IN ($parent_ids)";
        $sql = "SELECT * FROM pages $where";
        return DB::run($sql)->rowCount();
    }

    public static function getProductsGroupParent($params)
    {
        $sql = "SELECT * FROM pages WHERE parentid = :parentid";
        return DB::run($sql, $params)->fetchAll();
    }

    public static function getPageForId($id)
    {
        $sql = "SELECT * FROM pages WHERE id = :id";
        return DB::run($sql, ['id' => $id])->fetch();
    }

    public static function delete_page($page_id)
    {
        $sql = "DELETE FROM pages WHERE id = :id";
        return DB::run($sql, ['id' => $page_id]);
    }

    // varsbyprods
    public static function getVarsForProduct($parentid)
    {
        $sql = "SELECT varid FROM varsbyprods WHERE parentid = :parentid";
        return DB::run($sql, ['parentid' => $parentid])->fetchAll();
    }

    public static function getPostForSlug($slug)
    {
        $sql = "SELECT * FROM pages WHERE slug = :slug";
        return DB::run($sql, ['slug' => $slug])->fetch();
    }




    // Для удаления...
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
