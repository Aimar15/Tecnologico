<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] != 'docente') {
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Docente</title>

<link rel="stylesheet" href="/proyecto_servicio/assets/css/docente.css">

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

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>Docente</h2>

    <a onclick="showSection('mat')">Materiales</a>
    <a onclick="showSection('ped')">Pedir material</a>
    <a onclick="showSection('dev')">Devolver material</a>
    <a onclick="showSection('mov')">Movimientos</a>

    <a href="../logout.php" class="logout">Cerrar sesión</a>
</div>

<!-- MAIN -->
<div class="main">

<h1>Bienvenido <?php echo $_SESSION['usuario']; ?></h1>

<!-- MATERIAL -->
<div id="mat" class="section active">
    <?php include "materiales/listado.php"; ?>
</div>

<!-- PEDIR -->
<div id="ped" class="section">
    <?php include "pedidos/crear.php"; ?>
</div>

<!-- DEVOLVER -->
<div id="dev" class="section">
    <?php include "devoluciones/crear.php"; ?>
</div>

<!-- MOVIMIENTOS -->
<div id="mov" class="section">
    <?php include "movimientos/listado.php"; ?>
</div>

</div>

</body>
</html>