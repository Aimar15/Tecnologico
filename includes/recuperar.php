<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Recuperar acceso</title>

<link rel="stylesheet" href="../../assets/css/recuperacion.css">

</head>

<body>

<div class="login-container">

    <img 
        src="../../assets/img/logo.jpg"
        alt="Logo"
        class="logo"
    >

    <h2>
        Recuperar Contraseña
    </h2>

    <form 
        action="../../recuperar/enviar_recuperacion.php"
        method="POST"
    >

        <div class="input-group">

            <label for="email">
                Correo electrónico
            </label>

            <input 
                type="email"
                id="email"
                name="email"
                placeholder="Ingresa tu correo"
                required
            >

        </div>

        <button type="submit" class="btn-login">

            Solicitar recuperación

        </button>

    </form>

    <div class="recuperar">

        <a href="../../index.php">

            Volver al inicio

        </a>

    </div>

</div>

</body>
</html>