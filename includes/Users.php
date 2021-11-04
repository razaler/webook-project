<?php
require_once("./includes/database.php");

class Users
{
  protected static $tableName = "users";
  public $id;
  public $first_name;
  public $last_name;
  public $email;
  public $password;
  public $balance;
  public $is_admin;
  public $create_at;
  public $update_at;

  public function create()
  {
    global $db;

    $data = [
      ":first_name" => $this->first_name,
      ":last_name" => $this->last_name,
      ":email" => $this->email,
      ":password" => password_hash($this->password, PASSWORD_DEFAULT)
    ];
    $sql = "INSERT INTO " . Users::$tableName . "(first_name, last_name, email, password) VALUES(:first_name , :last_name , :email , :password)";

    return $db->query($sql, $data);
  }

  public function read($id)
  {
    global $db;
    $sql = "SELECT * FROM " . Users::$tableName . " WHERE id = " . $id;
    return $db->query($sql)[0];
  }

  public function update()
  {
    global $db;

    $hash = $this->read($this->id)['password'];

    $data = [
      ":first_name" => $this->first_name,
      ":last_name" => $this->last_name,
      ":password" => password_hash($this->password, PASSWORD_DEFAULT),
    ];

    if (password_verify($this->password, $hash)) {
      $sql = "UPDATE " . Users::$tableName .  " SET first_name = :first_name , last_name = :last_name , password = :password";
      return $db->query($sql, $data);
    } else {
      return false;
    }
  }

  public function TopUp()
  {
    global $db;

    // Balance user
    $balance = $this->read($this->id)['balance'];

    $data = [
      ":id" => $this->id,
      // Balance update
      ":balance" => $balance + 50000
    ];
    $sql = "UPDATE " . Users::$tableName .  " SET balance = :balance WHERE id = :id";
    if ($db->query($sql, $data)) {
      return $this->read($this->id)["balance"];
    } else {
      return false;
    }
  }

  public function delete($id)
  {
    global $db;

    $data = [":id" => $id];

    $sql = "DELETE FROM " . Users::$tableName . " WHERE id = :id";
    return $db->query($sql, $data);
  }

  public function signin()
  {
    global $db;
    $sql = 'SELECT * FROM users WHERE email = "' . $this->email . '"';
    if ($db->query($sql)) {
      $result = $db->query($sql)[0];
      $hash = $result['password'];
      if (password_verify($this->password, $hash)) {
        return $result;
      }
    }
    return false;
  }

  public function changePassword($pass, $hash)
  {
    global $db;
    $data = [
      ":id" => $this->id,
      ":password" => password_hash($this->password, PASSWORD_DEFAULT)
    ];

    if (password_verify($pass, $hash)) {
      $sql = "UPDATE " . Users::$tableName .  " SET password = :password WHERE id = :id";
      return $db->query($sql, $data);
    } else {
      return false;
    }
  }
}
