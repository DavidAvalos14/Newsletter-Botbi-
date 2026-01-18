<?php
require_once __DIR__ . '/../../includes/db.php';

class AccionesBD {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->connect();
    }

    public function obtenerAcciones() {
        try {
            $query = "SELECT 
                        mcds_nombre AS nombre,
                        mcds_precio AS precio,
                        mcds_tipo AS tipo
                      FROM mercados
                      WHERE mcds_tipo = 'Accion'
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
            error_log("Error al obtener acciones: " . $e->getMessage());
            return [
                'success' => false,
                'error' => 'Error al obtener los datos de acciones',
                'message' => $e->getMessage()
            ];
        }
    }
}
?>
