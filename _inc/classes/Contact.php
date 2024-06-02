<?php

class Contact extends Database
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
     * VKLADANIE KONTAKTU DO DATABAZY
     * 
     * $name - MENO KONTAKTU
     * $email - E-MAIL KONTAKTU
     * $message - SPRAVA KONTAKTU
     * $acceptance - AKCEPTACIA KONTAKTU
     */
    public function insert(string $name, string $email, string $message, bool $acceptance): void
    {
        try {
            $sql = "INSERT INTO contact (name, email, message, acceptance) VALUES (:name, :email, :message, :acceptance)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['name' => $name, 'email' => $email, 'message' => $message, 'acceptance' => $acceptance]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Vssetky kontakty z databazy.
     */
    public function select(): array
    {
        try {
            $sql = "SELECT * FROM contact";
            $query = $this->db->query($sql);
            $contacts = $query->fetchAll();
            return $contacts;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Odstranenie kontaktu z databazy.
     */
    public function delete(int $id): void
    {
        try {
            $query = "DELETE FROM contact WHERE id = :id";
            $query_run = $this->db->prepare($query);
            $query_run->execute(['id' => $id]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}