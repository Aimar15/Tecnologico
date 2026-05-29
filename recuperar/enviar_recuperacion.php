<?php
session_start();

include __DIR__ . "/../includes/conexion.php";
require __DIR__ . "/../vendor/autoload.php";

use Brevo\Client\Configuration;
use Brevo\Client\Api\TransactionalEmailsApi;
use Brevo\Client\Model\SendSmtpEmail;

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

$token = bin2hex(random_bytes(16));

$stmt = $conn->prepare("UPDATE usuarios SET token_recuperacion = ? WHERE id = ?");
$stmt->bind_param("si", $token, $usuario_id);
$stmt->execute();

$protocolo = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
$enlace_recuperacion = $protocolo . $_SERVER['HTTP_HOST'] . "/recuperar/cambiar_password.php?token=" . $token;

$config = Configuration::getDefaultConfiguration()->setApiKey('api-key', 'PON_AQUÍ_TU_LLAVE_LARGA_XKEYSIB');
$apiInstance = new TransactionalEmailsApi(null, $config);

$sendSmtpEmail = new SendSmtpEmail([
    'subject' => 'Recuperación de Contraseña - Sistema de Control',
    'htmlContent' => "
        <html>
        <head><title>Recuperar Contraseña</title></head>
        <body style='font-family: Arial, sans-serif; line-height: 1.6; color: #333;'>
            <h2>Hola, {$nombre_usuario}</h2>
            <p>Has solicitado restablecer tu contraseña. Para continuar, haz clic en el siguiente enlace:</p>
            <p style='margin: 20px 0;'>
                <a href='{$enlace_recuperacion}' style='background-color: #0f172a; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold;'>
                    Restablecer Contraseña
                </a>
            </p>
            <p>Si el botón no funciona, copia y pega este enlace en tu navegador:</p>
            <p>{$enlace_recuperacion}</p>
            <br>
            <hr style='border: none; border-top: 1px solid #eee;'>
            <p style='font-size: 12px; color: #777;'>Si no solicitaste este cambio, puedes ignorar este correo de forma segura.</p>
        </body>
        </html>
    ",
    'sender' => ['name' => 'Cesar Aimar Ortiz Belmares', 'email' => '22690327@tecvalles.mx'],
    'to' => [['email' => $email, 'name' => $nombre_usuario]],
    'replyTo' => ['email' => '22690327@tecvalles.mx', 'name' => 'Soporte']
]);

try {
    $apiInstance->sendTransacEmail($sendSmtpEmail);
    $_SESSION['toast'] = ["tipo" => "success", "mensaje" => "Enlace de recuperación enviado a tu correo."];
} catch (Exception $e) {
    error_log("❌ Error enviando correo por Brevo: " . $e->getMessage());
    $_SESSION['toast'] = ["tipo" => "error", "mensaje" => "No se pudo enviar el correo. Intenta más tarde."];
}

header("Location: ../index.php");
exit();