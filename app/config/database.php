<?php

define('DB_PATH', dirname(__DIR__) . '/database.db');
class Database {
    private $host = 'localhost';
    private $db_name = 'flashcards';

    private $port = '3306';
    private $username = 'root';
    private $password = '';
    private $conn;

    // Get the database connection
    public function connect() {
        $this->conn = null;
        try {
            $this->conn = new PDO('sqlite:'.DB_PATH);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection error: " . $e->getMessage();
        }

        return $this->conn;
    }
}

// return [
//     'host' => 'localhost',        // Database host, often "localhost" or a remote host
//     'port' => '3306',             // Default MySQL port
//     'database' => 'flashcards',   // The name of your database
//     'username' => 'root',         // Your database username
//     'password' => '',             // Your database password
//     'charset' => 'utf8mb4',       // Character set for database communication
// ];