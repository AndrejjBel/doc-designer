<?php

namespace App\Models;

use Hleb\Base\Model;
use Hleb\Static\DB;

class PostModel extends Model
{
    public static function create(array $params): int
    {
        $sql = "INSERT INTO posts(post_title,
                                    post_slug,
                                    post_url,
                                    post_type,
                                    post_status,
                                    post_author_id,
                                    post_content,
                                    post_term,
                                    post_tags,
                                    post_thumb_img,
                                    post_gallery_img,
                                    post_price,
                                    shop_id,
                                    post_meta_title,
                                    post_meta_description,
                                    post_meta_keywords)

                                VALUES(:post_title,
                                    :post_slug,
                                    :post_url,
                                    :post_type,
                                    :post_status,
                                    :post_author_id,
                                    :post_content,
                                    :post_term,
                                    :post_tags,
                                    :post_thumb_img,
                                    :post_gallery_img,
                                    :post_price,
                                    :shop_id,
                                    :post_meta_title,
                                    :post_meta_description,
                                    :post_meta_keywords)";

        DB::run($sql, $params);

        $sql_last_id =  DB::run("SELECT LAST_INSERT_ID() as last_id")->fetch();

        return $sql_last_id['last_id'];
    }

    public static function edit($params)
    {
        $sql = "UPDATE posts SET
                post_title               = :post_title,
                post_status              = :post_status,
                post_content             = :post_content,
                post_term                = :post_term,
                post_tags                = :post_tags,
                post_thumb_img           = :post_thumb_img,
                post_gallery_img         = :post_gallery_img,
                post_price               = :post_price,
                shop_id                  = :shop_id,
                post_meta_title          = :post_meta_title,
                post_meta_description    = :post_meta_description,
                post_meta_keywords       = :post_meta_keywords
                        WHERE post_id    = :post_id";

        return DB::run($sql, $params);
    }

    public static function getPostsUser(int $post_author_id, $post_status='published')
    {
        if ($post_status) {
            $sql = "SELECT * FROM posts WHERE post_author_id = :post_author_id AND post_status = :post_status";
            return DB::run($sql, ['post_author_id' => $post_author_id, 'post_status' => $post_status])->fetchAll();
        } else {
            $sql = "SELECT * FROM posts WHERE post_author_id = :post_author_id";
            return DB::run($sql, ['post_author_id' => $post_author_id])->fetchAll();
        }
    }

    public static function getPostForSlug($post_slug)
    {
        $sql = "SELECT * FROM posts WHERE post_slug = :post_slug";
        return DB::run($sql, ['post_slug' => $post_slug])->fetchAll();
    }

    public static function getPostForId($post_id)
    {
        $sql = "SELECT * FROM posts WHERE post_id = :post_id";
        return DB::run($sql, ['post_id' => $post_id])->fetch();
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
                        FROM posts
                           WHERE post_id IN(" . $posts . ") AND post_status = 'published'";
        return DB::run($sql)->fetchAll();
    }

    public static function getPosts($page, $limit, $order, $order_by, $post_type, $post_status='published')
    {
        $start = ($page - 1) * $limit;
        $where = "WHERE post_type = :post_type AND post_status = :post_status";
        $params = [
            'start' => $start,
            'limit' => $limit,
            'post_type' => $post_type,
            'post_status' => $post_status
        ];
        if (!$post_status) {
            $where = "WHERE post_type = :post_type";
            $params = [
                'start' => $start,
                'limit' => $limit,
                'post_type' => $post_type
            ];
        }
        $string = "ORDER BY $order $order_by LIMIT";

        $sql = "SELECT *
                    FROM posts
                    $where
                    $string
                    :start, :limit";

        return DB::run($sql, $params)->fetchAll();
    }

    public static function getPostsCount($post_type, $post_status='published')
    {
        $sql = "SELECT post_id FROM posts WHERE post_type = :post_type AND post_status = :post_status";
        return  DB::run($sql, ['post_type' => $post_type, 'post_status' => $post_status])->rowCount();
    }
}
