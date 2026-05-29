<?php
include "../includes/conexion.php";

$token = $_POST['token'];

$password = md5($_POST['password']);

$sql = "
UPDATE usuarios
SET
password='$password',
token_recuperacion=NULL
WHERE token_recuperacion='$token'
";

if($conn->query($sql)){

    echo "
    <script>
        alert('Contraseña actualizada');
        window.location='../index.php';
    </script>
    ";

} else {

    echo "Error";
}
?>