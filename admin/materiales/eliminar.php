<?php
include $_SERVER['DOCUMENT_ROOT'] . "../../includes/conexion.php";

$id = $_GET['id'];

$sql = "DELETE FROM materiales WHERE id=$id";
$conn->query($sql);

header("Location: ../dashboard.php");
exit();
?>