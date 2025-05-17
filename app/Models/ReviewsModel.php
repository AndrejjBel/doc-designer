<?php

namespace App\Models;

use Hleb\Base\Model;
use Hleb\Static\DB;

class ReviewsModel extends Model
{
    public static function create(array $params): int
    {
        $sql = "INSERT INTO reviews(post_parent,
                                    post_title,
                                    post_content,
                                    post_slug,
                                    post_url,
                                    post_status,
                                    post_author,
                                    post_gallery_img,
                                    post_meta,
                                    post_rating)

                                VALUES(:post_parent,
                                    :post_title,
                                    :post_content,
                                    :post_slug,
                                    :post_url,
                                    :post_status,
                                    :post_author,
                                    :post_gallery_img,
                                    :post_meta,
                                    :post_rating)";

        DB::run($sql, $params);

        $sql_last_id =  DB::run("SELECT LAST_INSERT_ID() as last_id")->fetch();

        return $sql_last_id['last_id'];
    }

    public static function create_rest(array $params): int
    {
        $sql = "INSERT INTO reviews(post_parent,
                                    post_title,
                                    post_content,
                                    post_slug,
                                    post_url,
                                    post_status,
                                    post_author,
                                    post_gallery_img,
                                    post_meta,
                                    post_rating,
                                    post_date,
                                    post_modified)

                                VALUES(:post_parent,
                                    :post_title,
                                    :post_content,
                                    :post_slug,
                                    :post_url,
                                    :post_status,
                                    :post_author,
                                    :post_gallery_img,
                                    :post_meta,
                                    :post_rating,
                                    :post_date,
                                    :post_modified)";

        DB::run($sql, $params);

        $sql_last_id =  DB::run("SELECT LAST_INSERT_ID() as last_id")->fetch();

        return $sql_last_id['last_id'];
    }

    public static function edit($params)
    {
        $sql = "UPDATE reviews SET
                post_parent      = :post_parent,
                post_title       = :post_title,
                post_content     = :post_content,
                post_status      = :post_status,
                post_author      = :post_author,
                post_gallery_img = :post_gallery_img,
                post_meta        = :post_meta,
                post_rating      = :post_rating

                WHERE id    = :id";

        return DB::run($sql, $params);
    }

    public static function editGallery($params)
    {
        $sql = "UPDATE reviews SET post_gallery_img = :post_gallery_img WHERE id = :id";
        return DB::run($sql, $params);
    }

    public static function editStatus($params)
    {
        $sql = "UPDATE reviews SET post_status = :post_status WHERE id = :id";
        return DB::run($sql, $params);
    }

    public static function getPostsUser(int $post_author, $post_status='published')
    {
        if ($post_status) {
            $sql = "SELECT * FROM reviews WHERE post_author = :post_author AND post_status = :post_status";
            return DB::run($sql, ['post_author' => $post_author, 'post_status' => $post_status])->fetchAll();
        } else {
            $sql = "SELECT * FROM reviews WHERE post_author = :post_author";
            return DB::run($sql, ['post_author' => $post_author])->fetchAll();
        }
    }

    public static function getPostForSlug($post_slug)
    {
        $sql = "SELECT * FROM reviews WHERE post_slug = :post_slug";
        return DB::run($sql, ['post_slug' => $post_slug])->fetchAll();
    }

    public static function getPostForId($post_id)
    {
        $sql = "SELECT * FROM reviews WHERE id = :id";
        return DB::run($sql, ['id' => $post_id])->fetch();
    }

    public static function getPostsForId(string|null $posts)
    {
        if (empty($posts)) return false;
        $sql = "SELECT
                    id,
                    post_title,
                    post_url,
                    post_thumb_img
                        FROM reviews
                           WHERE id IN(" . $posts . ") AND post_status = 'published'";
        return DB::run($sql)->fetchAll();
    }

    public static function getPosts($page, $limit, $order, $order_by, $post_status='published')
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
                    FROM reviews
                    $where
                    $string
                    :start, :limit";

        return DB::run($sql, $params)->fetchAll();
    }

    public static function getPostsHome($limit=20)
    {
        $string = "ORDER BY post_date DESC LIMIT";
        $params = [
            'limit' => $limit
        ];
        $sql = "SELECT
                    post_parent,
                    post_content,
                    post_meta,
                    post_rating,
                    post_date
                        FROM reviews
                           $string
                           :limit";
        return DB::run($sql, $params)->fetchAll();
    }

    public static function getPostsCount($post_status='published')
    {
        if ($post_status) {
            $sql = "SELECT id FROM reviews WHERE post_status = :post_status";
        } else {
            $sql = "SELECT id FROM reviews";
        }
        return  DB::run($sql, ['post_status' => $post_status])->rowCount();
    }
}
