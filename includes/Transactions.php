<?php
require_once("./includes/database.php");
require_once("./includes/Users.php");
require_once("./includes/Products.php");

class Transactions
{
    protected static $tableName = "transaction";
    public $id;
    public $user_id;
    public $product_id;
    public $date;

    public function create()
    {
        global $db;

        $data = [
            ":user_id" => $this->user_id,
            ":product_id" => $this->product_id
        ];
        $sql = "INSERT INTO " . Transactions::$tableName . "(user_id, product_id) VALUES(:user_id , :product_id)";

        return $db->query($sql, $data);
    }

    public function read()
    {
        global $db;

        $sql = "SELECT * FROM " . Transactions::$tableName . " WHERE user_id = " . $this->user_id . " AND product_id = " . $this->product_id;
        return $db->query($sql);
    }

    public function buy()
    {
        global $db;
        $product = new Products();
        $user = new Users();

        // Balance user
        $balance = $user->read($this->user_id)['balance'];

        $data = [
            ":id" => $this->user_id,
            // Balance update
            ":balance" => $balance - $product->getPrice($this->product_id)[0]
        ];


        if ($product->getPrice($this->product_id)[0] <= $balance) {
            $sql = "UPDATE users SET balance = :balance WHERE id = :id";
            if ($db->query($sql, $data)) {
                return $this->create();
            }
        } else {
            return false;
        }
    }
}
