<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "../../includes/conexion.php";

$usuario_id = $_SESSION['id_usuario'];

$sql = "SELECT material, descripcion, fecha
        FROM reportes
        WHERE usuario_id = '$usuario_id'
        ORDER BY id DESC";

$result = $conn->query($sql);
?>

<style>
.tabla-reportes{
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    background: rgba(255,255,255,0.95);
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 20px rgba(0,0,0,0.15);
}

.tabla-reportes th{
    background: #0f172a;
    color: white;
    padding: 15px;
    font-size: 14px;
}

.tabla-reportes td{
    padding: 14px;
    border-bottom: 1px solid #ddd;
    font-size: 14px;
}

.tabla-reportes tr:hover{
    background: #f1f5f9;
}

.sin-registros{
    text-align: center;
    padding: 25px;
    color: #666;
}
</style>

<h2>Mis reportes</h2>

<table class="tabla-reportes">
<tr>
    <th>Material</th>
    <th>Descripción</th>
    <th>Fecha</th>
</tr>

<?php if($result && $result->num_rows > 0){ ?>
    <?php while($row = $result->fetch_assoc()){ ?>
        <tr>
            <td><?= $row['material'] ?></td>
            <td><?= $row['descripcion'] ?></td>
            <td><?= $row['fecha'] ?></td>
        </tr>
    <?php } ?>
<?php } else { ?>
<tr>
    <td colspan="3" class="sin-registros">
        No tienes reportes registrados
    </td>
</tr>
<?php } ?>
</table>