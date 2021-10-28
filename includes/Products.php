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
  }

  public function update()
  {
  }

  public function delete()
  {
    # code...
  }
}
