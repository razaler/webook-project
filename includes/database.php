<?php
require_once("./includes/config.php");

class PDODatabase
{
  public $connection;
  public function __construct()
  {
    $this->openConnection();
  }

  public function openConnection()
  {
    $dsn = "mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME . ";dbcharset=" . DB_CHARSET;
    try {
      $this->connection = new PDO($dsn, DB_USER, DB_PASS);
    } catch (PDOException $ex) {
      var_dump($ex->getMessage(), (int) $ex->getCode());
      throw new PDOException($ex->getMessage(), (int) $ex->getCode());
    }
  }

  public function closeConnection()
  {
    try {
      $this->connection = null;
    } catch (PDOException $ex) {
      throw new PDOException($ex->getMessage(), (int) $ex->getCode());
    }
  }

  public function __call($name, $arguments)
  {
    if ($name == "query") {
      switch (count($arguments)) {
        case '1':
          try {
            $stmt = $this->connection->prepare($arguments[0]);
            $stmt->execute();
            $result = $stmt->fetchAll();
          } catch (PDOException $e) {
            var_dump($e->getMessage());
            $result = false;
          }
          return $result;
          break;

        case '2':
          try {
            $stmt = $this->connection->prepare($arguments[0]);
            $result = $stmt->execute($arguments[1]);
          } catch (PDOException $e) {
            var_dump($e->getMessage());
            $result = false;
          }
          return $result;
          break;
      }
    }
  }
}

$db = new PDODatabase();
