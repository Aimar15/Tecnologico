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

$stmt = $conn->prepare("SELECT id, usuario, password FROM usuarios WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['toast'] = ["tipo" => "error", "mensaje" => "El correo no está registrado."];
    header("Location: ../index.php");
    exit();
}

$usuario = $result->fetch_assoc();
$nombre_usuario = $usuario['usuario'];
$password_actual = $usuario['password'];

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    // CAMBIO CLAVE: Usamos el host alternativo de Brevo con SSL nativo para evitar bloqueos
    $mail->Host       = 'smtp-relay.brevo.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'ace295001@smtp-brevo.com';
    $mail->Password   = 'cQME7wPNfqs3n2Cj';
    
    // Cambiamos a encriptación SSL implícita y puerto 465 (Abierto en Railway)
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 465;
    $mail->Timeout    = 10; // Evita que se quede congelado 30 segundos si falla
    $mail->CharSet    = 'UTF-8';

    $mail->setFrom('22690327@tecvalles.mx', 'Sistema de Control Escolar');
    $mail->addAddress($email, $nombre_usuario);
    $mail->addReplyTo('22690327@tecvalles.mx', 'Soporte');

    $mail->isHTML(true);
    $mail->Subject = 'Recordatorio de tus datos de acceso';
    
    $mail->Body    = "
        <html>
        <head>
            <meta charset='UTF-8'>
            <title>Recordatorio de Acceso</title>
        </head>
        <body style='margin: 0; padding: 0; background-color: #f8fafc; font-family: -apple-system, BlinkMacSystemFont, \"Segoe UI\", Roboto, Helvetica, Arial, sans-serif;'>
            <table width='100%' border='0' cellspacing='0' cellpadding='0' style='background-color: #f8fafc; padding: 40px 20px;'>
                <tr>
                    <td align='center'>
                        <table width='100%' max-width='550px' style='max-width: 550px; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05), 0 2px 4px -1px rgba(0,0,0,0.06); border: 1px solid #e2e8f0;' cellspacing='0' cellpadding='0'>
                            
                            <tr>
                                <td style='background-color: #0f172a; padding: 32px; text-align: center;'>
                                    <h1 style='margin: 0; color: #ffffff; font-size: 22px; font-weight: 600; letter-spacing: -0.5px;'>Sistema de Control</h1>
                                </td>
                            </tr>
                            
                            <tr>
                                <td style='padding: 40px 32px;'>
                                    <p style='margin: 0 0 16px 0; font-size: 16px; line-height: 24px; color: #334155;'>Hola, <strong style='color: #0f172a;'>{$nombre_usuario}</strong>,</p>
                                    <p style='margin: 0 0 24px 0; font-size: 15px; line-height: 24px; color: #475569;'>Has solicitado recordar tus credenciales de acceso vinculadas a esta dirección de correo electrónico. A continuación, se detallan tus datos de ingreso actuales:</p>
                                    
                                    <table width='100%' style='background-color: #f1f5f9; border-radius: 12px; border: 1px solid #e2e8f0;' cellspacing='0' cellpadding='16'>
                                        <tr>
                                            <td>
                                                <div style='font-size: 13px; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;'>Usuario</div>
                                                <div style='font-size: 16px; font-weight: 600; color: #0f172a; margin-bottom: 16px;'>{$nombre_usuario}</div>
                                                
                                                <div style='font-size: 13px; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;'>Contraseña</div>
                                                <div style='font-size: 18px; font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace; font-weight: 700; color: #16a34a; letter-spacing: 0.5px;'>{$password_actual}</div>
                                            </td>
                                        </tr>
                                    </table>
                                    
                                    <p style='margin: 32px 0 0 0; text-align: center;'>
                                        <a href='https://tecnologico-production.up.railway.app/' style='display: inline-block; background-color: #0f172a; color: #ffffff; padding: 12px 28px; font-size: 15px; font-weight: 500; text-decoration: none; border-radius: 8px; box-shadow: 0 1px 3px 0 rgba(0,0,0,0.1);'>Ir al Inicio de Sesión</a>
                                    </p>
                                </td>
                            </tr>
                            
                            <tr>
                                <td style='background-color: #f8fafc; padding: 24px 32px; border-top: 1px solid #f1f5f9; text-align: center;'>
                                    <p style='margin: 0; font-size: 13px; line-height: 20px; color: #94a3b8;'>Si tú no solicitaste esta información, puedes ignorar este correo de manera segura.</p>
                                </td>
                            </tr>
                            
                        </table>
                    </td>
                </tr>
            </table>
        </body>
        </html>
    ";

    $mail->send();
    $_SESSION['toast'] = ["tipo" => "success", "mensaje" => "Tus datos de acceso han sido enviados a tu correo."];

} catch (Exception $e) {
    error_log("❌ Error enviando correo por SMTP Seguro: " . $mail->ErrorInfo);
    $_SESSION['toast'] = ["tipo" => "error", "mensaje" => "No se pudo enviar el correo. Intenta más tarde."];
}

header("Location: ../index.php");
exit();