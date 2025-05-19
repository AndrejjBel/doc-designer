<?php

namespace App\Models;

use Hleb\Base\Model;
use Hleb\Static\DB;

class FileModel extends Model
{
    public static function set($params): int
    {
        $sql = "INSERT INTO files(
                    file_path,
                    file_url,
                    file_type,
                    file_mime_type,
                    file_post_id,
                    file_author_id)
                       VALUES(
                       :file_path,
                       :file_url,
                       :file_type,
                       :file_mime_type,
                       :file_post_id,
                       :file_author_id)";

        DB::run($sql, $params);

        $sql_last_id =  DB::run("SELECT LAST_INSERT_ID() as last_id")->fetch();

        return $sql_last_id['last_id'];
    }

    public static function edit($file_id, $file_type)
    {
        $sql = "UPDATE files SET file_type = :file_type WHERE id = :id";
        return DB::run($sql, ['id' => $file_id, 'file_type' => $file_type]);
    }

    public static function delete($file_id)
    {
        $sql = "DELETE FROM files WHERE id = :id";
        return DB::run($sql, ['id' => $file_id]);
    }

    public static function getFile($post_id)
    {
        $sql = "SELECT * FROM files WHERE id = :id";
        return DB::run($sql, ['id' => $post_id])->fetchAll();
    }
}
