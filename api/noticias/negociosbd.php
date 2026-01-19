<?php
require_once __DIR__ . '/../../includes/db.php';

class NegociosBD {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->connect();
    }

    public function obtenerNegocios() {
        try {
            $query = "SELECT 
                        news_uuid AS uuid,
                        news_titulo AS titulo,
                        news_descripcion AS descripcion,
                        news_contenido AS contenido,
                        news_fecha AS fecha,
                        news_categoria AS categoria,
                        news_url AS url,
                        news_imagen AS imagen
                      FROM noticias
                      WHERE news_categoria = 'Negocios'
                      ORDER BY news_fecha DESC";
            
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            
            $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return [
                'success' => true,
                'data' => $resultado,
                'count' => count($resultado)
            ];
            
        } catch (PDOException $e) {
            error_log("Error al obtener noticias de negocios: " . $e->getMessage());
            return [
                'success' => false,
                'error' => 'Error al obtener las noticias de negocios',
                'message' => $e->getMessage()
            ];
        }
    }
}
?>
