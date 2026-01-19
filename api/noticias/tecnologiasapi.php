<?php

// Obtención de noticias mediante la API de GNews

include_once __DIR__ . '/../../includes/db.php';

// Conexión a la bd
$database = new Database();
$pdo = $database->connect();

// Obtención de noticias de tecnologia
$apiKey = getenv('API_KEY_NEWS'); 
$url = "https://gnews.io/api/v4/top-headlines?category=technology&lang=es&country=mx&max=20&apikey=" . $apiKey;

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

// GNews devuelve un array "articles"
if (isset($datos['articles']) && is_array($datos['articles'])) {
    $insertados = 0;
    
    foreach ($datos['articles'] as $articulo) {
        try {
            $sql = "INSERT INTO noticias (news_titulo, news_descripcion, news_contenido, news_categoria, news_url, news_imagen, news_fecha) 
                    VALUES (:titulo, :descripcion, :contenido, 'Tecnologia', :url, :imagen, :fecha)
                    ON CONFLICT (news_titulo) 
                    DO UPDATE SET 
                        news_descripcion = EXCLUDED.news_descripcion,
                        news_contenido = EXCLUDED.news_contenido,
                        news_url = EXCLUDED.news_url,
                        news_imagen = EXCLUDED.news_imagen,
                        news_fecha = EXCLUDED.news_fecha";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':titulo' => $articulo['title'] ?? 'Sin título',
                ':descripcion' => $articulo['description'] ?? 'Sin descripción',
                ':contenido' => $articulo['content'] ?? $articulo['description'] ?? 'Sin contenido',
                ':url' => $articulo['url'] ?? '',
                ':imagen' => $articulo['image'] ?? '',
                ':fecha' => $articulo['publishedAt'] ?? date('c')
            ]);
            
            $insertados++;
            echo "✓ Noticia insertada: " . ($articulo['title'] ?? 'Sin título') . "\n";
            
        } catch (PDOException $e) {
            echo "✗ Error con noticia '" . ($articulo['title'] ?? 'desconocida') . "': " . $e->getMessage() . "\n";
        }
    }
    
    echo "\nTotal de noticias de tecnología procesadas: $insertados\n";
} else {
    echo "No se pudieron obtener noticias de la API.\n";
    if (isset($datos['errors'])) {
        echo "Errores: " . json_encode($datos['errors']) . "\n";
    }
}

?>