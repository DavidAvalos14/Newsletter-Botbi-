    </main>
    
    <footer class="footer">
        <div class="footer-content">
            <div class="auth-section">
                <?php if (isset($_SESSION['user_email'])): ?>
                    <div class="user-info">
                        <p>Conectado como: <strong><?php echo htmlspecialchars($_SESSION['user_email']); ?></strong></p>
                        <a href="logout.php" class="btn-logout">Cerrar Sesión</a>
                    </div>
                <?php else: ?>
                    <form action="auth.php" method="POST" class="auth-form">
                        <h3>Regístrate / Inicia Sesión</h3>
                        <div class="form-group">
                            <input type="email" name="email" placeholder="Email" required>
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" placeholder="Contraseña" required>
                        </div>
                        <button type="submit" name="action" value="login" class="btn-auth">Iniciar Sesión</button>
                        <button type="submit" name="action" value="register" class="btn-auth btn-register">Registrarse</button>
                    </form>
                <?php endif; ?>
            </div>
            
            <div class="footer-info">
                <p class="author-label">Conoce más sobre el autor:</p>
                <a href="https://davidavalos14.github.io/Portafolio" class="author-link" target="_blank">Angel David Avalos Carrillo</a>
            </div>
        </div>
    </footer>
</body>
</html>
