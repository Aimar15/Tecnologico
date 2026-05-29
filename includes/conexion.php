<?php
mysqli_report(MYSQLI_REPORT_OFF);

// Si existe MYSQLHOST (red interna de Railway), usa los datos internos. 
// Si NO existe (estás en tu PC local), usa los datos públicos externos de Railway.
if (getenv('MYSQLHOST')) {
    $servername = getenv('MYSQLHOST');
    $username   = getenv('MYSQLUSER');
    $password   = getenv('MYSQLPASSWORD');
    $database   = getenv('MYSQLDATABASE');
    $port       = getenv('MYSQLPORT'); // 3306 interno
} else {
    // Datos externos para cuando trabajes desde tu computadora local
    $servername = "zephyr.proxy.rlwy.net";
    $username   = "root";
    $password   = "cXjYZbfhHgvzRzTvhdxjzZvwAtnJfUsh";
    $database   = "railway";
    $port       = "53117"; // Puerto público externo
}

$conn = new mysqli($servername, $username, $password, $database, $port);

if ($conn->connect_error) {
    die("❌ Error de conexión a Railway: " . $conn->connect_error);
}

$conn->set_charset("utf8");
?>