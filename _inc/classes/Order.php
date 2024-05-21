<?php
class Order extends Database
{
    private $db; // Premenná pre uchovanie pripojenia k databáze

    // Konštruktor triedy, ktorý sa automaticky zavolá pri vytvorení objektu tejto triedy
    public function __construct()
    {
        // Pripojíme sa k databáze
        $this->db = $this->connect();
    }

    // Metóda pre vytvorenie objednávky
    public function createOrder($userId, $cartItems, $totalPrice)
    {
        try {
            // Vytvoríme SQL príkaz pre vloženie novej objednávky
            $sql = "INSERT INTO orders (user_id, order_date, total_price) VALUES (:user_id, NOW(), :total_price)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':user_id' => $userId, ':total_price' => $totalPrice]);
            $orderId = $this->db->lastInsertId();
            // Pre každú položku v košíku vložíme záznam do tabuľky order_items
            foreach ($cartItems as $id => $quantity) {
                $sql = "INSERT INTO order_items (order_id, product_id, quantity) VALUES (:order_id, :product_id, :quantity)";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([':order_id' => $orderId, ':product_id' => $id, ':quantity' => $quantity]);
            }
            // Ak sa všetko podarilo, vrátime true
            return true;
        } catch (PDOException $e) {
            // Ak nastane chyba, vrátime false
            $e->getMessage();
            return false;
        }
    }

    // Metóda pre odstránenie objednávky
    public function delete($id)
    {
        try {
            // Začneme transakciu
            $this->db->beginTransaction();
            // Odstránime všetky položky objednávky
            $query = "DELETE FROM order_items WHERE order_id = :id";
            $query_run = $this->db->prepare($query);
            $query_run->execute(['id' => $id]);
            // Odstránime objednávku
            $query = "DELETE FROM orders WHERE id = :id";
            $query_run = $this->db->prepare($query);
            $query_run->execute(['id' => $id]);
            // Potvrdíme transakciu
            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            // Ak nastane chyba, vrátime transakciu späť a vrátime false
            $this->db->rollBack();
            echo "Error: " . $e->getMessage();
            return false;
        }
    }


    // Metóda pre získanie objednávok
    public function select($userId = null)
    {
        try {
            // Ak je zadané ID užívateľa, získame len jeho objednávky
            if ($userId) {
                $sql = "SELECT * FROM orders WHERE user_id = :user_id";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([':user_id' => $userId]);
            } else {
                // Inak získame všetky objednávky
                $sql = "SELECT * FROM orders";
                $stmt = $this->db->query($sql);
            }
            // Získame všetky objednávky
            $orders = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $orders;
        } catch (PDOException $e) {
            // Ak nastane chyba, vrátime false
            echo $e->getMessage();
            return false;
        }
    }

    // Metóda pre získanie jedál v objednávke
    public function select_dishes($orderId)
    {
        try {
            // Vytvoríme SQL príkaz pre získanie jedál v objednávke
            $sql = "SELECT dishes.*, order_items.quantity FROM order_items
                JOIN dishes ON order_items.product_id = dishes.id
                WHERE order_items.order_id = :order_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':order_id' => $orderId]);
            // Získame všetky jedlá v objednávke
            $items = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $items;
        } catch (PDOException $e) {
            // Ak nastane chyba, vrátime false
            echo $e->getMessage();
            return false;
        }
    }

    // Metóda pre aktualizáciu objednávky
    public function update($id, $new_status)
    {
        // Vytvoríme SQL príkaz pre aktualizáciu objednávky
        $sql = "UPDATE orders SET order_status = :order_status WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        // Vykonáme SQL príkaz
        $stmt->execute(['order_status' => $new_status, 'id' => $id]);
    }

    // Metóda pre vyprázdnenie košíka
    public function clearCart()
    {
        // Vyprázdnime košík
        $_SESSION['cart'] = array();
    }
}
