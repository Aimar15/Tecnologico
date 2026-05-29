<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: /proyecto_servicio/index.php");
    exit();
}
?>