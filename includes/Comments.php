<?php
require_once("./includes/database.php");

class Comments
{
    protected static $tableName = "comments";
    public $id;
    public $user_id;
    public $product_id;
    public $comment;
    public $create_at;

    public function create()
    {
        global $db;

        $data = [
            ":user_id" => $this->user_id,
            ":comment" => $this->comment,
            ":product_id" => $this->product_id,
        ];

        $sql = "INSERT INTO " . Comments::$tableName . "(user_id, product_id, comment) VALUES(:user_id , :product_id , :comment)";

        return $db->query($sql, $data);
    }

    public function read($id)
    {
        global $db;
        $sql = "SELECT * FROM " . Comments::$tableName . " WHERE product_id = " . $id;
        return $db->query($sql);
    }
}
