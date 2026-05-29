<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Iniciar Sesión</title>

<link rel="stylesheet" href="../../assets/css/login.css">

</head>

<body>

<div class="login-container">

    <h1 class="titulo">
        Sistema de registro ambiental
    </h1>

    <div class="login-tabs">

        <button 
            type="button"
            class="tab-btn active"
            data-role="docente">

            Docente

        </button>

        <button 
            type="button"
            class="tab-btn"
            data-role="admin">

            Administrador

        </button>

    </div>

<form action="../../includes/login_validar.php" method="POST">

    <input 
        type="hidden"
        name="rol"
        id="rol"
        value="docente"
    >

    <div class="input-group">

        <label>Usuario</label>

        <input 
            type="text"
            name="usuario"
            required
        >

    </div>

    <div class="input-group">

        <label>Contraseña</label>

        <input 
            type="password"
            name="password"
            required
        >

    </div>

    <button type="submit" class="btn-login">

        Iniciar sesión

    </button>

</form>

<div class="recuperar">

  <a href="../../includes/recuperar.php">
    ¿Olvidaste tu usuario o contraseña?
</a>

</div>

</div>

<script>

const botones = document.querySelectorAll(".tab-btn");

const inputRol = document.getElementById("rol");

botones.forEach(btn => {

    btn.addEventListener("click", () => {

        botones.forEach(b => b.classList.remove("active"));

        btn.classList.add("active");

        inputRol.value = btn.dataset.role;
    });

});

</script>

</body>
</html>