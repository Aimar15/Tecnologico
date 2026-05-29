<?php
// conexion.php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // Si existe la variable interna de Railway, úsala
    if (getenv('MYSQLHOST')) {
        $servername = getenv('MYSQLHOST');
        $username   = getenv('MYSQLUSER');
        $password   = getenv('MYSQLPASSWORD');
        $database   = getenv('MYSQLDATABASE');
        $port       = getenv('MYSQLPORT');
    } else {
        // Datos locales para tu PC
        $servername = "zephyr.proxy.rlwy.net";
        $username   = "root";
        $password   = "cXjYZbfhHgvzRzTvhdxjzZvwAtnJfUsh";
        $database   = "railway";
        $port       = "53117";
    }

    $conn = new mysqli($servername, $username, $password, $database, $port);
    $conn->set_charset("utf8");

} catch (Exception $e) {
    // Guarda el error en el log interno del servidor y muestra algo limpio
    error_log("Error de Conexión BD: " . $e->getMessage());
    http_response_code(500);
    echo "Error interno en la conexión de la base de datos.";
    exit();
}
?>