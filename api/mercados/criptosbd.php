<?php
require_once __DIR__ . '/../../includes/db.php';

class CriptoBD {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->connect();
    }

    public function obtenerCriptomonedas() {
        try {
            $query = "SELECT 
                        mcds_nombre AS nombre,
                        mcds_precio AS precio,
                        mcds_imagen AS imagen,
                        mcds_tipo AS tipo
                      FROM mercados
                      WHERE mcds_tipo = 'Cripto'
                      ORDER BY mcds_precio DESC";
            
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            
            $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return [
                'success' => true,
                'data' => $resultado,
                'count' => count($resultado)
            ];
            
        } catch (PDOException $e) {
            error_log("Error al obtener criptomonedas: " . $e->getMessage());
            return [
                'success' => false,
                'error' => 'Error al obtener los datos de criptomonedas',
                'message' => $e->getMessage()
            ];
        }
    }
}
?>
