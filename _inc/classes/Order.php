<?php

class Order extends Database
{
    private $db;

    public function __construct()
    {
        $this->db = $this->connect();
    }

    public function createOrder($userId, $cartItems)
    {
        try {
            //  orders
            $sql = "INSERT INTO orders (user_id, order_date) VALUES (:user_id, NOW())";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':user_id' => $userId]);

            // ID 
            $orderId = $this->db->lastInsertId();

            // 
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

    public function clearCart() {
        $_SESSION['cart'] = array();
    }
}