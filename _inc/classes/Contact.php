<?php

/**
 * Class Contact
 *
 * This class represents a collection of contacts in a database.
 */
class Contact extends Database
{
    /**
     * @var PDO The PDO connection object.
     */
    private $db;

    /**
     * Constructor of the class, which is automatically called when an object of this class is created.
     * It establishes a connection to the database.
     */
    public function __construct()
    {
        $this->db = $this->connect();
    }

    /**
     * This method inserts a contact into the database.
     * 
     * @param int $name The name of the contact.
     * @param string $email The email of the contact.
     * @param string $message The message of the contact.
     * @param bool $acceptance The acceptance of the contact.
     */
    public function insert(int $name, string $email, string $message, bool $acceptance)
    {
        if ($this->db) {
            $data = array(
                'contact_name' => $name,
                'contact_email' => $email,
                'contact_message' => filter_var($message, FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'contact_acceptance' => $acceptance,
            );
            try {
                $query = "INSERT INTO contact (name, email, message, acceptance) VALUES
             (:contact_name, :contact_email, :contact_message, :contact_acceptance)";
                $query_run = $this->db->prepare($query);
                $query_run->execute($data);
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit;
            } catch (PDOException $e) {
                echo 'Post was not executed: ' . $e->getMessage();
            }
        }
    }

    /**
     * This method retrieves all contacts from the database.
     *
     * @return array The array of contacts.
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
     * This method deletes a contact from the database.
     *
     * @param int $id The ID of the contact to delete.
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