<?php
session_start(); 

include "../../includes/conexion.php";

$id = isset($_GET['id']) ? $_GET['id'] : null;

if (!$id) {
    header("Location: ../dashboard.php");
    exit();
}

try {
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

    // Guardar un mensaje de éxito para la vista (opcional, combina con tu sistema Toast)
    $_SESSION['toast'] = [
        "tipo" => "success",
        "mensaje" => "Usuario eliminado correctamente"
    ];

    // Regresar al dashboard
    header("Location: ../dashboard.php");
    exit();

} catch (Exception $e) {
    error_log("❌ Error en eliminar.php: " . $e->getMessage());
    header("Location: ../dashboard.php?error=no_se_pudo_eliminar");
    exit();
}
?>