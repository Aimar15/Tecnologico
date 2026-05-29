<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . "../../includes/conexion.php";

$nombre = $_POST['nombre'];
$cantidad = $_POST['cantidad'];

// Validar si existe
$check = "SELECT * FROM materiales WHERE nombre='$nombre'";
$result = $conn->query($check);

if ($result->num_rows > 0) {

    $_SESSION['toast'] = [
        "tipo" => "error",
        "mensaje" => "El material ya existe"
    ];

    header("Location: ../dashboard.php");
    exit();
}

// INSERT
$sql = "INSERT INTO materiales (nombre, cantidad)
        VALUES ('$nombre', '$cantidad')";

if ($conn->query($sql)) {

    $_SESSION['toast'] = [
        "tipo" => "success",
        "mensaje" => "Material agregado correctamente"
    ];

    header("Location: ../dashboard.php");
    exit();

} else {

    $_SESSION['toast'] = [
        "tipo" => "error",
        "mensaje" => "Error al guardar material"
    ];

    header("Location: ../dashboard.php");
    exit();
}
?>