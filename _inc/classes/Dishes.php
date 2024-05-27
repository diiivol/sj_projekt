<?php

/**
 * Class Dishes
 *
 * This class represents a collection of dishes in a database.
 */
class Dishes extends Database
{
    /**
     * @var PDO The PDO connection object.
     */
    private $db;

    /**
     * Constructor of the class, which is automatically called when an object of this class is created.
     * It establishes a connection to the database.
     */
    public function __construct()
    {
        $this->db = $this->connect();
    }

    /**
     * This method retrieves all dishes from the database.
     *
     * @return array The array of dishes.
     */
    public function select(): array
    {
        try {
            $query = $this->db->query("SELECT * FROM dishes");
            $dishes = $query->fetchAll();
            return $dishes;
        } catch (PDOException $e) {
            echo($e->getMessage());
        }
    }

    /**
     * This method deletes a dish from the database.
     *
     * @param int $id The ID of the dish to delete.
     */
    public function delete(int $id): void
    {
        try {
            $query = "DELETE FROM dishes WHERE id = :id";
            $query_run = $this->db->prepare($query);
            $query_run->execute(['id' => $id]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * This method updates a dish in the database.
     *
     * @param int $id The ID of the dish to update.
     * @param string $new_name The new name of the dish.
     * @param string $new_description The new description of the dish.
     * @param float $new_price The new price of the dish.
     * @param string $new_ingredients The new ingredients of the dish.
     */
    public function update(int $id, string $new_name, string $new_description, float $new_price, string $new_ingredients): void
    {
        $sql = "UPDATE dishes SET name = :name, description = :description, price = :price, ingredients = :ingredients WHERE id = :id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['name' => $new_name, 'description' => $new_description, 'price' => $new_price, 'ingredients' => $new_ingredients, 'id' => $id]);
    }

    /**
     * This method inserts a new dish into the database.
     * 
     * @param string $name The name of the dish.
     * @param string $description The description of the dish.
     * @param float $price The price of the dish.
     * @param string $ingredients The ingredients of the dish.
     */
    public function insert($name, $description, $price, $ingredients): void
    {
        $sql = "INSERT INTO dishes (name, description, price, ingredients) VALUES (:name, :description, :price, :ingredients)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['name' => $name, 'description' => $description, 'price' => $price, 'ingredients' => $ingredients]);
    }
}