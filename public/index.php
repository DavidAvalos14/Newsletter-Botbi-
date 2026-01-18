<?php

include_once '../includes/header.php';
require_once '../api/mercados/criptosbd.php';
require_once '../api/mercados/accionesbd.php';

// Obtener criptomonedas de la base de datos
$criptoBD = new CriptoBD();
$resultadoCriptos = $criptoBD->obtenerCriptomonedas();

// Obtener acciones de la base de datos
$accionesBD = new AccionesBD();
$resultadoAcciones = $accionesBD->obtenerAcciones();

?>

<!-- Noticias Tecnología -->
<section class="content-section">
    <h2 class="section-title">Tecnología</h2>
    <div class="section-content">
    </div>
</section>

<!-- Noticias Negocios -->
<section class="content-section">
    <h2 class="section-title">Negocios</h2>
    <div class="section-content">
    </div>
</section>

<!-- Mercados (Acciones y Criptomonedas) -->
<div class="market-container">
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