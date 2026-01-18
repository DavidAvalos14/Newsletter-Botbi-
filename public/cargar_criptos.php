<?php
// Script para cargar datos de criptomonedas desde la API de CoinGecko

require_once __DIR__ . '/../includes/db.php';

echo "<h1>Cargando datos de criptomonedas...</h1>";

// Crear conexión a la base de datos
try {
    $database = new Database();
    $pdo = $database->connect();
    echo "<p>Conexión a base de datos exitosa</p>";
} catch (Exception $e) {
    echo "<p>❌ Error de conexión: " . htmlspecialchars($e->getMessage()) . "</p>";
    exit;
}

// Endpoint - Top 10 criptomonedas por capitalización de mercado
$url = 'https://api.coingecko.com/api/v3/coins/markets?vs_currency=usd&order=market_cap_desc&per_page=10';

// cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$json = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode !== 200) {
    echo "<p>Error al conectar con la API. Código HTTP: $httpCode</p>";
    exit;
}

echo "<p>Datos obtenidos de la API</p>";

$datos = json_decode($json, true);

if ($datos && is_array($datos)) {
    $insertados = 0;
    $actualizados = 0;
    
    echo "<h2>Procesando " . count($datos) . " criptomonedas...</h2>";
    echo "<ul>";
    
    foreach ($datos as $moneda) {
        try {
            $sql = "INSERT INTO mercados (mcds_nombre, mcds_precio, mcds_imagen, mcds_tipo) 
                    VALUES (:nombre, :precio, :imagen, 'Cripto')
                    ON CONFLICT (mcds_nombre) DO UPDATE SET 
                        mcds_precio = EXCLUDED.mcds_precio,
                        mcds_imagen = EXCLUDED.mcds_imagen";
            
            $stmt = $pdo->prepare($sql);
            $resultado = $stmt->execute([
                ':nombre' => $moneda['name'],
                ':precio' => $moneda['current_price'],
                ':imagen' => $moneda['image']
            ]);
            
            if ($resultado) {
                echo "<li>" . htmlspecialchars($moneda['name']) . " - $" . number_format($moneda['current_price'], 2) . "</li>";
                $insertados++;
            }
        } catch (PDOException $e) {
            echo "<li>Error con " . htmlspecialchars($moneda['name']) . ": " . htmlspecialchars($e->getMessage()) . "</li>";
        }
    }
    
    echo "</ul>";
    echo "<h2>Resumen:</h2>";
    echo "<p>Total procesados: " . count($datos) . "</p>";
    echo "<p>Registros exitosos: $insertados</p>";
    echo "<hr>";
    echo "<p><a href='index.php'>← Volver al inicio</a></p>";
} else {
    echo "<p>Error al decodificar datos de la API</p>";
}
?>
