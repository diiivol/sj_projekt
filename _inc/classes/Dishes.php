<?php

class Dishes extends Database
{
    private $db;
    // Konštruktor triedy, ktorý sa automaticky zavolá pri vytvorení objektu tejto triedy
    public function __construct()
    {
        // Pripojíme sa k databáze
        $this->db = $this->connect();
    }

    // Metóda pre získanie všetkých jedál z databázy
    public function select()
    {
        try {
            // Vytvoríme SQL príkaz pre získanie všetkých jedál
            $query = $this->db->query("SELECT * FROM dishes");
            // Získame všetky jedlá
            $dishes = $query->fetchAll();
            // Vrátime jedlá
            return $dishes;
        } catch (PDOException $e) {
            // Ak nastane chyba, vypíšeme ju
            echo($e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            // Vytvoríme SQL príkaz pre odstránenie jedla
            $query = "DELETE FROM dishes WHERE id = :id";
            // Pripravíme SQL príkaz
            $query_run = $this->db->prepare($query);
            // Vykonáme SQL príkaz
            $query_run->execute(['id' => $id]);
        } catch (PDOException $e) {
            // Ak nastane chyba, vypíšeme ju
            echo $e->getMessage();
        }
    }


    // Metóda pre aktualizáciu jedla v databáze
    public function update($id, $new_name, $new_description, $new_price, $new_ingredients)
    {
        // Vytvoríme SQL príkaz pre aktualizáciu jedla
        $sql = "UPDATE dishes SET name = :name, description = :description, price = :price, ingredients = :ingredients WHERE id = :id";
        // Pripravíme SQL príkaz
        $stmt = $this->connect()->prepare($sql);
        // Vykonáme SQL príkaz
        $stmt->execute(['name' => $new_name, 'description' => $new_description, 'price' => $new_price, 'ingredients' => $new_ingredients, 'id' => $id]);
    }

    // Metóda pre vloženie nového jedla do databázy
    public function insert()
    {
        // Získame dáta z formulára
        $name = $_POST['new_dish_name'];
        $description = $_POST['new_dish_description'];
        $price = $_POST['new_dish_price'];
        $ingredients = $_POST['new_dish_ingredients'];
        // Vytvoríme SQL príkaz pre vloženie nového jedla
        $sql = "INSERT INTO dishes (name, description, price, ingredients) VALUES (:name, :description, :price, :ingredients)";
        // Pripravíme SQL príkaz
        $stmt = $this->connect()->prepare($sql);
        // Vykonáme SQL príkaz
        $stmt->execute(['name' => $name, 'description' => $description, 'price' => $price, 'ingredients' => $ingredients]);
    }
}
