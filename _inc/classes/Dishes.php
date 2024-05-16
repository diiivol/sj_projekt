<?php

class Dishes extends Database
{
    private $db;

    public function __construct()
    {
        $this->db = $this->connect();
    }

    public function select()
    {
        try {
            $query = $this->db->query("SELECT * FROM dishes");
            $dishes = $query->fetchAll();
            return $dishes;
        } catch (PDOException $e) {
            echo ($e->getMessage());
        }
    }

    public function delete()
    {
        try {
            $data = array(
                'dishes_id' => $_POST['delete_dishes']
            );
            $query = "DELETE FROM dishes WHERE id = :dishes_id";
            $query_run = $this->db->prepare($query);
            $query_run->execute($data);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }



    public function update()
    {
        $id = $_POST['update_dishes'];
        $new_name = $_POST['new_dish_name'];
        $new_description = $_POST['new_dish_description'];

        $sql = "UPDATE dishes SET name = :name, description = :description WHERE id = :id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['name' => $new_name, 'description' => $new_description, 'id' => $id]);
    }
}
