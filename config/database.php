<?php
class Database {
    private $host = 'localhost';
    private $db = 'mathiteia';
    private $user = 'postgres';
    private $pass = 'postgres';
    private $conn;

    public function connect() {
        $this->conn = null;
        $dsn = "pgsql:host=" . $this->host . ";dbname=" . $this->db;
        try {
            $this->conn = new PDO($dsn, $this->user, $this->pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            // Throw an exception so callers can handle it (and avoid returning null PDO)
            throw new Exception("Connection error: " . $exception->getMessage());
        }
        return $this->conn;
    }
    public function getConnection() {
        if ($this->conn === null) {
            $this->connect();
        }
        return $this->conn;
    }
}