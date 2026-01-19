<?php

include_once '../includes/header.php';
require_once '../api/mercados/criptosbd.php';
require_once '../api/mercados/accionesbd.php';
require_once '../api/noticias/negociosbd.php';
require_once '../api/noticias/tecnologiasbd.php';

// Obtener criptomonedas de la base de datos
$criptoBD = new CriptoBD();
$resultadoCriptos = $criptoBD->obtenerCriptomonedas();

// Obtener acciones de la base de datos
$accionesBD = new AccionesBD();
$resultadoAcciones = $accionesBD->obtenerAcciones();

$negociosBD = new NegociosBD();
$resultadoNegocios = $negociosBD->obtenerNegocios();

$tecnologiaBD = new TecnologiasBD();
$resultadoTecnologia = $tecnologiaBD->obtenerTecnologias();

?>

<!-- Noticias Tecnología -->
<section class="content-section" id="tecnologia">
    <h2 class="section-title">Tecnología</h2>
    <div class="section-content">
        <!---->

        <?php if ($resultadoTecnologia['success']): ?>
            <div class="news-grid">
                <?php foreach ($resultadoTecnologia['data'] as $noticia): ?>
                    <div class="news-card">
                        <?php if (!empty($noticia['imagen'])): ?>
                            <img src="<?php echo htmlspecialchars($noticia['imagen']); ?>" 
                                 alt="<?php echo htmlspecialchars($noticia['titulo']); ?>"
                                 class="news-card-image">
                        <?php endif; ?>
                        <div class="news-card-body">
                            <h3 class="news-card-title"><?php echo htmlspecialchars($noticia['titulo']); ?></h3>
                            <p class="news-card-description"><?php echo htmlspecialchars($noticia['descripcion']); ?></p>
                            <p class="news-card-date"><?php echo date('d/m/Y H:i', strtotime($noticia['fecha'])); ?></p>
                        </div>
                        <div class="news-card-footer">
                            <a href="noticia.php?id=<?php echo urlencode($noticia['uuid']); ?>" class="news-card-button">Ver más</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="error-message">Error: <?php echo htmlspecialchars($resultadoTecnologia['error']); ?></p>
            <?php if (isset($resultadoTecnologia['message'])): ?>
                <p class="error-details"><?php echo htmlspecialchars($resultadoTecnologia['message']); ?></p>
            <?php endif; ?>
        <?php endif; ?>

        <!---->
    </div>
</section>

<!-- Noticias Negocios -->
<section class="content-section" id="negocios">
    <h2 class="section-title">Negocios</h2>
    <div class="section-content">
        <!---->

        <?php if ($resultadoNegocios['success']): ?>
            <div class="news-grid">
                <?php foreach ($resultadoNegocios['data'] as $noticia): ?>
                    <div class="news-card">
                        <?php if (!empty($noticia['imagen'])): ?>
                            <img src="<?php echo htmlspecialchars($noticia['imagen']); ?>" 
                                 alt="<?php echo htmlspecialchars($noticia['titulo']); ?>"
                                 class="news-card-image">
                        <?php endif; ?>
                        <div class="news-card-body">
                            <h3 class="news-card-title"><?php echo htmlspecialchars($noticia['titulo']); ?></h3>
                            <p class="news-card-description"><?php echo htmlspecialchars($noticia['descripcion']); ?></p>
                            <p class="news-card-date"><?php echo date('d/m/Y H:i', strtotime($noticia['fecha'])); ?></p>
                        </div>
                        <div class="news-card-footer">
                            <a href="noticia.php?id=<?php echo urlencode($noticia['uuid']); ?>" class="news-card-button">Ver más</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="error-message">Error: <?php echo htmlspecialchars($resultadoNegocios['error']); ?></p>
            <?php if (isset($resultadoNegocios['message'])): ?>
                <p class="error-details"><?php echo htmlspecialchars($resultadoNegocios['message']); ?></p>
            <?php endif; ?>
        <?php endif; ?>

        <!---->
    </div>
</section>

<!-- Mercados (Acciones y Criptomonedas) -->
<div class="market-container" id="mercados">
    <section class="content-section market-box">
        <h2 class="section-title">Acciones</h2>
        <div class="section-content">
            <!---->

            <?php if ($resultadoAcciones['success']): ?>
                <div class="crypto-list">
                    <?php foreach ($resultadoAcciones['data'] as $accion): ?>
                        <div class="crypto-item">
                            <div class="crypto-info">
                                <h3 class="crypto-name"><?php echo htmlspecialchars($accion['nombre']); ?></h3>
                                <p class="crypto-type"><?php echo htmlspecialchars($accion['tipo']); ?></p>
                            </div>
                            <p class="crypto-price">$<?php echo number_format($accion['precio'], 2); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
                <p class="crypto-count">Total: <?php echo $resultadoAcciones['count']; ?> acciones</p>
            <?php else: ?>
                <p class="error-message">Error: <?php echo htmlspecialchars($resultadoAcciones['error']); ?></p>
                <?php if (isset($resultadoAcciones['message'])): ?>
                    <p class="error-details"><?php echo htmlspecialchars($resultadoAcciones['message']); ?></p>
                <?php endif; ?>
            <?php endif; ?>
            
            <!---->
        </div>
    </section>
    
    <section class="content-section market-box">
        <h2 class="section-title">Criptomonedas</h2>
        <div class="section-content">
            <!---->

            <?php if ($resultadoCriptos['success']): ?>
                <div class="crypto-list">
                    <?php foreach ($resultadoCriptos['data'] as $cripto): ?>
                        <div class="crypto-item">
                            <img src="<?php echo htmlspecialchars($cripto['imagen']); ?>" 
                                 alt="<?php echo htmlspecialchars($cripto['nombre']); ?>"
                                 class="crypto-image">
                            <div class="crypto-info">
                                <h3 class="crypto-name"><?php echo htmlspecialchars($cripto['nombre']); ?></h3>
                                <p class="crypto-type"><?php echo htmlspecialchars($cripto['tipo']); ?></p>
                            </div>
                            <p class="crypto-price">$<?php echo number_format($cripto['precio'], 2); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
                <p class="crypto-count">Total: <?php echo $resultadoCriptos['count']; ?> criptomonedas</p>
            <?php else: ?>
                <p class="error-message">Error: <?php echo htmlspecialchars($resultadoCriptos['error']); ?></p>
                <?php if (isset($resultadoCriptos['message'])): ?>
                    <p class="error-details"><?php echo htmlspecialchars($resultadoCriptos['message']); ?></p>
                <?php endif; ?>
            <?php endif; ?>

            <!---->
        </div>
    </section>
</div>

<?php

include_once '../includes/footer.php';


?>