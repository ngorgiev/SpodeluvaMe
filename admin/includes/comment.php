<?php
class Comment extends Db_object
{
    protected static $db_table = "comments";
    protected static $db_table_fields = array('id', 'photo_id', 'author', 'body', 'date_time');

    public $id;
    public $photo_id;
    public $author;
    public $body;
    public $date_time;

    public static function create_comment($photo_id, $author = "Непознат", $body="")
    {
        if(!empty($photo_id) && !empty($author) && !empty($body))
        {
            $comment = new Comment();

            $comment->photo_id   = $photo_id;
            $comment->author     = $author;
            $comment->body       = $body;
            $comment->date_time = date('d-m-y h:m:s');

            return $comment;
        }
        else
        {
            return false;
        }
    }

    public static function find_comments_by_photo_id($photo_id = 0)
    {
        global $database;
        $sql = "SELECT * FROM " . self::$db_table;
        $sql .= " WHERE photo_id = " . $database->escape_string($photo_id);
        $sql .= " ORDER BY photo_id ASC";

        return self::find_by_query($sql);
    }
}//End of Class
?>

