<?php
include $_SERVER['DOCUMENT_ROOT'] . "/proyecto_servicio/includes/conexion.php";

$sql = "SELECT * FROM reportes ORDER BY id DESC";
$result = $conn->query($sql);
?>

<h2>Listado de Reportes</h2>

<table>
    <tr>
        <th>#</th>
        <th>Tipo</th>
        <th>Descripción</th>
        <th>Fecha</th>
    </tr>

<?php
$contador = 1;
while ($row = $result->fetch_assoc()) {
?>
    <tr>
        <td><?php echo $contador++; ?></td>
        <td><?php echo $row['tipo']; ?></td>
        <td><?php echo $row['descripcion']; ?></td>
        <td><?php echo $row['fecha']; ?></td>
    </tr>
<?php } ?>

</table>