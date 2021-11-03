<?php
require_once("./includes/database.php");

class Like
{
    protected static $namatable = "likes";
    public $id;
    public $user_id;
    public $product_id;
    public $created_at;
    public $updated_at;

    public function create()
    {
        //fungsi untuk register
        global $db;
        $hasil = 0;
        $conn = $db->connection;
        $data = [
            'user_id' => $this->user_id,
            'product_id' => $this->product_id
        ];
        $sql = "INSERT INTO " . self::$namatable . " (user_id, product_id)";
        $sql .= " VALUES (:user_id, :product_id)";
        try {
            $stmt = $conn->prepare($sql);
            $stmt->execute($data);
            $hasil = $conn->lastInsertId();
        } catch (Exception $e) {
            $hasil = 0;
        }
        return $hasil;
    }

    public function isLiked()
    {
        global $db;
        $sql = "SELECT * FROM likes WHERE user_id = " . $this->user_id . " AND product_id = " . $this->product_id;

        return isset($db->query($sql)[0]);
    }

    //update tidak ada langsung dihapus
    public function hapus()
    {
        global $db;
        $hasil = 0;
        $conn = $db->connection;
        $data = [
            'user_id' => $this->user_id,
            'product_id' => $this->product_id
        ];
        $sql = "DELETE FROM " . self::$namatable;
        $sql .= " WHERE user_id=:user_id AND product_id=:product_id";
        try {
            $stmt = $conn->prepare($sql);
            $hasil = $stmt->execute($data);
        } catch (Exception $e) {
            $hasil = 0;
        }
        return $hasil;
    }

    public static function totallike($pid)
    {
        global $db;
        $hasil = 0;
        $conn = $db->connection;
        $data = [
            'pid' => $pid
        ];
        $sql = "SELECT COUNT(*) AS num FROM " . self::$namatable;
        $sql .= " WHERE product_id=:pid";
        try {
            $stmt = $conn->prepare($sql);
            $stmt->execute($data);
            $result = $stmt->fetch();
            $hasil = $result['num'];
        } catch (Exception $e) {
            $hasil = 0;
        }
        return $hasil;
    }
}
