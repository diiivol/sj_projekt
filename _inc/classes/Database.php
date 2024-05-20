<?php
class Database
{
    private $host = '127.0.0.1'; // Host databázy
    private $db_name = 'sj_projekt'; // Názov databázy
    private $user_name = 'root'; // Užívateľské meno pre prístup k databáze
    private $password = ''; // Heslo pre prístup k databáze
    protected $connection; // Premenná pre uchovanie pripojenia k databáze

    public function __destruct()
    {
        // Uzatvorenie spojenia s databázou pri zničení objektu
        $this->connection = null;
    }

    protected function connect()
    {
        try {
            // Vytvorenie nového PDO objektu pre pripojenie k databáze
            $this->connection = new PDO(
                "mysql:host=" . $this->host .
                ";dbname=" . $this->db_name .
                ";charset=utf8",
                $this->user_name,
                $this->password
            );
            // Nastavenie režimu chybových hlásení na WARNING
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            // Nastavenie predvoleného spôsobu načítania dát na objekt
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            // Vrátenie pripojenia k databáze
            return $this->connection;
        } catch (PDOException $e) {
            // V prípade chyby pri pripojení k databáze ukončíme skript a vypíšeme chybovú správu
            die("Chyba pripojenia k databáze: " . $e->getMessage());
        }
    }
}
