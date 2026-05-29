<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/* ===== PHPMailer ===== */
require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';

/* ===== CONEXIÓN ===== */
include "../includes/conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST['email']);

    /* ===== BUSCAR USUARIO ===== */
    $sql = "SELECT * FROM usuarios WHERE email='$email'";

    $resultado = $conn->query($sql);

    if($resultado && $resultado->num_rows > 0){

        /* ===== TOKEN ===== */
        $token = md5(uniqid(rand(), true));

        /* ===== GUARDAR TOKEN ===== */
        $conn->query("
            UPDATE usuarios
            SET token_recuperacion='$token'
            WHERE email='$email'
        ");

        /* ===== LINK ===== */
        $link = "http://localhost/proyecto_servicio/recuperar/restablecer.php?token=$token";

        /* ===== PHPMailer ===== */
        $mail = new PHPMailer(true);

        try {

 $mail->isSMTP();

$mail->Host = 'smtp.gmail.com';

$mail->SMTPAuth = true;

$mail->Username = 'alcatel1287@gmail.com';

$mail->Password = 'uxdd iuhl hczd vsom';

$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

$mail->Port = 587;

$mail->CharSet = 'UTF-8';

$mail->setFrom(
    'alcatel1287@gmail.com',
    'Sistema Ambiental'
);

            /* ===== DESTINO ===== */
            $mail->addAddress($email);

            /* ===== CONTENIDO ===== */
            $mail->isHTML(true);

            $mail->Subject = 'Recuperación de contraseña';

            $mail->Body = "
                <div style='font-family: Arial'>

                    <h2>Recuperación de contraseña</h2>

                    <p>
                        Haz clic en el siguiente botón:
                    </p>

                    <a href='$link'
                    style='
                        background:#16a34a;
                        color:white;
                        padding:12px 20px;
                        text-decoration:none;
                        border-radius:5px;
                        display:inline-block;
                    '>

                        Recuperar contraseña

                    </a>

                    <br><br>

                    <small>
                        Si no solicitaste el cambio,
                        ignora este correo.
                    </small>

                </div>
            ";

            /* ===== DEBUG ===== */
            $mail->SMTPDebug = 2;

            /* ===== ENVIAR ===== */
            $mail->send();

            echo "
            <script>

                alert('Correo enviado correctamente');

                window.location='../index.php';

            </script>
            ";

        } catch (Exception $e) {

            echo "
            <h3>Error SMTP</h3>

            {$mail->ErrorInfo}
            ";
        }

    } else {

        echo "
        <script>

            alert('Correo no encontrado');

            window.history.back();

        </script>
        ";
    }
}
?>