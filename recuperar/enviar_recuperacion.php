<?php
session_start();

include __DIR__ . "/../includes/conexion.php";
require __DIR__ . "/../vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

if (!$email) {
    $_SESSION['toast'] = ["tipo" => "error", "mensaje" => "Correo electrónico no válido."];
    header("Location: ../index.php");
    exit();
}

$stmt = $conn->prepare("SELECT id, usuario FROM usuarios WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['toast'] = ["tipo" => "error", "mensaje" => "El correo no está registrado."];
    header("Location: ../index.php");
    exit();
}

$usuario = $result->fetch_assoc();
$usuario_id = $usuario['id'];
$nombre_usuario = $usuario['usuario'];

$caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
$nueva_password = '';
for ($i = 0; $i < 8; $i++) {
    $nueva_password .= $caracteres[rand(0, strlen($caracteres) - 1)];
}

$stmt = $conn->prepare("UPDATE usuarios SET password = ?, token_recuperacion = NULL WHERE id = ?");
$stmt->bind_param("si", $nueva_password, $usuario_id);
$stmt->execute();

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = 'smtp-relay.brevo.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'ace295001@smtp-brevo.com';
    $mail->Password   = 'cQME7wPNfqs3n2Cj';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;
    $mail->CharSet    = 'UTF-8';

    $mail->setFrom('22690327@tecvalles.mx', 'Cesar Aimar Ortiz Belmares');
    $mail->addAddress($email, $nombre_usuario);
    $mail->addReplyTo('22690327@tecvalles.mx', 'Soporte');

    $mail->isHTML(true);
    $mail->Subject = 'Nueva contraseña de acceso - Sistema de Control';
    $mail->Body    = "
        <html>
        <head><title>Nueva Contraseña</title></head>
        <body style='font-family: Arial, sans-serif; line-height: 1.6; color: #333;'>
            <h2>Hola, {$nombre_usuario}</h2>
            <p>Se ha generado una nueva contraseña temporal para tu cuenta asociada al correo <strong>{$email}</strong>.</p>
            <p>Tu nueva contraseña de acceso es:</p>
            <p style='margin: 20px 0;'>
                <span style='background-color: #f1f5f9; color: #0f172a; padding: 10px 20px; font-size: 18px; font-family: monospace; border-radius: 5px; font-weight: bold; border: 1px dashed #cbd5e1;'>
                    {$nueva_password}
                </span>
            </p>
            <p>Usa esta contraseña para iniciar sesión. Te recomendamos cambiarla desde tu perfil una vez dentro del sistema.</p>
            <br>
            <hr style='border: none; border-top: 1px solid #eee;'>
            <p style='font-size: 12px; color: #777;'>Si tú no solicitaste este cambio, por favor ponte en contacto con el administrador.</p>
        </body>
        </html>
    ";

    $mail->send();
    $_SESSION['toast'] = ["tipo" => "success", "mensaje" => "Se ha enviado una nueva contraseña a tu correo."];

} catch (Exception $e) {
    error_log("❌ Error enviando correo por SMTP: " . $mail->ErrorInfo);
    $_SESSION['toast'] = ["tipo" => "error", "mensaje" => "No se pudo enviar el correo. Intenta más tarde."];
}

header("Location: ../index.php");
exit();