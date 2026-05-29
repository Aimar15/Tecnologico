<?php
// Desactivar el reporte estricto para capturar nosotros los errores limpiamente
mysqli_report(MYSQLI_REPORT_OFF);

// Credenciales fijas de tu base de datos en Railway
$servername = "zephyr.proxy.rlwy.net";
$username   = "root";
$password   = "cXjYZbfhHgvzRzTvhdxjzZvwAtnJfUsh";
$database   = "railway";
$port       = "53117";

// Crear la conexión con la nube
$conn = new mysqli($servername, $username, $password, $database, $port);

// Verificar si la conexión falló
if ($conn->connect_error) {
    die("❌ Error crítico: No se pudo conectar a la base de datos de Railway. Detalle: " . $conn->connect_error);
}

// Configurar caracteres en español
$conn->set_charset("utf8");
?>