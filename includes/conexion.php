<?php
// Detectar automáticamente si estamos en Railway o en Localhost (XAMPP)
$servername = getenv('MYSQLHOST') ?: "localhost";
$username   = getenv('MYSQLUSER') ?: "root";
$password   = getenv('MYSQLPASSWORD') ?: "";
$database   = getenv('MYSQLDATABASE') ?: "servicio";
$port       = getenv('MYSQLPORT') ?: "3306";

// Crear la conexión incluyendo el puerto (fundamental para Railway)
$conn = new mysqli($servername, $username, $password, $database, $port);

if ($conn->connect_error) {
    die("❌ Error de conexión: " . $conn->connect_error);
}

$conn->set_charset("utf8");
?>