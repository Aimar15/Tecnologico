<?php
include $_SERVER['DOCUMENT_ROOT'] . "/proyecto_servicio/includes/conexion.php";

$sql = "SELECT * FROM materiales";
$result = $conn->query($sql);
?>

<h2>Materiales disponibles</h2>

<table border="1" width="100%" style="border-collapse: collapse; text-align:center;">
<tr>
    <th>#</th>
    <th>Material</th>
    <th>Cantidad</th>
</tr>

<?php
$c = 1;
while ($row = $result->fetch_assoc()) {
?>
<tr>
    <td><?php echo $c++; ?></td>
    <td><?php echo $row['nombre']; ?></td>
    <td><?php echo $row['cantidad']; ?></td>
</tr>
<?php } ?>
</table>