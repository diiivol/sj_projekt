<?php

    class Contact extends Database{

        private $db;

        public function __construct()
        {
            $this->db = $this->connect();
        }

        function insert(){
            if($this->db){
            //  echo 'máme spojenie';
            }
            if(isset($_POST['contact_submitted'])){
              //  echo 'Form bol odoslany';
               
               $data = array('contact_name'=>$_POST['name'],
               'contact_email'=>$_POST['email'],
               //'contact_message'=>$_POST['message'],
               'contact_message'=>filter_var($_POST['message'],FILTER_SANITIZE_FULL_SPECIAL_CHARS),
               'contact_acceptance'=>$_POST['acceptance'],
               );

               try{
                 $query = "INSERT INTO contact (name, email, message, acceptance) VALUES 
                 (:contact_name, :contact_email, :contact_message, :contact_acceptance)";
                 $query_run = $this->db->prepare($query);
                 $query_run->execute($data);  

               }catch(PDOException $e){
                 $e->getMessage();
               }              
           }else{
             echo 'Post nebol vykonaný';
           }
        
        }
        public function select(){
          try{
            $sql = "SELECT * FROM contact";
            $query =  $this->db->query($sql);
            $contacts = $query->fetchAll();
            return $contacts;
          }catch(PDOException $e){
            echo($e->getMessage());
          }
        }

        public function delete(){

          try {
            $data = array(
                'contact_id' => $_POST['delete_contact']
            );
            $query = "DELETE FROM contact WHERE id = :contact_id";
            $query_run = $this->db->prepare($query);
            $query_run->execute($data);
          }catch (PDOException $e) {
            echo $e->getMessage();
          }
        }
    }
?>