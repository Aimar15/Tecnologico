<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . "/proyecto_servicio/includes/conexion.php";

$usuario = $_SESSION['usuario'];

$sql = "SELECT * FROM movimientos WHERE usuario='$usuario' AND tipo='prestamo'";
$result = $conn->query($sql);
?>

<h2>Mis pedidos</h2>

<table border="1" width="100%">
<tr>
    <th>#</th>
    <th>Material</th>
    <th>Cantidad</th>
    <th>Fecha</th>
</tr>

<?php
$c=1;
while($row=$result->fetch_assoc()){
?>
<tr>
    <td><?php echo $c++; ?></td>
    <td><?php echo $row['material']; ?></td>
    <td><?php echo $row['cantidad']; ?></td>
    <td><?php echo $row['fecha']; ?></td>
</tr>
<?php } ?>
</table>