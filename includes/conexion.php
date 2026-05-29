<?php

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    
    if (getenv('MYSQL_URL')) {
        $url = parse_url(getenv('MYSQL_URL'));
        $servername = $url["host"];
        $username   = $url["user"];
        $password   = $url["pass"];
        $database   = substr($url["path"], 1);
        $port       = $url["port"];
    } 
    
    elseif (getenv('MYSQLHOST')) {
        $servername = getenv('MYSQLHOST');
        $username   = getenv('MYSQLUSER');
        $password   = getenv('MYSQLPASSWORD');
        $database   = getenv('MYSQLDATABASE');
        $port       = getenv('MYSQLPORT') ? getenv('MYSQLPORT') : 3306;
    } 
    
    else {
        $servername = "zephyr.proxy.rlwy.net";
        $username   = "root";
        $password   = "cXjYZbfhHgvzRzTvhdxjzZvwAtnJfUsh";
        $database   = "railway";
        $port       = 53117;
    }

    $conn = new mysqli($servername, $username, $password, $database, $port);
    $conn->set_charset("utf8");

} catch (Exception $e) {
    
    error_log("❌ Error de conexión BD: " . $e->getMessage());
    http_response_code(500);
    echo "Error de conexión interna. Por favor, revisa los logs del servidor.";
    exit();
}
?>