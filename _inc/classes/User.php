<?php

    class User extends Database{
        
        private $db;

        public function __construct()
        {
            $this->db = $this->connect();
        }

        public function login($username, $password){
            //$username a $password došli z $_POST 
            try{
                $data = array(
                    'user_email'=>$username,
                    'user_password'=>$password,
                );
                
                $sql = "SELECT * FROM user WHERE email = :user_email AND password = :user_password";
                $query_run = $this->db->prepare($sql);
                $query_run->execute($data);
                if($query_run->rowCount() == 1) {
                    // login je uspesny
                    $_SESSION['logged_in'] = true;

                    $user = $query_run->fetch(PDO::FETCH_ASSOC);
                    $_SESSION['user_role'] = $user['role'];
                    
                    return true;
                } else {
                    return false;
                }
            }catch(PDOException $e){
                    echo $e->getMessage();
            }
        }

    }

?>