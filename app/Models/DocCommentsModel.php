<?php

namespace App\Models;

use Hleb\Base\Model;
use Hleb\Static\DB;

class DocCommentsModel extends Model
{
    public static function create(array $params): int
    {
        $sql = "INSERT INTO doc_comments(
                    doc_order_id,
                    author,
                    content,
                    type,
                    parent,
                    attachments,
                    views)
                       VALUES(
                       :doc_order_id,
                       :author,
                       :content,
                       :type,
                       :parent,
                       :attachments,
                       :views)";

        DB::run($sql, $params);
        $sql_last_id =  DB::run("SELECT LAST_INSERT_ID() as last_id")->fetch();
        return $sql_last_id['last_id'];
    }

    public static function getCommentsOrder($doc_order_id)
    {
        $string = "ORDER BY comment_id DESC";
        $sql = "SELECT * FROM doc_comments WHERE doc_order_id = :doc_order_id $string";
        return DB::run($sql, ['doc_order_id' => $doc_order_id])->fetchAll();
    }

    public static function getCommentsOrderMess($doc_order_id)
    {
        $sql = "SELECT * FROM doc_comments WHERE doc_order_id = :doc_order_id AND type = 'comments'";
        return DB::run($sql, ['doc_order_id' => $doc_order_id])->fetchAll();
    }

    public static function getCommentOrder($comment_id)
    {
        $sql = "SELECT * FROM doc_comments WHERE comment_id = :comment_id";
        return DB::run($sql, ['comment_id' => $comment_id])->fetch();
    }

    public static function editViewsStatus($params)
    {
        $sql = "UPDATE doc_comments SET views = :views WHERE comment_id  = :comment_id";
        return DB::run($sql, $params);
    }
}
