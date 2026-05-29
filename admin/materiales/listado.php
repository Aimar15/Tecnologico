<?php
include $_SERVER['DOCUMENT_ROOT'] . "../../includes/conexion.php";

$sql = "SELECT * FROM materiales ORDER BY id DESC";
$result = $conn->query($sql);
?>

<h2>Listado de Materiales</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Cantidad</th>
        <th>Acción</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()) { ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['nombre']; ?></td>
        <td><?php echo $row['cantidad']; ?></td>
        <td>
        <a href="materiales/eliminar.php?id=<?php echo $row['id']; ?>"
            onclick="return confirm('¿Eliminar material?')"
            class="btn-eliminar">
            🗑 Eliminar
        </a>
        </td>
    </tr>
    <?php } ?>
</table>