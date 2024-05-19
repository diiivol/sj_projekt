<?php
class Order extends Database
{
    private $db;
    public function __construct()
    {
        $this->db = $this->connect();
    }
    public function createOrder($userId, $cartItems, $totalPrice)
    {
        try {
            $sql = "INSERT INTO orders (user_id, order_date, total_price) VALUES (:user_id, NOW(), :total_price)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':user_id' => $userId, ':total_price' => $totalPrice]);
            $orderId = $this->db->lastInsertId();
            foreach ($cartItems as $id => $quantity) {
                $sql = "INSERT INTO order_items (order_id, product_id, quantity) VALUES (:order_id, :product_id, :quantity)";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([':order_id' => $orderId, ':product_id' => $id, ':quantity' => $quantity]);
            }
            return true;
        } catch (PDOException $e) {
            $e->getMessage();
            return false;
        }
    }
    public function delete()
    {
        try {
            $this->db->beginTransaction();
            $data = array(
                'order_id' => $_POST['delete_order'],
            );
            $query = "DELETE FROM order_items WHERE order_id = :order_id";
            $query_run = $this->db->prepare($query);
            $query_run->execute($data);
            $query = "DELETE FROM orders WHERE id = :order_id";
            $query_run = $this->db->prepare($query);
            $query_run->execute($data);
            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    public function select($userId = null)
    {
        try {
            if ($userId) {
                $sql = "SELECT * FROM orders WHERE user_id = :user_id";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([':user_id' => $userId]);
            } else {
                $sql = "SELECT * FROM orders";
                $stmt = $this->db->query($sql);
            }
            $orders = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $orders;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    public function select_dishes($orderId)
    {
        try {
            $sql = "SELECT dishes.*, order_items.quantity FROM order_items
                JOIN dishes ON order_items.product_id = dishes.id
                WHERE order_items.order_id = :order_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':order_id' => $orderId]);
            $items = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $items;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    public function update()
    {
        $id = $_POST['update_order'];
        $new_status = $_POST['order_status'];
        $sql = "UPDATE orders SET order_status = :order_status WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['order_status' => $new_status, 'id' => $id]);
    }
    public function clearCart()
    {
        $_SESSION['cart'] = array();
    }
}
