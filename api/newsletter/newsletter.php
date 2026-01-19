<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/mail_config.php';

function generarNewsletterHTML() {
    try {
        $database = new Database();
        $pdo = $database->connect();
        
        // Obtener top 10 noticias de Tecnología
        $sqlTech = "SELECT news_titulo, news_descripcion, news_fecha 
                    FROM noticias 
                    WHERE news_categoria = 'Tecnologia' 
                    ORDER BY news_fecha DESC 
                    LIMIT 10";
        $stmtTech = $pdo->query($sqlTech);
        $noticiasTech = $stmtTech->fetchAll(PDO::FETCH_ASSOC);
        
        // Obtener top 10 noticias de Negocios
        $sqlBusiness = "SELECT news_titulo, news_descripcion, news_fecha 
                        FROM noticias 
                        WHERE news_categoria = 'Negocios' 
                        ORDER BY news_fecha DESC 
                        LIMIT 10";
        $stmtBusiness = $pdo->query($sqlBusiness);
        $noticiasNegocios = $stmtBusiness->fetchAll(PDO::FETCH_ASSOC);
        
        // Obtener acciones
        $sqlAcciones = "SELECT mcds_nombre, mcds_precio 
                        FROM mercados 
                        WHERE mcds_tipo = 'Accion' 
                        ORDER BY mcds_precio DESC";
        $stmtAcciones = $pdo->query($sqlAcciones);
        $acciones = $stmtAcciones->fetchAll(PDO::FETCH_ASSOC);
        
        // Obtener criptomonedas
        $sqlCriptos = "SELECT mcds_nombre, mcds_precio 
                       FROM mercados 
                       WHERE mcds_tipo = 'Cripto' 
                       ORDER BY mcds_precio DESC";
        $stmtCriptos = $pdo->query($sqlCriptos);
        $criptos = $stmtCriptos->fetchAll(PDO::FETCH_ASSOC);
        
        // Generar HTML del email
        $html = '
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Newsletter - Avalos News</title>
    <style>
        body {
            font-family: Georgia, "Times New Roman", serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
        }
        .header {
            text-align: center;
            padding: 30px 0;
            background-color: #000000;
            color: #ffffff;
            border-radius: 10px;
            margin-bottom: 30px;
        }
        .header h1 {
            margin: 0;
            font-size: 32px;
        }
        .section {
            margin-bottom: 40px;
        }
        .section-title {
            font-size: 24px;
            font-weight: bold;
            color: #000000;
            border-bottom: 3px solid #000000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .news-item {
            background-color: #f9f9f9;
            border: 2px solid #2d2d2d;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
        }
        .news-title {
            font-size: 18px;
            font-weight: bold;
            color: #000000;
            margin: 0 0 10px 0;
        }
        .news-description {
            font-size: 14px;
            color: #333333;
            line-height: 1.6;
            margin: 0 0 10px 0;
        }
        .news-date {
            font-size: 12px;
            color: #666666;
            font-style: italic;
        }
        .market-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-top: 20px;
        }
        .market-item {
            background-color: #f9f9f9;
            border: 2px solid #2d2d2d;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
        }
        .market-name {
            font-size: 16px;
            font-weight: bold;
            color: #000000;
            margin-bottom: 8px;
        }
        .market-price {
            font-size: 20px;
            font-weight: bold;
            color: #28a745;
        }
        .footer {
            text-align: center;
            padding: 30px;
            background-color: #e8e8e8;
            border-radius: 10px;
            margin-top: 40px;
        }
        .btn-link {
            display: inline-block;
            background-color: #000000;
            color: #ffffff;
            text-decoration: none;
            padding: 15px 40px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: bold;
            margin: 20px 0;
        }
        @media only screen and (max-width: 600px) {
            .market-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📰 Newsletter Avalos News</h1>
            <p>Tu resumen semanal de tecnología, negocios y mercados</p>
        </div>
        
        <!-- Noticias de Tecnología -->
        <div class="section">
            <h2 class="section-title">💻 Top 10 Noticias de Tecnología</h2>';
        
        foreach ($noticiasTech as $noticia) {
            $fecha = date('d/m/Y H:i', strtotime($noticia['news_fecha']));
            $html .= '
            <div class="news-item">
                <h3 class="news-title">' . htmlspecialchars($noticia['news_titulo']) . '</h3>
                <p class="news-description">' . htmlspecialchars($noticia['news_descripcion']) . '</p>
                <p class="news-date">📅 ' . $fecha . '</p>
            </div>';
        }
        
        $html .= '
        </div>
        
        <!-- Noticias de Negocios -->
        <div class="section">
            <h2 class="section-title">💼 Top 10 Noticias de Negocios</h2>';
        
        foreach ($noticiasNegocios as $noticia) {
            $fecha = date('d/m/Y H:i', strtotime($noticia['news_fecha']));
            $html .= '
            <div class="news-item">
                <h3 class="news-title">' . htmlspecialchars($noticia['news_titulo']) . '</h3>
                <p class="news-description">' . htmlspecialchars($noticia['news_descripcion']) . '</p>
                <p class="news-date">📅 ' . $fecha . '</p>
            </div>';
        }
        
        $html .= '
        </div>
        
        <!-- Mercados: Acciones -->
        <div class="section">
            <h2 class="section-title">📈 Acciones Destacadas</h2>
            <div class="market-grid">';
        
        foreach ($acciones as $accion) {
            $html .= '
                <div class="market-item">
                    <div class="market-name">' . htmlspecialchars($accion['mcds_nombre']) . '</div>
                    <div class="market-price">$' . number_format($accion['mcds_precio'], 2) . '</div>
                </div>';
        }
        
        $html .= '
            </div>
        </div>
        
        <!-- Mercados: Criptomonedas -->
        <div class="section">
            <h2 class="section-title">₿ Criptomonedas Destacadas</h2>
            <div class="market-grid">';
        
        foreach ($criptos as $cripto) {
            $html .= '
                <div class="market-item">
                    <div class="market-name">' . htmlspecialchars($cripto['mcds_nombre']) . '</div>
                    <div class="market-price">$' . number_format($cripto['mcds_precio'], 2) . '</div>
                </div>';
        }
        
        $html .= '
            </div>
        </div>
        
        <!-- Footer con link a la página -->
        <div class="footer">
            <h3>¿Quieres leer más?</h3>
            <a href="http://localhost:8080/index.php" class="btn-link">Visita nuestra página web</a>
            <p style="margin-top: 20px; color: #666666; font-size: 14px;">
                Este es un newsletter automático de <strong>Avalos News</strong><br>
                Si deseas dejar de recibir estos correos, puedes darte de baja en cualquier momento.
            </p>
        </div>
    </div>
</body>
</html>';
        
        return $html;
        
    } catch (Exception $e) {
        return '<html><body><h1>Error al generar newsletter</h1><p>' . $e->getMessage() . '</p></body></html>';
    }
}

function enviarNewsletterATodos() {
    try {
        $database = new Database();
        $pdo = $database->connect();
        
        // Obtener todos los suscriptores
        $sql = "SELECT subs_email FROM suscriptores";
        $stmt = $pdo->query($sql);
        $suscriptores = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (empty($suscriptores)) {
            return ['success' => false, 'message' => 'No hay suscriptores registrados'];
        }
        
        // Generar el contenido HTML del newsletter
        $htmlContent = generarNewsletterHTML();
        
        $enviados = 0;
        $errores = 0;
        $detalles = [];
        
        foreach ($suscriptores as $suscriptor) {
            $resultado = enviarEmail(
                $suscriptor['subs_email'],
                '📰 Newsletter Avalos News - Resumen de noticias',
                $htmlContent
            );
            
            if ($resultado['success']) {
                $enviados++;
            } else {
                $errores++;
                $detalles[] = $suscriptor['subs_email'] . ': ' . $resultado['message'];
            }
        }
        
        return [
            'success' => true,
            'message' => "Newsletter enviado exitosamente",
            'enviados' => $enviados,
            'errores' => $errores,
            'detalles' => $detalles
        ];
        
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => 'Error al enviar newsletter: ' . $e->getMessage()
        ];
    }
}

// Si se ejecuta directamente desde el navegador o CLI
if (basename(__FILE__) == basename($_SERVER['PHP_SELF'])) {
    echo "<h1>Enviando Newsletter...</h1>";
    $resultado = enviarNewsletterATodos();
    
    if ($resultado['success']) {
        echo "<p>✅ {$resultado['message']}</p>";
        echo "<p><strong>Enviados:</strong> {$resultado['enviados']}</p>";
        echo "<p><strong>Errores:</strong> {$resultado['errores']}</p>";
        
        if (!empty($resultado['detalles'])) {
            echo "<h3>Detalles de errores:</h3><ul>";
            foreach ($resultado['detalles'] as $detalle) {
                echo "<li>" . htmlspecialchars($detalle) . "</li>";
            }
            echo "</ul>";
        }
    } else {
        echo "<p>❌ {$resultado['message']}</p>";
    }
}
?>
