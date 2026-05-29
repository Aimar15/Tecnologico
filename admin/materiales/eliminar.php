<?php
session_start(); 

include "../../includes/conexion.php";


$id = isset($_GET['id']) ? $_GET['id'] : null;

if (!$id) {
    header("Location: ../dashboard.php");
    exit();
}

try {
    
    $sql = "DELETE FROM materiales WHERE id=$id";
    $conn->query($sql);

    
    $_SESSION['toast'] = [
        "tipo" => "success",
        "mensaje" => "Material eliminado correctamente"
    ];

    header("Location: ../dashboard.php");
    exit();

} catch (Exception $e) {
    error_log("❌ Error en eliminar material: " . $e->getMessage());
    header("Location: ../dashboard.php?error=no_se_pudo_eliminar");
    exit();
}
?>