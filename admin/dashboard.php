<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

include "../includes/conexion.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Admin</title>
<link rel="stylesheet" href="../assets/css/admin.css">

<style>
.section { display: none; }
.section.active { display: block; }
</style>

<script>
function showSection(id) {
    document.querySelectorAll('.section').forEach(s => s.classList.remove('active'));
    document.getElementById(id).classList.add('active');
}
</script>

</head>
<?php if (session_status() === PHP_SESSION_NONE) { session_start(); } ?>

<?php if (isset($_SESSION['mensaje'])) { ?>
<div id="toast" class="toast">
    <?php echo $_SESSION['mensaje']; ?>
</div>

<script>
let toast = document.getElementById("toast");
toast.classList.add("show");

setTimeout(() => {
    toast.classList.remove("show");
}, 3000);
</script>

<?php unset($_SESSION['mensaje']); ?>
<?php } ?>

<body>

<div class="sidebar">
    <h2>Administrador</h2>

    <h3>Usuarios</h3>
    <a onclick="showSection('addUser')">Añadir Usuario</a>
    <a onclick="showSection('listUser')">Listado Usuarios</a>

    <h3>Materiales</h3>
    <a onclick="showSection('addMat')">Añadir Material</a>
    <a onclick="showSection('listMat')">Listado Material</a>

    <h3>Reportes</h3>
    <a onclick="showSection('rep')">Ver Reportes</a>

    <a href="../logout.php" class="logout">Cerrar sesión</a>
</div>

<div class="main">

    <h1>Bienvenido, <?php echo $_SESSION['usuario']; ?></h1>

    <!-- USUARIOS -->
    <div id="addUser" class="section active">
        <h2>Añadir Usuario</h2>

        <form action="usuarios/guardar.php" method="POST">
            <input type="text" name="usuario" placeholder="Usuario" required><br><br>
            <input type="text" name="password" placeholder="Contraseña" required><br><br>

            <select name="rol">
                <option value="admin">Admin</option>
                <option value="docente">Docente</option>
            </select><br><br>

            <button>Guardar</button>
        </form>
    </div>

    <!-- LISTADO USUARIOS (CORREGIDO) -->
    <div id="listUser" class="section">
        <?php include "usuarios/listado.php"; ?>
    </div>

    <!-- MATERIALES -->
    <div id="addMat" class="section">
        <h2>Añadir Material</h2>

        <form action="materiales/guardar.php" method="POST">
            <input type="text" name="nombre" placeholder="Material" required><br><br>
            <input type="number" name="cantidad" placeholder="Cantidad" required><br><br>

            <button>Guardar</button>
        </form>
    </div>

    <div id="listMat" class="section">
        <?php include "materiales/listado.php"; ?>
    </div>

    <!-- REPORTES -->
    <div id="rep" class="section">
        <?php include "reportes/listado.php"; ?>
    </div>

</div>

</body>
</html>