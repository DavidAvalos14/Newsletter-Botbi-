<?php

include_once '../includes/header.php';
require_once '../api/mercados/criptosbd.php';

// Obtener criptomonedas de la base de datos
$criptoBD = new CriptoBD();
$resultadoCriptos = $criptoBD->obtenerCriptomonedas();

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