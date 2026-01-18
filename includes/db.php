<?php
require_once __DIR__ . '/../config/db.php';

// Conexión a la bd

class Database {
    private $conn;

    public function connect() {
        if ($this->conn) return $this->conn;
        try {
            $this->conn = new PDO(
                "pgsql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME,
                DB_USER,
                DB_PASS,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
            return $this->conn;
        } catch (PDOException $e) {
            error_log("Error de conexión: " . $e->getMessage());
            die("Error de conexión a la base de datos");
        }
    }
}
?>
