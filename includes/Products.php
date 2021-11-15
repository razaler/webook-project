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
  public $author;

  public function create()
  {
    global $db;
    $pc_extensions = ['image/jpg', 'image/jpeg', 'image/png'];
    $fl_extensions = ['application/pdf'];

    if (in_array($this->photo['type'], $pc_extensions) && in_array($this->file['type'], $fl_extensions)) {
      $pc_ext = explode('.', $this->photo['name']);
      $pc_name = "P" . uniqid() . '.' . strtolower(end($pc_ext));

      $fl_ext = explode('.', $this->file['name']);
      $fl_name = "F" . uniqid() . '.' . strtolower(end($fl_ext));
      $data = [
        ":user_id" => $this->user_id,
        ":book_title" => $this->book_title,
        ":description" => $this->description,
        ":photo" => $pc_name,
        ":price" => $this->price,
        ":file" => $fl_name,
        ":author" => $this->author
      ];
      $sql = "INSERT INTO " . Products::$tableName . "(user_id, book_title, description, photo, price, file, author) VALUES(:user_id , :book_title , :description , :photo , :price , :file, :author)";
      $result = $db->query($sql, $data);

      if ($result) {
        move_uploaded_file($this->photo['tmp_name'], './img/' . $pc_name);
        move_uploaded_file($this->file['tmp_name'], './pdf/' . $fl_name);
      }
    }
  }

  public function read()
  {
    global $db;

    $sql = "SELECT * FROM " . Products::$tableName;

    return $db->query($sql);
  }

  public function sort($type)
  {
    global $db;

    switch ($type) {
      case 'new-releases':
        $sql = "SELECT * FROM " . Products::$tableName . " ORDER BY created_at DESC";
        break;

      case 'top-commented':
        $sql = "SELECT p.id , p.book_title, p.description , p.photo , p.price, COUNT(c.product_id) as total_comments FROM products p LEFT JOIN comments c ON p.id = c.product_id GROUP BY p.id ORDER BY total_comments DESC";
        break;

      case 'top-selling':
        $sql = "SELECT p.id , p.book_title, p.description , p.photo , p.price, COUNT(t.product_id) as total_transaction FROM products p LEFT JOIN transaction t ON p.id = t.product_id GROUP BY p.id  ORDER BY total_transaction DESC";
        break;

      case 'favorite-books':
        $sql = "SELECT p.id , p.book_title, p.description , p.photo , p.price, COUNT(l.product_id) as total_likes FROM products p LEFT JOIN likes l ON p.id = l.product_id GROUP BY p.id ORDER BY total_likes DESC";
        break;

      default:
        $sql = "SELECT * FROM " . Products::$tableName;
        break;
    }
    return $db->query($sql);
  }

  public function readById($id)
  {
    global $db;

    $sql = "SELECT * FROM " . Products::$tableName . " WHERE id=" . $id;

    return $db->query($sql)[0];
  }

  public function getPrice($id)
  {
    global $db;

    $sql = "SELECT price FROM " . Products::$tableName . " WHERE id=" . $id;

    return $db->query($sql)[0];
  }
}
