<?php
include_once '../includes/header.php';
require_once '../includes/db.php';

// Verificar que se recibió el UUID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$uuid = $_GET['id'];

// Obtener la noticia completa
$database = new Database();
$pdo = $database->connect();

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
              WHERE news_uuid = :uuid";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute([':uuid' => $uuid]);
    
    $noticia = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$noticia) {
        echo "<p class='error-message'>Noticia no encontrada.</p>";
        echo "<p><a href='index.php'>← Volver al inicio</a></p>";
        include_once '../includes/footer.php';
        exit;
    }
    
} catch (PDOException $e) {
    echo "<p class='error-message'>Error al obtener la noticia: " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p><a href='index.php'>← Volver al inicio</a></p>";
    include_once '../includes/footer.php';
    exit;
}
?>

<!-- Detalle de Noticia -->
<section class="content-section">
    <div class="news-detail">
        <div class="news-detail-header">
            <span class="news-detail-category"><?php echo htmlspecialchars($noticia['categoria']); ?></span>
            <span class="news-detail-date"><?php echo date('d/m/Y H:i', strtotime($noticia['fecha'])); ?></span>
        </div>
        
        <h1 class="news-detail-title"><?php echo htmlspecialchars($noticia['titulo']); ?></h1>
        
        <?php if (!empty($noticia['imagen'])): ?>
            <img src="<?php echo htmlspecialchars($noticia['imagen']); ?>" 
                 alt="<?php echo htmlspecialchars($noticia['titulo']); ?>"
                 class="news-detail-image">
        <?php endif; ?>
        
        <div class="news-detail-content">
            <?php echo nl2br(htmlspecialchars($noticia['contenido'])); ?>
        </div>
        
        <div class="news-detail-footer">
            <a href="<?php echo htmlspecialchars($noticia['url']); ?>" target="_blank" class="news-detail-source">Ver fuente original</a>
            <a href="index.php" class="news-detail-back">← Volver al inicio</a>
        </div>
    </div>
</section>

<?php
include_once '../includes/footer.php';
?>
