<?php

class User extends Database
{
    private $db; // Premenná pre uchovanie inštancie databázy

    // Konštruktor triedy User
    public function __construct()
    {
        // Pripojenie k databáze a uloženie inštancie do premennej $db
        $this->db = $this->connect();
    }

    // Metóda pre prihlásenie používateľa
    public function login($username, $password)
    {
        try {
            // Vytvorenie poľa s údajmi pre prihlásenie
            $data = array(
                'user_email' => $username,
                'user_password' => md5($password),
            );
            // SQL príkaz pre vyhľadanie používateľa v databáze
            $sql = "SELECT * FROM user WHERE email = :user_email AND password = :user_password";
            // Príprava SQL príkazu
            $query_run = $this->db->prepare($sql);
            // Vykonanie SQL príkazu
            $query_run->execute($data);
            // Kontrola, či bol nájdený presne jeden používateľ
            if ($query_run->rowCount() == 1) {
                // Nastavenie session premenných pre prihláseného používateľa
                $_SESSION['logged_in'] = true;
                $user = $query_run->fetch(PDO::FETCH_ASSOC);
                $_SESSION['user_role'] = $user['role'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_id'] = $user['id'];
                // Vrátenie hodnoty true, ak sa prihlásenie podarilo
                return true;
            } else {
                // Vrátenie hodnoty false, ak sa prihlásenie nepodarilo
                return false;
            }
        } catch (PDOException $e) {
            // Výpis chybovej správy, ak došlo k chybe pri práci s databázou
            echo $e->getMessage();
        }
    }

    // Metóda pre registráciu nového používateľa
    public function register($email, $password)
    {
        try {
            // SQL príkaz pre vyhľadanie používateľa v databáze
            $sql = "SELECT * FROM user WHERE email = :email";
            // Príprava SQL príkazu
            $stmt = $this->db->prepare($sql);
            // Vykonanie SQL príkazu
            $stmt->execute(['email' => $email]);
            // Získanie výsledku SQL príkazu
            $user = $stmt->fetch();
            // Kontrola, či už používateľ s daným emailom existuje
            if ($user) {
                // Vrátenie hodnoty false, ak už používateľ existuje
                return false;
            }
            // Hashovanie hesla
            $hashed_password = md5($password);
            // Vytvorenie poľa s údajmi pre registráciu
            $data = array(
                'user_email' => $email,
                'user_password' => $hashed_password,
                'user_role' => '0',
            );
            // SQL príkaz pre vloženie nového používateľa do databázy
            $sql = "INSERT INTO user (email, password, role) VALUES (:user_email, :user_password, :user_role)";
            // Príprava SQL príkazu
            $query_run = $this->db->prepare($sql);
            // Vykonanie SQL príkazu
            $query_run->execute($data);
            // Vrátenie hodnoty true, ak sa registrácia podarila
            return true;
        } catch (PDOException $e) {
            // Výpis chybovej správy, ak došlo k chybe pri práci s databázou
            echo $e->getMessage();
            // Vrátenie hodnoty false, ak sa registrácia nepodarila
            return false;
        }
    }
}
