<?php

/**
 * Class User
 *
 * This class is used for user authentication and registration.
 */
class User extends Database
{
    /**
     * @var PDO The PDO connection object.
     */
    private $db;

    /**
     * Constructor of the User class.
     *
     * It establishes a connection to the database.
     */
    public function __construct()
    {
        $this->db = $this->connect();
    }

    /**
     * This method is used for user login.
     *
     * @param string $username The username of the user.
     * @param string $password The password of the user.
     * @return bool Returns true if login is successful, false otherwise.
     */
    public function login(string $username, string $password): bool
    {
        try {
            // Create an array with login data
            $data = array(
                'user_email' => $username,
                'user_password' => md5($password),
            );
            // SQL command to find the user in the database
            $sql = "SELECT * FROM user WHERE email = :user_email AND password = :user_password";
            // Prepare the SQL command
            $query_run = $this->db->prepare($sql);
            // Execute the SQL command
            $query_run->execute($data);
            // Check if exactly one user was found
            if ($query_run->rowCount() == 1) {
                // Set session variables for the logged in user
                $_SESSION['logged_in'] = true;
                $user = $query_run->fetch(PDO::FETCH_ASSOC);
                $_SESSION['user_role'] = $user['role'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_id'] = $user['id'];
                // Return true if login was successful
                return true;
            } else {
                // Return false if login was unsuccessful
                return false;
            }
        } catch (PDOException $e) {
            // Print the error message if there was an error working with the database
            echo $e->getMessage();
        }
    }

    /**
     * This method is used for user registration.
     *
     * @param string $email The email of the user.
     * @param string $password The password of the user.
     * @return bool Returns true if registration is successful, false otherwise.
     */
    public function register(string $email, string $password): bool
    {
        try {
            // SQL command to find the user in the database
            $sql = "SELECT * FROM user WHERE email = :email";
            // Prepare the SQL command
            $stmt = $this->db->prepare($sql);
            // Execute the SQL command
            $stmt->execute(['email' => $email]);
            // Get the result of the SQL command
            $user = $stmt->fetch();
            // Check if a user with the given email already exists
            if ($user) {
                // Return false if the user already exists
                return false;
            }
            // Hash the password
            $hashed_password = md5($password);
            // Create an array with registration data
            $data = array(
                'user_email' => $email,
                'user_password' => $hashed_password,
                'user_role' => '0',
            );
            // SQL command to insert a new user into the database
            $sql = "INSERT INTO user (email, password, role) VALUES (:user_email, :user_password, :user_role)";
            // Prepare the SQL command
            $query_run = $this->db->prepare($sql);
            // Execute the SQL command
            $query_run->execute($data);
            // Return true if registration was successful
            return true;
        } catch (PDOException $e) {
            // Print the error message if there was an error working with the database
            echo $e->getMessage();
            // Return false if registration was unsuccessful
            return false;
        }
    }
}
