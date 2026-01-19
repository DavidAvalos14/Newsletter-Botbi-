<?php
session_start();
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../api/newsletter/newsletter.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
$password = $_POST['password'] ?? '';
$action = $_POST['action'] ?? '';

if (empty($email) || empty($password)) {
    $_SESSION['error'] = 'Email y contraseña son requeridos';
    header('Location: index.php');
    exit;
}

try {
    $database = new Database();
    $pdo = $database->connect();
    
    if ($action === 'register') {
        // Registro
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO suscriptores (subs_email, subs_password) VALUES (:email, :password)";
        $stmt = $pdo->prepare($sql);
        
        try {
            $stmt->execute([
                ':email' => $email,
                ':password' => $hashedPassword
            ]);
            
            // Enviar newsletter de bienvenida al nuevo suscriptor
            $htmlContent = generarNewsletterHTML();
            $resultadoEmail = enviarEmail(
                $email,
                '📰 Bienvenido a Avalos News - Tu Newsletter',
                $htmlContent
            );
            
            $_SESSION['user_email'] = $email;
            if ($resultadoEmail['success']) {
                $_SESSION['success'] = 'Registro exitoso. ¡Te hemos enviado un newsletter de bienvenida!';
            } else {
                $_SESSION['success'] = 'Registro exitoso. Bienvenido!';
            }
            header('Location: index.php');
            exit;
        } catch (PDOException $e) {
            if (strpos($e->getMessage(), 'duplicate key') !== false) {
                $_SESSION['error'] = 'Este email ya está registrado. Intenta iniciar sesión.';
            } else {
                $_SESSION['error'] = 'Error al registrar: ' . $e->getMessage();
            }
            header('Location: index.php');
            exit;
        }
        
    } elseif ($action === 'login') {
        // Login
        $sql = "SELECT subs_email, subs_password FROM suscriptores WHERE subs_email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($password, $user['subs_password'])) {
            $_SESSION['user_email'] = $user['subs_email'];
            $_SESSION['success'] = 'Inicio de sesión exitoso';
            header('Location: index.php');
            exit;
        } else {
            $_SESSION['error'] = 'Email o contraseña incorrectos';
            header('Location: index.php');
            exit;
        }
    } else {
        $_SESSION['error'] = 'Acción no válida';
        header('Location: index.php');
        exit;
    }
    
} catch (Exception $e) {
    $_SESSION['error'] = 'Error de conexión: ' . $e->getMessage();
    header('Location: index.php');
    exit;
}
?>
