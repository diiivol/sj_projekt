<?php

/**
 * Class Order
 *
 * This class represents an order in the system.
 */
class Order extends Database
{
    /**
     * @var PDO $db The database connection.
     */
    private $db;

    /**
     * Order constructor.
     *
     * Connects to the database.
     */
    public function __construct()
    {
        $this->db = $this->connect();
    }

    /**
     * Inserts a new order into the database.
     *
     * @param int $userId The ID of the user.
     * @param array $cartItems The items in the cart.
     * @param float $totalPrice The total price of the order.
     * @return bool True on success, false on failure.
     */

    public function insert($userId, $cartItems, $totalPrice, $name, $street, $city, $postcode): bool
    {
        try {
            // Create SQL command to insert a new order
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

            // For each item in the cart, insert a record into the order_items table
            foreach ($cartItems as $id => $quantity) {
                $sql = "INSERT INTO order_items (order_id, product_id, quantity) VALUES (:order_id, :product_id, :quantity)";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([':order_id' => $orderId, ':product_id' => $id, ':quantity' => $quantity]);
            }

            // If everything is successful, return true
            return true;
        } catch (PDOException $e) {
            // If an error occurs, return false
            $e->getMessage();
            return false;
        }
    }

    /**
     * Deletes an order from the database.
     *
     * @param int $id The ID of the order.
     * @return bool True on success, false on failure.
     */
    public function delete($id): bool
    {
        try {
            // Start the transaction
            $this->db->beginTransaction();
    
            // Delete all order items
            $query = "DELETE FROM order_items WHERE order_id = :id";
            $query_run = $this->db->prepare($query);
            $query_run->execute(['id' => $id]);
    
            // Delete the order
            $query = "DELETE FROM orders WHERE id = :id";
            $query_run = $this->db->prepare($query);
            $query_run->execute(['id' => $id]);
    
            // Commit the transaction
            $this->db->commit();
    
            return true;
        } catch (PDOException $e) {
            // If an error occurs, roll back the transaction and return false
            $this->db->rollBack();
            echo "Error: " . $e->getMessage();
    
            return false;
        }
    }

    /**
     * Selects orders from the database.
     *
     * @param int|null $userId The ID of the user. If null, selects all orders.
     * @return array|bool The orders on success, false on failure.
     */
    public function select($userId = null): array|bool
    {
        try {
            // If a user ID is specified, only get their orders
            if ($userId) {
                $sql = "SELECT * FROM orders WHERE user_id = :user_id";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([':user_id' => $userId]);
            } else {
                // Otherwise, get all orders
                $sql = "SELECT * FROM orders";
                $stmt = $this->db->query($sql);
            }
    
            // Fetch all orders
            $orders = $stmt->fetchAll(PDO::FETCH_OBJ);
    
            return $orders;
        } catch (PDOException $e) {
            // If an error occurs, return false
            echo $e->getMessage();
    
            return false;
        }
    }

    /**
     * Selects dishes in an order from the database.
     *
     * @param int $orderId The ID of the order.
     * @return array|bool The dishes on success, false on failure.
     */
    public function select_dishes($orderId): array|bool
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
     * Updates an order in the database.
     *
     * @param int $id The ID of the order.
     * @param string $newStatus The new status of the order.
     */
    public function update($id, $newStatus): void
    {
        // Create SQL command to update the order
        $sql = "UPDATE orders SET order_status = :order_status WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        // Execute the SQL command
        $stmt->execute(['order_status' => $newStatus, 'id' => $id]);
    }

    /**
     * Clears the cart.
     */
    public function clearCart(): void
    {
        // Empty the cart
        $_SESSION['cart'] = array();
    }
}
