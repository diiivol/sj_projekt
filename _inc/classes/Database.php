<?php

/**
 * Trieda Database
 *
 * Táto trieda reprezentuje pripojenie k databáze.
 */
class Database
{
    /**
     * @var string Hostiteľ databázy.
     */
    private $host = '127.0.0.1';

    /**
     * @var string Názov databázy.
     */
    private $db_name = 'sj_projekt';

    /**
     * @var string Užívateľské meno pre pripojenie k databáze.
     */
    private $user_name = 'root';

    /**
     * @var string Heslo pre pripojenie k databáze.
     */
    private $password = '';

    /**
     * @var PDO Objekt pripojenia PDO.
     */
    protected $connection;

    /**
     * Destruktor triedy, ktorý sa automaticky zavolá, keď je objekt tejto triedy zničený.
     * Uzatvára pripojenie k databáze.
     */
    public function __destruct()
    {
        $this->connection = null;
    }

    /**
     * Táto metóda vytvára pripojenie k databáze.
     *
     * @return PDO Objekt pripojenia PDO.
     */
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

            // Nastaví režim hlásenia chýb na WARNING
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

            // Nastaví predvolený režim načítania na objekt
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

            // Vráti pripojenie k databáze
            return $this->connection;
        } catch (PDOException $e) {
            // Ak je chyba pri pripájaní k databáze, ukonči skript a vytlač chybovú správu
            die("Chyba pripojenia k databáze: " . $e->getMessage());
        }
    }
}