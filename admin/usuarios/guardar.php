<?php
session_start();

include "../../includes/conexion.php";

// Validar que los datos existan en el POST
$usuario  = isset($_POST['usuario']) ? $_POST['usuario'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$rol      = isset($_POST['rol']) ? $_POST['rol'] : '';
$email    = isset($_POST['email']) ? $_POST['email'] : 'correo_defecto@tecvalles.mx'; 

if (empty($usuario) || empty($password)) {
    $_SESSION['toast'] = [
        "tipo" => "error",
        "mensaje" => "El usuario y la contraseña son obligatorios."
    ];
    header("Location: ../dashboard.php");
    exit();
}

try {
    /* VALIDAR SI YA EXISTE */
    $sql = "SELECT * FROM usuarios WHERE usuario='$usuario'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $_SESSION['toast'] = [
            "tipo" => "error",
            "mensaje" => "El usuario ya existe"
        ];
        header("Location: ../dashboard.php");
        exit();
    } else {
        $sql_insert = "INSERT INTO usuarios (usuario, email, password, rol) 
                       VALUES ('$usuario', '$email', '$password', '$rol')";
        
        $conn->query($sql_insert);

        $_SESSION['toast'] = [
            "tipo" => "success",
            "mensaje" => "Usuario creado correctamente"
        ];

        header("Location: ../dashboard.php");
        exit();
    }
} catch (Exception $e) {
    error_log("❌ Error en guardar.php: " . $e->getMessage());
    $_SESSION['toast'] = [
        "tipo" => "error",
        "mensaje" => "Error interno en la base de datos."
    ];
    header("Location: ../dashboard.php");
    exit();
}
?>