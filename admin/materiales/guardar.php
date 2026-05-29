<?php
session_start();

include "../../includes/conexion.php";

$nombre   = isset($_POST['nombre']) ? $_POST['nombre'] : '';
$cantidad = isset($_POST['cantidad']) ? $_POST['cantidad'] : 0;

if (empty($nombre)) {
    $_SESSION['toast'] = [
        "tipo" => "error",
        "mensaje" => "El nombre del material es obligatorio."
    ];
    header("Location: ../dashboard.php");
    exit();
}

try {
    // Validar si existe
    $check = "SELECT * FROM materiales WHERE nombre='$nombre'";
    $result = $conn->query($check);

    if ($result && $result->num_rows > 0) {
        $_SESSION['toast'] = [
            "tipo" => "error",
            "mensaje" => "El material ya existe"
        ];
        header("Location: ../dashboard.php");
        exit();
    }

    // INSERT
    $sql = "INSERT INTO materiales (nombre, cantidad) VALUES ('$nombre', '$cantidad')";

    if ($conn->query($sql)) {
        $_SESSION['toast'] = [
            "tipo" => "success",
            "mensaje" => "Material agregado correctamente"
        ];
    } else {
        $_SESSION['toast'] = [
            "tipo" => "error",
            "mensaje" => "Error al guardar material"
        ];
    }

    header("Location: ../dashboard.php");
    exit();

} catch (Exception $e) {
    error_log("❌ Error en guardar material: " . $e->getMessage());
    $_SESSION['toast'] = [
        "tipo" => "error",
        "mensaje" => "Error interno en la base de datos."
    ];
    header("Location: ../dashboard.php");
    exit();
}
?>