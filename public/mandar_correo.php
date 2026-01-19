<?php
require_once __DIR__ . '/../api/newsletter/newsletter.php';

echo "<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Enviar Newsletter</title>
    <style>
        body {
            font-family: Georgia, 'Times New Roman', serif;
            background-color: #f5f5f5;
            padding: 40px;
            max-width: 800px;
            margin: 0 auto;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 15px;
            border: 2px solid #2d2d2d;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        h1 {
            color: #000;
            text-align: center;
            margin-bottom: 30px;
        }
        .loading {
            text-align: center;
            padding: 20px;
            font-size: 18px;
        }
        .success {
            background: #d4edda;
            border: 2px solid #28a745;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }
        .error {
            background: #f8d7da;
            border: 2px solid #dc3545;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }
        .stats {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin: 20px 0;
        }
        .stat-card {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 10px;
            border: 2px solid #2d2d2d;
            text-align: center;
        }
        .stat-number {
            font-size: 32px;
            font-weight: bold;
            color: #000;
        }
        .stat-label {
            font-size: 14px;
            color: #666;
            margin-top: 5px;
        }
        .back-link {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 30px;
            background: #000;
            color: #fff;
            text-decoration: none;
            border-radius: 10px;
            font-weight: bold;
        }
        .back-link:hover {
            background: #2d2d2d;
        }
        .details {
            margin-top: 20px;
            padding: 15px;
            background: #fff3cd;
            border: 2px solid #ffc107;
            border-radius: 10px;
        }
        .details h3 {
            margin-top: 0;
        }
        .details ul {
            margin: 10px 0;
            padding-left: 20px;
        }
    </style>
</head>
<body>
    <div class='container'>
        <h1>📧 Enviar Newsletter a Suscriptores</h1>
        <div class='loading'>
            <p>⏳ Enviando newsletter...</p>
        </div>";

// Ejecutar el envío del newsletter
$resultado = enviarNewsletterATodos();

if ($resultado['success']) {
    echo "
        <div class='success'>
            <h2>✅ {$resultado['message']}</h2>
        </div>
        
        <div class='stats'>
            <div class='stat-card'>
                <div class='stat-number'>{$resultado['enviados']}</div>
                <div class='stat-label'>Correos Enviados</div>
            </div>
            <div class='stat-card'>
                <div class='stat-number'>{$resultado['errores']}</div>
                <div class='stat-label'>Errores</div>
            </div>
        </div>";
    
    if (!empty($resultado['detalles'])) {
        echo "
        <div class='details'>
            <h3>⚠️ Detalles de errores:</h3>
            <ul>";
        foreach ($resultado['detalles'] as $detalle) {
            echo "<li>" . htmlspecialchars($detalle) . "</li>";
        }
        echo "
            </ul>
        </div>";
    }
} else {
    echo "
        <div class='error'>
            <h2>❌ Error al enviar newsletter</h2>
            <p><strong>Mensaje:</strong> " . htmlspecialchars($resultado['message']) . "</p>
        </div>";
}

echo "
        <div style='text-align: center;'>
            <a href='index.php' class='back-link'>← Volver al inicio</a>
        </div>
    </div>
</body>
</html>";
?>
