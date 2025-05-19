<?php

namespace App\Models;

use Hleb\Base\Model;
use Hleb\Static\DB;

class GlampingModel extends Model
{
    public static function create(array $params): int
    {
        $sql = "INSERT INTO glampings(post_title,
                                    post_content,
                                    post_slug,
                                    post_url,
                                    post_status,
                                    post_author,
                                    post_term,
                                    post_tags,
                                    post_thumb_img,
                                    post_gallery_img,
                                    post_price,
                                    post_working,
                                    post_seo,
                                    post_meta,
                                    post_meta_acc)

                                VALUES(:post_title,
                                    :post_content,
                                    :post_slug,
                                    :post_url,
                                    :post_status,
                                    :post_author,
                                    :post_term,
                                    :post_tags,
                                    :post_thumb_img,
                                    :post_gallery_img,
                                    :post_price,
                                    :post_working,
                                    :post_seo,
                                    :post_meta,
                                    :post_meta_acc)";

        DB::run($sql, $params);

        $sql_last_id =  DB::run("SELECT LAST_INSERT_ID() as last_id")->fetch();

        return $sql_last_id['last_id'];
    }

    public static function edit($params)
    {
        $sql = "UPDATE glampings SET
                post_title         = :post_title,
                post_content       = :post_content,
                post_status        = :post_status,
                post_term          = :post_term,
                post_tags          = :post_tags,
                post_thumb_img     = :post_thumb_img,
                post_gallery_img   = :post_gallery_img,
                post_price         = :post_price,
                post_working       = :post_working,
                post_seo           = :post_seo,
                post_meta          = :post_meta,
                post_meta_acc      = :post_meta_acc,
                post_modified      = :post_modified
                        WHERE id   = :id";

        return DB::run($sql, $params);
    }

    public static function editThumb($params)
    {
        $sql = "UPDATE glampings SET post_thumb_img = :post_thumb_img WHERE id = :id";
        return DB::run($sql, $params);
    }

    public static function editGallery($params)
    {
        $sql = "UPDATE glampings SET post_gallery_img = :post_gallery_img WHERE id = :id";
        return DB::run($sql, $params);
    }

    public static function editAcc($params)
    {
        $sql = "UPDATE glampings SET post_meta_acc = :post_meta_acc WHERE id = :id";
        return DB::run($sql, $params);
    }

    public static function editStatus($params)
    {
        $sql = "UPDATE glampings SET post_status = :post_status WHERE id = :id";
        return DB::run($sql, $params);
    }

    public static function getPostsUser(int $post_author, $post_status='publish')
    {
        if ($post_status) {
            $sql = "SELECT * FROM glampings WHERE post_author = :post_author AND post_status = :post_status";
            return DB::run($sql, ['post_author' => $post_author, 'post_status' => $post_status])->fetchAll();
        } else {
            $sql = "SELECT * FROM glampings WHERE post_author = :post_author";
            return DB::run($sql, ['post_author' => $post_author])->fetchAll();
        }
    }

    public static function getPostForSlug($post_slug)
    {
        $sql = "SELECT * FROM glampings WHERE post_slug = :post_slug";
        return DB::run($sql, ['post_slug' => $post_slug])->fetchAll();
    }

    public static function getPostForId($post_id)
    {
        $sql = "SELECT * FROM glampings WHERE id = :id";
        return DB::run($sql, ['id' => $post_id])->fetch();
    }

    public static function getPostsForId(string|null $posts)
    {
        if (empty($posts)) return false;
        $sql = "SELECT
                    post_id,
                    post_title,
                    post_url,
                    post_thumb_img,
                    post_price
                        FROM glampings
                           WHERE post_id IN(" . $posts . ") AND post_status = 'publish'";
        return DB::run($sql)->fetchAll();
    }

    public static function getPosts($page, $limit, $order, $order_by, $post_status='publish')
    {
        $start = ($page - 1) * $limit;
        $where = "WHERE post_status = :post_status";
        $params = [
            'start' => $start,
            'limit' => $limit,
            'post_status' => $post_status
        ];
        if (!$post_status) {
            $where = "";
            $params = [
                'start' => $start,
                'limit' => $limit
            ];
        }
        $string = "ORDER BY $order $order_by LIMIT";

        $sql = "SELECT *
                    FROM glampings
                    $where
                    $string
                    :start, :limit";

        return DB::run($sql, $params)->fetchAll();
    }

    public static function getPostsLocation($page, $limit, $order, $order_by, $post_term, $post_status='publish')
    {
        $start = ($page - 1) * $limit;
        $where = "WHERE post_term = :post_term";
        $where .= " AND post_status = :post_status";
        $params = [
            'start' => $start,
            'limit' => $limit,
            'post_term' => $post_term,
            'post_status' => $post_status
        ];
        if (!$post_status) {
            $where = "WHERE post_term = :post_term";
            $params = [
                'start' => $start,
                'limit' => $limit,
                'post_term' => $post_term
            ];
        }
        $string = "ORDER BY $order $order_by LIMIT";

        $sql = "SELECT *
                    FROM glampings
                    $where
                    $string
                    :start, :limit";

        return DB::run($sql, $params)->fetchAll();
    }

    public static function getPostsUserPag($page, $limit, $order, $order_by, $post_author)
    {
        $start = ($page - 1) * $limit;
        $where = "WHERE post_author = :post_author";
        $params = [
            'start' => $start,
            'limit' => $limit,
            'post_author' => $post_author
        ];
        $string = "ORDER BY $order $order_by LIMIT";

        $sql = "SELECT *
                    FROM glampings
                    $where
                    $string
                    :start, :limit";

        return DB::run($sql, $params)->fetchAll();
    }

    public static function getPostsCount($post_status='publish')
    {
        if ($post_status) {
            $sql = "SELECT id FROM glampings WHERE post_status = :post_status";
        } else {
            $sql = "SELECT id FROM glampings";
        }
        return  DB::run($sql, ['post_status' => $post_status])->rowCount();
    }

    public static function getPostsCountLocation($post_term, $post_status='publish')
    {
        if ($post_status) {
            $sql = "SELECT id FROM glampings WHERE post_term = :post_term AND post_status = :post_status";
        } else {
            $sql = "SELECT id FROM glampings WHERE post_term = :post_term";
        }
        return  DB::run($sql, ['post_term' => $post_term, 'post_status' => $post_status])->rowCount();
    }

    public static function getPostsCountLocations($post_status='publish')
    {
        if ($post_status) {
            $sql = "SELECT post_term FROM glampings WHERE post_status = :post_status";
        } else {
            $sql = "SELECT post_term FROM glampings";
        }
        return  DB::run($sql, ['post_status' => $post_status])->fetchAll();
    }

    public static function getPostsAll()
    {
        $string = "ORDER BY post_title ASC";
        $sql = "SELECT * FROM glampings $string";
        return DB::run($sql)->fetchAll();
    }

    public static function getPostsHome($limit=8, $post_status='publish', $order='views', $order_by='DESC')
    {
        $where = "WHERE post_status = :post_status";
        $params = [
            'post_status' => $post_status,
            'limit' => $limit
        ];
        $string = "ORDER BY $order $order_by LIMIT";
        $sql = "SELECT post_title, post_url, post_thumb_img, post_price, post_meta, rating, rating_data, views
                FROM glampings
                $where
                $string
                :limit";
        return DB::run($sql, $params)->fetchAll();
    }

    public static function restapi_create(array $params): int
    {
        $sql = "INSERT INTO glampings(post_title,
                                    post_content,
                                    post_slug,
                                    post_url,
                                    post_status,
                                    post_author,
                                    post_term,
                                    post_tags,
                                    post_thumb_img,
                                    post_gallery_img,
                                    post_price,
                                    post_working,
                                    post_seo,
                                    post_meta,
                                    post_meta_acc,
                                    views,
                                    temp_data,
                                    post_date)

                                VALUES(:post_title,
                                    :post_content,
                                    :post_slug,
                                    :post_url,
                                    :post_status,
                                    :post_author,
                                    :post_term,
                                    :post_tags,
                                    :post_thumb_img,
                                    :post_gallery_img,
                                    :post_price,
                                    :post_working,
                                    :post_seo,
                                    :post_meta,
                                    :post_meta_acc,
                                    :views,
                                    :temp_data,
                                    :post_date)";

        DB::run($sql, $params);

        $sql_last_id =  DB::run("SELECT LAST_INSERT_ID() as last_id")->fetch();

        return $sql_last_id['last_id'];
    }
}
