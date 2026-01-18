<?php

// Obtención de criptomonedas desde API de CoinGecko

require_once __DIR__ . '/../../includes/db.php';

// Conexión a la bd
$database = new Database();
$pdo = $database->connect();

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
    echo "Error al conectar con la API. Código HTTP: $httpCode\n";
    exit;
}

$datos = json_decode($json, true);

if ($datos) {
    $insertados = 0;
    $actualizados = 0;
    
    foreach ($datos as $moneda) {
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
            if ($stmt->rowCount() > 0) {
                $insertados++;
            } else {
                $actualizados++;
            }
        }
    }
    
    echo "Datos cargados exitosamente\n";
    echo "Insertados: $insertados\n";
    echo "Actualizados: $actualizados\n";
    echo "Total procesados: " . count($datos) . "\n";
} else {
    echo "Error al decodificar datos de la API\n";
}

?>

