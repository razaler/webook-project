<?php
require_once("./includes/database.php");

class Products
{
  protected static $tableName = "products";
  public $id;
  public $user_id;
  public $book_title;
  public $description;
  public $photo;
  public $price;
  public $file;
  public $create_at;
  public $update_at;

  public function create()
  {
    global $db;

    $data = [
      ":user_id" => $this->user_id,
      ":book_title" => $this->book_title,
      ":description" => $this->description,
      ":photo" => $this->photo,
      ":price" => $this->price,
      ":file" => $this->file,
    ];

    $sql = "INSERT INTO " . Products::$tableName . "(user_id, book_title, description, photo, price, file) VALUES(:user_id , :book_title , :description , :photo , :price , :file)";

    return $db->query($sql, $data);
  }

  public function read()
  {
    global $db;

    $sql = "SELECT * FROM " . Products::$tableName;

    return $db->query($sql);
  }

  public function readById($id)
  {
    global $db;

    $sql = "SELECT * FROM " . Products::$tableName . " WHERE id=" . $id;

    return $db->query($sql)[0];
  }

  public function update()
  {
  }

  public function delete()
  {
    # code...
  }
}
