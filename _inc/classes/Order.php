<?php

/**
 * Trieda Order
 *
 * Táto trieda reprezentuje objednávku v systéme.
 */
class Order extends Database
{
    /**
     * @var PDO $db Pripojenie k databáze.
     */
    private $db;

    /**
     * Konštruktor Order.
     *
     * Pripája sa k databáze.
     */
    public function __construct()
    {
        $this->db = $this->connect();
    }

    /**
     * Vloží novú objednávku do databázy.
     *
     * @param int $userId ID používateľa.
     * @param array $cartItems Položky v košíku.
     * @param float $totalPrice Celková cena objednávky.
     * @return bool True pri úspechu, false pri neúspechu.
     */
    public function insert(int $userId, array $cartItems, float $totalPrice, string $name, string $street, string $city, string $postcode): bool
    {
        try {
            // Vytvorte príkaz SQL na vloženie novej objednávky
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

            // Pre každú položku v košíku vložte záznam do tabuľky order_items
            foreach ($cartItems as $id => $quantity) {
                $sql = "INSERT INTO order_items (order_id, product_id, quantity) VALUES (:order_id, :product_id, :quantity)";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([':order_id' => $orderId, ':product_id' => $id, ':quantity' => $quantity]);
            }

            // Ak je všetko úspešné, vráti true
            return true;
        } catch (PDOException $e) {
            // Ak sa vyskytne chyba, vráti false
            $e->getMessage();
            return false;
        }
    }

    /**
     * Odstráni objednávku z databázy.
     *
     * @param int $id ID objednávky.
     * @return bool True pri úspechu, false pri neúspechu.
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
            echo "Chyba: " . $e->getMessage();
    
            return false;
        }
    }

    /**
     * Vyberie objednávky z databázy.
     *
     * @param int|null $userId ID používateľa. Ak je null, vyberie všetky objednávky.
     * @return array|bool Objednávky pri úspechu, false pri zlyhaní.
     */
    public function select(int $userId = null): array|bool
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
    
            // Získajte všetky objednávky
            $orders = $stmt->fetchAll(PDO::FETCH_OBJ);
    
            return $orders;
        } catch (PDOException $e) {
            // Ak nastane chyba, vráťte false
            echo $e->getMessage();
    
            return false;
        }
    }

    /**
     * Vyberie jedlá v objednávke z databázy.
     *
     * @param int $orderId ID objednávky.
     * @return array|bool Jedlá pri úspechu, false pri zlyhaní.
     */
    public function select_dishes(int $orderId): array|bool
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

    /**
     * Aktualizuje objednávku v databáze.
     *
     * @param int $id ID objednávky.
     * @param string $newStatus Nový stav objednávky.
     */
    public function update(int $id, string $newStatus): void
    {
        // Vytvorte SQL príkaz na aktualizáciu objednávky
        $sql = "UPDATE orders SET order_status = :order_status WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        // Vykonajte SQL príkaz
        $stmt->execute(['order_status' => $newStatus, 'id' => $id]);
    }

    /**
     * Vyprázdni košík.
     */
    public function clearCart(): void
    {
        // Vyprázdniť košík
        $_SESSION['cart'] = array();
    }
}
