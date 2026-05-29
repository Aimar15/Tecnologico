<?php
session_start();
include "conexion.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = isset($_POST['usuario']) ? $_POST['usuario'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $rol_form = isset($_POST['rol']) ? $_POST['rol'] : '';

    try {
        // Consulta básica (Recuerda migrar a consultas preparadas en el futuro por seguridad)
        $sql = "SELECT * FROM usuarios WHERE usuario='$usuario' AND password='$password' AND rol='$rol_form'";
        $result = $conn->query($sql);

        if ($result && $result->num_rows == 1) {
            $data = $result->fetch_assoc();

            $_SESSION['id_usuario'] = $data['id'];   
            $_SESSION['usuario'] = $data['usuario'];
            $_SESSION['rol'] = $data['rol'];

            $conn->close();

            if ($data['rol'] == "admin") {
                header("Location: ../admin/dashboard.php");
            } else {
                header("Location: ../docente/dashboard.php");
            }
            exit();
        } else {
            header("Location: ../index.php?error=1");
            exit();
        }

    } catch (Exception $e) {
        error_log("❌ Error en la consulta SQL: " . $e->getMessage());
        header("Location: ../index.php?error=db");
        exit();
    }
} else {
    header("Location: ../index.php");
    exit();
}
?>