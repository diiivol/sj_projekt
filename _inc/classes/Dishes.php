<?php

class Dishes extends Database
{
    /**
     * @var PDO Objekt pripojenia PDO.
     */
    private $db;


    public function __construct()
    {
        $this->db = $this->connect();
    }

    /**
     * Vssetky jedla z databazy.
     */
    public function select(): array
    {
        try {
            $query = $this->db->query("SELECT * FROM dishes");
            $dishes = $query->fetchAll();
            return $dishes;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Odstraňenie jedla z databázy.
     *
     * $id - ID JEDLA NA ODSTRANENIE 
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
     * Aktualizacia jedla v databáze.
     *
     * $id - ID JEDLA NA AKTUALIZACIU
     * $new_name - NOVY NAZOV JEDLA
     * $new_description - NOVY POPIS JEDLA
     * $new_price - NOVA CENA JEDLA
     * $new_ingredients - NOVE INGREDIENCIE JEDLA
     */
    public function update(int $id, string $new_image, string $new_name, string $new_description, float $new_price, string $new_ingredients): void
    {
        try {
            $sql = "UPDATE dishes SET image = :image, name = :name, description = :description, price = :price, ingredients = :ingredients WHERE id = :id";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute(['image' => $new_image, 'name' => $new_name, 'description' => $new_description, 'price' => $new_price, 'ingredients' => $new_ingredients, 'id' => $id]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Vkladanie jedla do databázy.
     * 
     * $image - OBRAZOK JEDLA
     * $name - MENO JEDLA
     * $description - POPIS JEDLA
     * $price - CENA JEDLA
     * $ingredients - INGREDIENCIE JEDLA
     */
    public function insert(string $image, string $name, string $description, float $price, string $ingredients): void
    {
        try {
            $sql = "INSERT INTO dishes (image, name, description, price, ingredients) VALUES (:image, :name, :description, :price, :ingredients)";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute(['image' => $image, 'name' => $name, 'description' => $description, 'price' => $price, 'ingredients' => $ingredients]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}