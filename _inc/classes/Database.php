<?php

class Database
{

    private $host = '127.0.0.1';
    private $db_name = 'sj_projekt';
    private $user_name = 'root';
    private $password = '';

    /**
     * @var PDO Objekt pripojenia PDO.
     */
    protected $connection;

    public function __destruct()
    {
        $this->connection = null;
    }

    protected function connect(): PDO
    {
        try {
            $this->connection = new PDO(
                "mysql:host=" . $this->host .
                ";dbname=" . $this->db_name .
                ";charset=utf8",
                $this->user_name,
                $this->password
            );

            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

            return $this->connection;
        } catch (PDOException $e) {
            
            die("Chyba pripojenia k databáze: " . $e->getMessage());
        }
    }
}