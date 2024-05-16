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



    public function delete()
    {
        try {
            $this->db->beginTransaction();

            $data = array(
                'order_id' => $_POST['delete_order']
            );

            // Удаляем элементы заказа
            $query = "DELETE FROM order_items WHERE order_id = :order_id";
            $query_run = $this->db->prepare($query);
            $query_run->execute($data);

            // Удаляем заказ
            $query = "DELETE FROM orders WHERE id = :order_id";
            $query_run = $this->db->prepare($query);
            $query_run->execute($data);

            // Завершаем транзакцию
            $this->db->commit();

            return true;
        } catch (PDOException $e) {
            // Откатываем транзакцию, если что-то пошло не так
            $this->db->rollBack();
            echo "Error: " . $e->getMessage();
            return false;
        }
    }


    public function select()
    {
        try {
            $sql = "SELECT * FROM orders";
            $stmt = $this->db->query($sql);
            $orders = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $orders;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }


    public function clearCart()
    {
        $_SESSION['cart'] = array();
    }
}
