<?php

/**
 * Trieda Dishes
 *
 * Táto trieda reprezentuje kolekciu jedál v databáze.
 */
class Dishes extends Database
{
    /**
     * @var PDO Objekt pripojenia PDO.
     */
    private $db;

    /**
     * Konštruktor triedy, ktorý sa automaticky zavolá pri vytvorení objektu tejto triedy.
     * Nadväzuje spojenie s databázou.
     */
    public function __construct()
    {
        $this->db = $this->connect();
    }

    /**
     * Táto metóda získava všetky jedlá z databázy.
     *
     * @return array Pole jedál.
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
     * Táto metóda odstraňuje jedlo z databázy.
     *
     * @param int $id ID jedla na odstránenie.
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
     * Táto metóda aktualizuje jedlo v databáze.
     *
     * @param int $id ID jedla na aktualizáciu.
     * @param string $new_name Nové meno jedla.
     * @param string $new_description Nový popis jedla.
     * @param float $new_price Nová cena jedla.
     * @param string $new_ingredients Nové ingrediencie jedla.
     */
    public function update(int $id, string $new_image, string $new_name, string $new_description, float $new_price, string $new_ingredients): void
    {
        try {
            $sql = "UPDATE dishes SET image = :image, name = :name, description = :description, price = :price, ingredients = :ingredients WHERE id = :id";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute(['image' => $new_image, 'name' => $new_name, 'description' => $new_description, 'price' => $new_price, 'ingredients' => $new_ingredients, 'id' => $id]);
        } catch (PDOException $e) {
            echo $e->getMessage();       }
    }

    /**
     * Táto metóda vkladá nové jedlo do databázy.
     * 
     * @param string $name Meno jedla.
     * @param string $description Popis jedla.
     * @param float $price Cena jedla.
     * @param string $ingredients Ingrediencie jedla.
     */
    public function insert($image, $name, $description, $price, $ingredients): void
    {
        $sql = "INSERT INTO dishes (image, name, description, price, ingredients) VALUES (:image, :name, :description, :price, :ingredients)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['image' => $image, 'name' => $name, 'description' => $description, 'price' => $price, 'ingredients' => $ingredients]);
    }
}