<?php
include "../../includes/conexion.php";

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
// Agregamos una pequeña validación por si la consulta está vacía al principio
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
?>
<tr>
    <td><?php echo $c++; ?></td>
    <td><?php echo $row['nombre']; ?></td>
    <td><?php echo $row['cantidad']; ?></td>
</tr>
<?php 
    } 
} else { 
?>
<tr>
    <td colspan="3">No hay materiales registrados en este momento.</td>
</tr>
<?php } ?>
</table>