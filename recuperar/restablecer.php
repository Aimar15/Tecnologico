<?php
include "../includes/conexion.php";

$token = $_GET['token'];

$sql = "
SELECT * FROM usuarios
WHERE token_recuperacion='$token'
";

$resultado = $conn->query($sql);

if($resultado->num_rows == 0){
    die("Token inválido");
}
?>

<form action="guardar_password.php" method="POST">

    <input type="hidden" name="token"
    value="<?php echo $token; ?>">

    <input type="password"
    name="password"
    placeholder="Nueva contraseña"
    required>

    <button type="submit">
        Cambiar contraseña
    </button>

</form>