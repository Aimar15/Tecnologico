<?php
session_start();

include "../../includes/conexion.php";

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../../index.php");
    exit();
}

$usuario_id = $_SESSION['id_usuario'];
$usuario = $_SESSION['usuario'];

$material = trim($_POST['material'] ?? '');
$cantidad = intval($_POST['cantidad'] ?? 0);
$fecha_prestamo = $_POST['fecha_prestamo'] ?? '';
$fecha_reserva = $_POST['fecha_reserva'] ?? '';
$fecha_devolucion = $_POST['fecha_devolucion'] ?? '';

if ($material == '' || $cantidad <= 0 || $fecha_prestamo == '') {
    $_SESSION['toast'] = [
        "tipo" => "error",
        "mensaje" => "Completa todos los campos obligatorios"
    ];
    header("Location: ../dashboard.php");
    exit();
}

$stmt = $conn->prepare("SELECT id, cantidad FROM materiales WHERE nombre = ?");
$stmt->bind_param("s", $material);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    $_SESSION['toast'] = [
        "tipo" => "error",
        "mensaje" => "El material no existe"
    ];
    header("Location: ../dashboard.php");
    exit();
}

$row = $result->fetch_assoc();
$material_id = $row['id'];
$stock_actual = intval($row['cantidad']);

if ($stock_actual < $cantidad) {
    $_SESSION['toast'] = [
        "tipo" => "error",
        "mensaje" => "Stock insuficiente"
    ];
    header("Location: ../dashboard.php");
    exit();
}

$nuevoStock = $stock_actual - $cantidad;
$stmt = $conn->prepare("UPDATE materiales SET cantidad = ? WHERE id = ?");
$stmt->bind_param("ii", $nuevoStock, $material_id);
$stmt->execute();

$estado = (!empty($fecha_reserva)) ? 'reservado' : 'prestado';

$stmt = $conn->prepare("
INSERT INTO prestamos
(usuario_id, material_id, fecha_prestamo, fecha_devolucion, fecha_reserva, estado, material, cantidad)
VALUES (?, ?, ?, ?, ?, ?, ?, ?)
");

$stmt->bind_param(
    "iisssssi",
    $usuario_id,
    $material_id,
    $fecha_prestamo,
    $fecha_devolucion,
    $fecha_reserva,
    $estado,
    $material,
    $cantidad
);

if ($stmt->execute()) {
    $_SESSION['toast'] = [
        "tipo" => "success",
        "mensaje" => "Préstamo registrado correctamente"
    ];
} else {
    $_SESSION['toast'] = [
        "tipo" => "error",
        "mensaje" => "Error al guardar el préstamo"
    ];
}

header("Location: ../dashboard.php");
exit();
?>