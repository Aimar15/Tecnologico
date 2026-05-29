<?php
include $_SERVER['DOCUMENT_ROOT'] . "../../includes/conexion.php";

$id = $_GET['id'];

// Validar que venga un ID
if (!isset($id)) {
    header("Location: ../dashboard.php");
    exit();
}

// Evitar borrar admin por seguridad básica (opcional pero recomendado)
$check = "SELECT rol FROM usuarios WHERE id=$id";
$result = $conn->query($check);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();

    if ($row['rol'] == 'admin') {
        echo "<script>
            alert('No puedes eliminar un administrador');
            window.location.href='../dashboard.php';
        </script>";
        exit();
    }
}

// Eliminar usuario
$sql = "DELETE FROM usuarios WHERE id=$id";
$conn->query($sql);

// Regresar al dashboard
header("Location: ../dashboard.php");
exit();
?>