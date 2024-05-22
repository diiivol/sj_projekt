<?php

/**
 * Class Database
 *
 * This class represents a database connection.
 */
class Database
{
    /**
     * @var string The database host.
     */
    private $host = '127.0.0.1';

    /**
     * @var string The database name.
     */
    private $db_name = 'sj_projekt';

    /**
     * @var string The username for the database connection.
     */
    private $user_name = 'root';

    /**
     * @var string The password for the database connection.
     */
    private $password = '';

    /**
     * @var PDO The PDO connection object.
     */
    protected $connection;

    /**
     * Destructor of the class, which is automatically called when an object of this class is destroyed.
     * It closes the database connection.
     */
    public function __destruct()
    {
        $this->connection = null;
    }

    /**
     * This method establishes a connection to the database.
     *
     * @return PDO The PDO connection object.
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

            // Set the error reporting mode to WARNING
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

            // Set the default fetch mode to object
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

            // Return the database connection
            return $this->connection;
        } catch (PDOException $e) {
            // If there is an error connecting to the database, terminate the script and print an error message
            die("Database connection error: " . $e->getMessage());
        }
    }
}