<?php
session_start();
include "conexion.php";

$usuario = $_POST['usuario'];
$password = $_POST['password'];
$rol_form = $_POST['rol'];

$sql = "SELECT * FROM usuarios 
        WHERE usuario='$usuario' 
        AND password='$password' 
        AND rol='$rol_form'";

$result = $conn->query($sql);

if ($result->num_rows == 1) {

    $data = $result->fetch_assoc();

    $_SESSION['id_usuario'] = $data['id'];   // 🔥 AÑADIDO (IMPORTANTE)
    $_SESSION['usuario'] = $data['usuario'];
    $_SESSION['rol'] = $data['rol'];

    if ($data['rol'] == "admin") {
        header("Location: ../admin/dashboard.php");
    } else {
        header("Location: ../docente/dashboard.php");
    }

    exit();

} else {
    echo "<script>
        alert('Usuario o contraseña incorrectos');
        window.location.href='../index.php';
    </script>";
}
?>