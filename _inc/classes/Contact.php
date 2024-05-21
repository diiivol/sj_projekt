<?php
class Contact extends Database
{
    private $db;
    // Konštruktor triedy, ktorý sa automaticky zavolá pri vytvorení objektu tejto triedy
    public function __construct()
    {
        // Pripojíme sa k databáze
        $this->db = $this->connect();
    }

    // Metóda pre vloženie kontaktu do databázy
    public function insert()
    {
        // Ak je databáza pripojená a bol odoslaný kontaktný formulár
        if ($this->db && isset($_POST['contact_submitted'])) {
            // Vytvoríme pole s dátami z formulára
            $data = array(
                'contact_name' => $_POST['name'],
                'contact_email' => $_POST['email'],
                'contact_message' => filter_var($_POST['message'], FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'contact_acceptance' => $_POST['acceptance'],
            );
            try {
                // Vytvoríme SQL príkaz pre vloženie kontaktu do databázy
                $query = "INSERT INTO contact (name, email, message, acceptance) VALUES
             (:contact_name, :contact_email, :contact_message, :contact_acceptance)";
                // Pripravíme SQL príkaz
                $query_run = $this->db->prepare($query);
                // Vykonáme SQL príkaz
                $query_run->execute($data);
                // Presmerujeme užívateľa na aktuálnu stránku
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit;
            } catch (PDOException $e) {
                // Ak nastane chyba, vypíšeme ju
                echo 'Post nebol vykonaný: ' . $e->getMessage();
            }
        }
    }

    // Metóda pre získanie všetkých kontaktov z databázy
    public function select()
    {
        try {
            // Vytvoríme SQL príkaz pre získanie všetkých kontaktov
            $sql = "SELECT * FROM contact";
            // Vykonáme SQL príkaz
            $query = $this->db->query($sql);
            // Získame všetky kontakty
            $contacts = $query->fetchAll();
            // Vrátime kontakty
            return $contacts;
        } catch (PDOException $e) {
            // Ak nastane chyba, vypíšeme ju
            echo ($e->getMessage());
        }
    }

    // Metóda pre odstránenie kontaktu z databázy
    public function delete($id)
    {
        try {
            // Vytvoríme SQL príkaz pre odstránenie kontaktu
            $query = "DELETE FROM contact WHERE id = :id";
            // Pripravíme SQL príkaz
            $query_run = $this->db->prepare($query);
            // Vykonáme SQL príkaz
            $query_run->execute(['id' => $id]);
        } catch (PDOException $e) {
            // Ak nastane chyba, vypíšeme ju
            echo $e->getMessage();
        }
    }
}
