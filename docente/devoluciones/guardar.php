<?php
session_start();
include "../../includes/conexion.php";

$usuario_id = $_SESSION['id_usuario'];
$usuario = $_SESSION['usuario'];

$prestamo_id = intval($_POST['prestamo_id']);
$material = $_POST['material'];
$cantidad = intval($_POST['cantidad']);
$fecha = $_POST['fecha_devolucion'];
$observaciones = trim($_POST['observaciones'] ?? '');

$stmt = $conn->prepare("SELECT cantidad FROM prestamos WHERE id=?");
$stmt->bind_param("i",$prestamo_id);
$stmt->execute();
$prestamo = $stmt->get_result()->fetch_assoc();

if($cantidad > $prestamo['cantidad']){
    die("No puedes devolver más de lo prestado");
}

$stmt = $conn->prepare("SELECT cantidad FROM materiales WHERE nombre=?");
$stmt->bind_param("s",$material);
$stmt->execute();
$mat = $stmt->get_result()->fetch_assoc();

$nuevo = $mat['cantidad'] + $cantidad;

$stmt = $conn->prepare("UPDATE materiales SET cantidad=? WHERE nombre=?");
$stmt->bind_param("is",$nuevo,$material);
$stmt->execute();

$stmt = $conn->prepare("UPDATE prestamos SET estado='devuelto' WHERE id=?");
$stmt->bind_param("i",$prestamo_id);
$stmt->execute();

$tipo = "devolucion";
$desc = "Devolvió $cantidad de $material";
if($observaciones != ''){
    $desc .= " | Obs: $observaciones";
}

$stmt = $conn->prepare("
INSERT INTO reportes(usuario_id,usuario,material,tipo,descripcion,fecha)
VALUES (?,?,?,?,?,NOW())
");

$stmt->bind_param("issss",$usuario_id,$usuario,$material,$tipo,$desc);
$stmt->execute();

header("Location: ../dashboard.php");
exit();
?>