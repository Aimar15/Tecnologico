<?php
// Asegúrate de que no haya NINGÚN espacio en blanco o línea vacía ANTES de este <?php
session_start();
include "conexion.php";

// Verificar que los datos llegaron por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];
    $rol_form = $_POST['rol'];

    // NOTA: Tu consulta actual es vulnerable a SQL Injection. Para producción considera usar Prepared Statements.
    $sql = "SELECT * FROM usuarios WHERE usuario='$usuario' AND password='$password' AND rol='$rol_form'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows == 1) {
        $data = $result->fetch_assoc();

        $_SESSION['id_usuario'] = $data['id'];   
        $_SESSION['usuario'] = $data['usuario'];
        $_SESSION['rol'] = $data['rol'];

        // Cerramos la conexión antes de redireccionar
        $conn->close();

        if ($data['rol'] == "admin") {
            header("Location: ../admin/dashboard.php");
        } else {
            header("Location: ../docente/dashboard.php");
        }
        exit(); // Crucial para detener la ejecución del script aquí

    } else {
        // Si falla, en vez de un alert de JS que a veces bloquea el navegador en la nube,
        // es más seguro redirigir con un mensaje de error por URL
        header("Location: ../index.php?error=1");
        exit();
    }
} else {
    header("Location: ../index.php");
    exit();
}
?>