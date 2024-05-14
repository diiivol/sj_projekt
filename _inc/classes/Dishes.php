
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

}

?>