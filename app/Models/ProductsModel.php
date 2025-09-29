<?php

namespace App\Models;

use Hleb\Base\Model;
use Hleb\Static\DB;

class ProductsModel extends Model
{
    public static function create(array $params): int
    {
        $sql = "INSERT INTO products(isgr,
                                parentid,
                                ceo,
                                title,
                                description,
                                favor,
                                descr,
                                price,
                                active,
                                calc,
                                allsit,
                                vars)

                                VALUES(:isgr,
                                    :parentid,
                                    :ceo,
                                    :title,
                                    :description,
                                    :favor,
                                    :descr,
                                    :price,
                                    :active,
                                    :calc,
                                    :allsit,
                                    :vars)";
        DB::run($sql, $params);
        $sql_last_id =  DB::run("SELECT LAST_INSERT_ID() as last_id")->fetch();
        return $sql_last_id['last_id'];
    }

    public static function create_gr(array $params): int
    {
        $sql = "INSERT INTO products(isgr,
                                parentid,
                                title,
                                description)

                                VALUES(:isgr,
                                    :parentid,
                                    :title,
                                    :description)";
        DB::run($sql, $params);
        $sql_last_id =  DB::run("SELECT LAST_INSERT_ID() as last_id")->fetch();
        return $sql_last_id['last_id'];
    }

    public static function edit_gr($params)
    {
        $sql = "UPDATE products SET
                    isgr         = :isgr,
                    parentid     = :parentid,
                    title        = :title,
                    description  = :description
                        WHERE id  = :id";

        return DB::run($sql, $params);
    }

    public static function create_def(array $params): int
    {
        $sql = "INSERT INTO products(isgr,
                                parentid,
                                ceo,
                                title,
                                description,
                                favor,
                                descr,
                                price,
                                typeid,
                                barcod,
                                active,
                                pic,
                                helpdata,
                                scriptdata,
                                writehelp,
                                infopath,
                                allsit,
                                vars)

                                VALUES(:isgr,
                                    :parentid,
                                    :ceo,
                                    :title,
                                    :description,
                                    :favor,
                                    :descr,
                                    :price,
                                    :typeid,
                                    :barcod,
                                    :active,
                                    :pic,
                                    :helpdata,
                                    :scriptdata,
                                    :writehelp,
                                    :infopath,
                                    :allsit,
                                    :vars)";
        DB::run($sql, $params);
        $sql_last_id =  DB::run("SELECT LAST_INSERT_ID() as last_id")->fetch();
        return $sql_last_id['last_id'];
    }

    public static function edit($params)
    {
        $sql = "UPDATE products SET
                    isgr         = :isgr,
                    parentid     = :parentid,
                    ceo          = :ceo,
                    title        = :title,
                    description  = :description,
                    favor        = :favor,
                    descr        = :descr,
                    price        = :price,
                    active       = :active,
                    calc         = :calc,
                    allsit       = :allsit,
                    vars         = :vars
                        WHERE id  = :id";

        return DB::run($sql, $params);
    }

    public static function editVars($params)
    {
        $sql = "UPDATE products SET vars = :vars WHERE id  = :id";
        return DB::run($sql, $params);
    }

    public static function editStatus($params)
    {
        $sql = "UPDATE products SET active = :active WHERE id  = :id";
        return DB::run($sql, $params);
    }

    public static function getProductsAll()
    {
        $sql = "SELECT * FROM products";
        return DB::run($sql)->fetchAll();
    }

    public static function getProdSlug()
    {
        $sql = "SELECT allsit FROM products";
        $res = DB::run($sql)->fetchAll();
        $allsit = [];
        foreach ($res as $key => $value) {
            if ($value['allsit']) {
                $allsit[] = $value['allsit'];
            }
        }
        return $allsit;
    }

    public static function getProdSlugNotId($params)
    {
        $sql = "SELECT allsit FROM products WHERE NOT id = :id";
        $res = DB::run($sql, $params)->fetchAll();
        $allsit = [];
        foreach ($res as $key => $value) {
            if ($value['allsit']) {
                $allsit[] = $value['allsit'];
            }
        }
        return $allsit;
    }

    public static function getProductsNav()
    {
        $sql = "SELECT * FROM products WHERE isgr = 1";
        return DB::run($sql)->fetchAll();
    }

    public static function getProductsAbs()
    {
        $sql = "SELECT * FROM products WHERE isgr = 0";
        return DB::run($sql)->rowCount();
    }

    public static function getProductsDocPage($isgr=0)
    {
        $sql = "SELECT id, parentid, title, allsit FROM products WHERE active = 1 AND isgr = :isgr";
        return  DB::run($sql, ['isgr' => $isgr])->fetchAll();
    }

    public static function getProductsGr()
    {
        $sql = "SELECT * FROM products WHERE isgr = 1";
        return DB::run($sql)->fetchAll();
    }

    public static function getProductsNogr()
    {
        $sql = "SELECT id FROM products WHERE isgr = 0";
        return DB::run($sql)->fetchAll();
    }

    public static function getProductsPage($page, $limit, $order, $order_by)
    {
        $where = "WHERE isgr = 0";
        $start = ($page - 1) * $limit;
        $params = [
            'start' => $start,
            'limit' => $limit
        ];
        $string = "ORDER BY $order $order_by LIMIT";

        $sql = "SELECT *
                    FROM products
                    $where
                    $string
                    :start, :limit";

        return DB::run($sql, $params)->fetchAll();
    }

    public static function getProductsPageGroup($page, $limit, $order, $order_by, $parent_ids)
    {
        $where = "WHERE parentid IN ($parent_ids)";
        $start = ($page - 1) * $limit;
        $params = [
            'start' => $start,
            'limit' => $limit
        ];
        $string = "ORDER BY $order $order_by LIMIT";

        $sql = "SELECT *
                    FROM products
                    $where
                    $string
                    :start, :limit";

        return DB::run($sql, $params)->fetchAll();
    }

    public static function getProductsGroupAbs($parent_ids)
    {
        $where = "WHERE parentid IN ($parent_ids)";
        $sql = "SELECT * FROM products $where";
        return DB::run($sql)->rowCount();
    }

    public static function getProductsGroupParent($params)
    {
        $sql = "SELECT * FROM products WHERE parentid = :parentid";
        return DB::run($sql, $params)->fetchAll();
    }

    public static function getProductForId($id)
    {
        $sql = "SELECT * FROM products WHERE id = :id";
        return DB::run($sql, ['id' => $id])->fetch();
    }

    public static function getProductForSlug($slug)
    {
        $sql = "SELECT * FROM products WHERE allsit = :allsit";
        return DB::run($sql, ['allsit' => $slug])->fetch();
    }

    public static function delete_product($product_id)
    {
        $sql = "DELETE FROM products WHERE id = :id";
        return DB::run($sql, ['id' => $product_id]);
    }

    public static function delete_product_parent($parent_id)
    {
        $sql = "DELETE FROM products WHERE id IN (:parent_id)";
        return DB::run($sql, ['parent_id' => $parent_id]);
    }

    public static function getProductsParentId($parentid)
    {
        $sql = "SELECT id FROM products WHERE parentid = :parentid";
        return  DB::run($sql, ['parentid' => $parentid])->fetchAll();
    }

    public static function getProductsParentIdGr($parentid, $isgr=1)
    {
        $sql = "SELECT id FROM products WHERE parentid = :parentid AND isgr = :isgr";
        return  DB::run($sql, ['parentid' => $parentid, 'isgr' => $isgr])->fetchAll();
    }

    // varsbyprods
    public static function getVarsForProduct($parentid)
    {
        $sql = "SELECT varid FROM varsbyprods WHERE parentid = :parentid";
        return DB::run($sql, ['parentid' => $parentid])->fetchAll();
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
