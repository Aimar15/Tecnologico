<?php
include $_SERVER['DOCUMENT_ROOT'] . "/proyecto_servicio/includes/conexion.php";

$sql = "SELECT * FROM usuarios ORDER BY id DESC";
$result = $conn->query($sql);
?>

<h2>Listado de Usuarios</h2>

<table>
    <tr>
        <th>#</th>
        <th>Usuario</th>
        <th>Rol</th>
        <th>Correo</th>
        <th></th>
    </tr>

    <?php
    $contador = 1;
    while ($row = $result->fetch_assoc()) {
    ?>
    <tr>
        <td><?php echo $contador++; ?></td>
        <td><?php echo $row['usuario']; ?></td>
        <td><?php echo $row['rol']; ?></td>
        <td><?php echo $row['email']; ?></td>
        <td>
        <a href="usuarios/eliminar.php?id=<?php echo $row['id']; ?>"
            onclick="return confirm('¿Eliminar usuario?')"
            style="color:red;">
            Eliminar
        </a>
        </td>
    </tr>
    <?php } ?>

</table>

