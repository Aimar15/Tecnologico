<?php
session_start();
include "conexion.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = isset($_POST['usuario']) ? $_POST['usuario'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $rol_form = isset($_POST['rol']) ? $_POST['rol'] : '';

    // Consulta básica (Recuerda que las tablas ya se llaman en minúsculas)
    $sql = "SELECT * FROM usuarios WHERE usuario='$usuario' AND password='$password' AND rol='$rol_form'";
    $result = $conn->query($sql);

    // Si hay un error en las tablas o columnas, esto romperá el Error 500 y te dirá qué falta
    if (!$result) {
        die("❌ Error en la consulta SQL: " . $conn->error);
    }

    if ($result->num_rows == 1) {
        $data = $result->fetch_assoc();

        $_SESSION['id_usuario'] = $data['id'];   
        $_SESSION['usuario'] = $data['usuario'];
        $_SESSION['rol'] = $data['rol'];

        $conn->close();

        if ($data['rol'] == "admin") {
            header("Location: ../../admin/dashboard.php");
        } else {
            header("Location: ../../docente/dashboard.php");
        }
        exit();

    } else {
        header("Location: ../../index.php?error=1");
        exit();
    }
} else {
    header("Location: ../../index.php");
    exit();
}
?>