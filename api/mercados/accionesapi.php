<?php

// Obtención de top 10 acciones mediante la API de Alpha Vantage

include_once __DIR__ . '/../../includes/db.php';

// Conexión a la bd
$database = new Database();
$pdo = $database->connect();

// Endpoint Top 10 acciones con mejor ganancia
$apiKey = getenv('API_KEY'); 
$url = "https://www.alphavantage.co/query?function=TOP_GAINERS_LOSERS&apikey=" . $apiKey;

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

// Alpha Vantage devuelve un objeto con la llave "top_gainers"
if (isset($datos['top_gainers'])) {
    $top10 = array_slice($datos['top_gainers'], 0, 10);

    foreach ($top10 as $accion) {
        $sql = "INSERT INTO mercados (mcds_nombre, mcds_precio, mcds_imagen, mcds_tipo) 
                VALUES (:nombre, :precio, '', 'Accion')
                ON CONFLICT (mcds_nombre) 
                DO UPDATE SET mcds_precio = EXCLUDED.mcds_precio";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nombre' => $accion['ticker'],
            ':precio' => $accion['price']
        ]);
    }
    echo "Top 10 Acciones Dinámicas actualizado con Alpha Vantage.\n";
}
?>