<?php
session_start();

include __DIR__ . "/../includes/conexion.php";

$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

if (!$email) {
    $_SESSION['toast'] = ["tipo" => "error", "mensaje" => "Correo electrónico no válido."];
    header("Location: ../index.php");
    exit();
}

// Buscamos las credenciales actuales del usuario sin alterar nada
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

// Diseño profesional estilo Cuadro Blanco
$htmlFinal = "
<div style='width: 100%; max-width: 600px; margin: 40px auto; border: 1px solid #e5e7eb; font-family: sans-serif; border-radius: 15px; overflow: hidden; background-color: #ffffff; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);'>
    <div style='background: #111827; padding: 25px; text-align: center;'>
        <span style='color: white; font-size: 20px; font-weight: bold; letter-spacing: 2px;'>SISTEMA DE CONTROL ESCOLAR</span>
    </div>
    <div style='padding: 35px 30px;'>
        <p style='color: #1f2937; font-size: 16px; font-weight: bold; margin-bottom: 20px;'>Hola, {$nombre_usuario}:</p>
        <p style='color: #4b5563; font-size: 15px; line-height: 1.6; margin: 0 0 25px 0;'>
            Has solicitado recordar tus credenciales de acceso vinculadas a esta dirección de correo electrónico. A continuación, se detallan tus datos de ingreso actuales:
        </p>
        
        <div style='background-color: #f9fafb; border: 1px solid #e5e7eb; border-radius: 10px; padding: 20px; margin-bottom: 30px;'>
            <div style='margin-bottom: 12px;'>
                <span style='color: #9ca3af; font-size: 12px; text-transform: uppercase; font-weight: bold;'>Usuario</span>
                <div style='color: #111827; font-size: 16px; font-weight: bold;'>{$nombre_usuario}</div>
            </div>
            <div>
                <span style='color: #9ca3af; font-size: 12px; text-transform: uppercase; font-weight: bold;'>Contraseña</span>
                <div style='color: #16a34a; font-size: 18px; font-family: monospace; font-weight: bold;'>{$password_actual}</div>
            </div>
        </div>

        <div style='text-align: center; margin-top: 15px;'>
            <a href='https://tecnologico-production.up.railway.app/' style='display: inline-block; background: #111827; color: white; padding: 12px 30px; border-radius: 8px; text-decoration: none; font-size: 15px; font-weight: bold;'>
                Ir al Inicio de Sesión
            </a>
        </div>
    </div>
    <div style='padding: 20px; background: #f9fafb; text-align: center; color: #9ca3af; font-size: 12px; border-top: 1px solid #f3f4f6;'>
        © 2026 Sistema de Control Escolar | Sede: General<br>
        Este es un correo informativo, por favor no respondas a este mensaje.
    </div>
</div>
";

$emailPayload = [
    "sender" => ["name" => "Sistema de Control", "email" => "22690327@tecvalles.mx"],
    "to" => [["email" => $email, "name" => $nombre_usuario]],
    "subject" => "Recordatorio de tus datos de acceso",
    "htmlContent" => $htmlFinal
];

// Tu clave integrada para autorizar la petición HTTP
$brevo_api_key = 'xsmtpsib-0ddc453594f9e7021e0bf9ce3d95f74f1e5a6691781cfc66ad10e8c0ab4be3d5-ziKdAzIp8I73J9Ha'; 

$ch = curl_init('https://api.brevo.com/v3/smtp/email');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($emailPayload));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'accept: application/json',
    'api-key: ' . $brevo_api_key,
    'content-type: application/json'
]);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($http_code === 201 || $http_code === 200) {
    $_SESSION['toast'] = ["tipo" => "success", "mensaje" => "Tus datos de acceso han sido enviados a tu correo."];
} else {
    error_log("❌ Error en API Brevo. Código: " . $http_code . " Resp: " . $response);
    $_SESSION['toast'] = ["tipo" => "error", "mensaje" => "No se pudo enviar el correo. Intenta más tarde."];
}

header("Location: ../index.php");
exit();