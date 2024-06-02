<?php

/**
 * Trieda Contact
 *
 * Táto trieda reprezentuje kolekciu kontaktov v databáze.
 */
class Contact extends Database
{
    /**
     * @var PDO Objekt pripojenia PDO.
     */
    private $db;

    /**
     * Konštruktor triedy, ktorý sa automaticky zavolá pri vytvorení objektu tejto triedy.
     * Nadväzuje spojenie s databázou.
     */
    public function __construct()
    {
        $this->db = $this->connect();
    }

    /**
     * Táto metóda vkladá kontakt do databázy.
     * 
     * @param string $name Meno kontaktu.
     * @param string $email E-mail kontaktu.
     * @param string $message Správa kontaktu.
     * @param bool $acceptance Akceptácia kontaktu.
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
     * Táto metóda získava všetky kontakty z databázy.
     *
     * @return array Pole kontaktov.
     */
    public function select(): array
    {
        try {
            $sql = "SELECT * FROM contact";
            $query = $this->db->query($sql);
            $contacts = $query->fetchAll();
            return $contacts;
        } catch (PDOException $e) {
            echo($e->getMessage());
        }
    }

    /**
     * Táto metóda odstraňuje kontakt z databázy.
     *
     * @param int $id ID kontaktu na odstránenie.
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