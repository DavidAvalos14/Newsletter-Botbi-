<?php

// Cargar PHPMailer manualmente desde la carpeta local
require_once __DIR__ . '/PHPMailer/Exception.php';
require_once __DIR__ . '/PHPMailer/PHPMailer.php';
require_once __DIR__ . '/PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function enviarEmail($destinatario, $asunto, $contenido) {
    $mail = new PHPMailer(true);
    
    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'newsavalos@gmail.com';
        $mail->Password   = 'seln suwo hygp yaoo';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        
        // Configuración del correo
        $mail->setFrom('newsavalos@gmail.com', 'Avalos News');
        $mail->addAddress($destinatario);
        $mail->isHTML(true);
        $mail->Subject = $asunto;
        $mail->Body    = $contenido;
        $mail->CharSet = 'UTF-8';
        
        $mail->send();
        return ['success' => true, 'message' => 'Correo enviado exitosamente'];
        
    } catch (Exception $e) {
        return ['success' => false, 'message' => "Error al enviar: {$mail->ErrorInfo}"];
    }
}
?>