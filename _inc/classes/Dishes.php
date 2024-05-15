
<?php

class Dishes extends Database {
    private $db;

    public function __construct(){
        $this->db = $this->connect();
    }

    public function select(){
        try{
            $query =  $this->db->query("SELECT * FROM dishes");
            $dishes = $query->fetchAll();
            return $dishes;
          }catch(PDOException $e){
            echo($e->getMessage());
        }   
    }

    public function delete(){
        try{
            $data = array(
                'dishes_id' => $_POST['delete_dishes']
            );
            $query = "DELETE FROM dishes WHERE id = :dishes_id";
            $query_run = $this->db->prepare($query);
            $query_run->execute($data);
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }


}

?>