<?php

/**
 * Trieda User
 *
 * Táto trieda sa používa na overenie a registráciu používateľa.
 */
class User extends Database
{
    /**
     * @var PDO Objekt pripojenia PDO.
     */
    private $db;

    /**
     * Konštruktor triedy User.
     *
     * Nadväzuje spojenie s databázou.
     */
    public function __construct()
    {
        $this->db = $this->connect();
    }

    /**
     * Táto metóda sa používa na prihlásenie používateľa.
     *
     * @param string $username Používateľské meno používateľa.
     * @param string $password Heslo používateľa.
     * @return bool Vracia true, ak je prihlásenie úspešné, inak false.
     */
    public function login(string $username, string $password): bool
    {
        try {
            // Vytvorte pole s prihlasovacími údajmi
            $data = array(
                'user_email' => $username,
                'user_password' => md5($password),
            );
            // SQL príkaz na nájdenie používateľa v databáze
            $sql = "SELECT * FROM user WHERE email = :user_email AND password = :user_password";
            // Pripravte SQL príkaz
            $query_run = $this->db->prepare($sql);
            // Spustite SQL príkaz
            $query_run->execute($data);
            // Skontrolujte, či sa našiel presne jeden používateľ
            if ($query_run->rowCount() == 1) {
                // Nastavte premenné relácie pre prihláseného používateľa
                $_SESSION['logged_in'] = true;
                $user = $query_run->fetch(PDO::FETCH_ASSOC);
                $_SESSION['user_role'] = $user['role'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_id'] = $user['id'];
                // Vráťte true, ak bolo prihlásenie úspešné
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Táto metóda sa používa na registráciu používateľa.
     *
     * @param string $email E-mail používateľa.
     * @param string $password Heslo používateľa.
     * @return bool Vracia true, ak je registrácia úspešná, inak false.
     */
    public function register(string $email, string $password): bool
    {
        try {
            // SQL príkaz na nájdenie používateľa v databáze
            $sql = "SELECT * FROM user WHERE email = :email";
            // Pripravte SQL príkaz
            $stmt = $this->db->prepare($sql);
            // Spustite SQL príkaz
            $stmt->execute(['email' => $email]);
            // Získajte výsledok SQL príkazu
            $user = $stmt->fetch();
            // Skontrolujte, či už existuje používateľ s daným e-mailom
            if ($user) {
                // Vráťte false, ak už používateľ existuje
                return false;
            }
            // Hash hesla
            $hashed_password = md5($password);
            // Vytvorte pole s registračnými údajmi
            $data = array(
                'user_email' => $email,
                'user_password' => $hashed_password,
                'user_role' => '0',
            );
            // SQL príkaz na vloženie nového používateľa do databázy
            $sql = "INSERT INTO user (email, password, role) VALUES (:user_email, :user_password, :user_role)";
            // Pripravte SQL príkaz
            $query_run = $this->db->prepare($sql);
            // Spustite SQL príkaz
            $query_run->execute($data);
            // Vráťte true, ak bola registrácia úspešná
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}