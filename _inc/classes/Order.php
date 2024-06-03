<?php

class Order extends Database
{
    /**
     * @var PDO $db Pripojenie k databáze.
     */
    private $db;

    public function __construct()
    {
        $this->db = $this->connect();
    }

    /**
     * Vloží novú objednávku do databázy.
     *
     * $userId - ID POUZIVATELA
     * $cartItems - POLOZKY V KOSIKU
     * $totalPrice - CELKOVA CENA OBJEDNAVKY
     */
    public function insert(int $userId, array $cartItems, float $totalPrice, string $name, string $street, string $city, string $postcode): void
    {
        try {
            
            $sql = "INSERT INTO orders (user_id, order_date, total_price, name, street, city, postcode) VALUES (:user_id, NOW(), :total_price, :name, :street, :city, :postcode)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':user_id' => $userId,
                ':total_price' => $totalPrice,
                ':name' => $name,
                ':street' => $street,
                ':city' => $city,
                ':postcode' => $postcode
            ]);
            $orderId = $this->db->lastInsertId();

            foreach ($cartItems as $id => $quantity) {
                $sql = "INSERT INTO order_items (order_id, product_id, quantity) VALUES (:order_id, :product_id, :quantity)";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([':order_id' => $orderId, ':product_id' => $id, ':quantity' => $quantity]);
            }

        } catch (PDOException $e) {
            
            echo $e->getMessage();
            
        }
    }

    /**
     * Odstráni objednávku z databázy.
     *
     * $id - ID objednávky.
     */
    public function delete(int $id): bool
    {
        try {
            // Začnite transakciu
            $this->db->beginTransaction();
    
            // Odstráňte všetky položky objednávky
            $query = "DELETE FROM order_items WHERE order_id = :id";
            $query_run = $this->db->prepare($query);
            $query_run->execute(['id' => $id]);
    
            // Odstráňte objednávku
            $query = "DELETE FROM orders WHERE id = :id";
            $query_run = $this->db->prepare($query);
            $query_run->execute(['id' => $id]);
    
            // Potvrďte transakciu
            $this->db->commit();
    
            return true;
        } catch (PDOException $e) {
            // Ak sa vyskytne chyba, vráti transakciu späť a vráti false
            $this->db->rollBack();
            echo $e->getMessage();
    
            return false;
        }
    }

    /**
     * Vyberie objednávky z databázy.
     *
     * $userId - ID používateľa. Ak je null, vyberie všetky objednávky.
     */
    public function select(int $userId = null): array
    {
        try {
            // Ak je špecifikované ID používateľa, získajte len ich objednávky
            if ($userId) {
                $sql = "SELECT * FROM orders WHERE user_id = :user_id";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([':user_id' => $userId]);
            } else {
                // Inak získajte všetky objednávky
                $sql = "SELECT * FROM orders";
                $stmt = $this->db->query($sql);
            }
    

            $orders = $stmt->fetchAll(PDO::FETCH_OBJ);
    
            return $orders;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Vyberie jedlá v objednávke z databázy.
     *
     * $orderId - ID objednávky.
     */
    public function select_dishes(int $orderId): array
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

            echo $e->getMessage();
        }
    }

    /**
     * Aktualizuje objednávku v databáze.
     *
     * $id - ID objednávky.
     * $newStatus - Nový stav objednávky
     */
    public function update(int $id, string $newStatus): void
    {
        try {
            $sql = "UPDATE orders SET order_status = :order_status WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['order_status' => $newStatus, 'id' => $id]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    // Vyprázdniť košík
    public function clearCart(): void
    {
        $_SESSION['cart'] = array();
    }
}
