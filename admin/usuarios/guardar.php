<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . "/proyecto_servicio/includes/conexion.php";

$usuario = $_POST['usuario'];
$password = $_POST['password'];
$rol = $_POST['rol'];

/* VALIDAR SI YA EXISTE */
$sql = "SELECT * FROM usuarios WHERE usuario='$usuario'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

    $_SESSION['toast'] = [
        "tipo" => "error",
        "mensaje" => "El usuario ya existe"
    ];

    header("Location: ../dashboard.php");
    exit();

} else {

    $conn->query("INSERT INTO usuarios (usuario, password, rol)
    VALUES ('$usuario','$password','$rol')");

    $_SESSION['toast'] = [
        "tipo" => "success",
        "mensaje" => "Usuario creado correctamente"
    ];

    header("Location: ../dashboard.php");
    exit();
}
?>