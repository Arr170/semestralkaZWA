<?php

define('DB_PATH', dirname(__DIR__, 2) . '/database.db');
class Database {
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
