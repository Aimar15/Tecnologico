<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include __DIR__ . "/../../includes/conexion.php";

$usuario_id = $_SESSION['id_usuario'];

$sql = "SELECT id, material, cantidad, fecha_prestamo 
        FROM prestamos 
        WHERE usuario_id = '$usuario_id' AND estado = 'prestado'";

$result = $conn->query($sql);
?>

<h2>Devolver préstamo</h2>

<style>
.input{
    width:100%;
    padding:10px;
    margin-top:8px;
    border:1px solid #ccc;
    border-radius:5px;
}

.btn{
    padding:10px;
    background:#16a34a;
    color:white;
    border:none;
    border-radius:5px;
    cursor:pointer;
    margin-top:10px;
}

.modal{
    display:none;
    position:fixed;
    top:50%;
    left:50%;
    transform:translate(-50%,-50%);
    width:400px;
    max-height:400px;
    overflow-y:auto;
    background:white;
    padding:15px;
    border-radius:10px;
    box-shadow:0 0 20px rgba(0,0,0,0.3);
}

.overlay{
    display:none;
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.5);
}

.item{
    padding:10px;
    border-bottom:1px solid #eee;
    cursor:pointer;
}

.item:hover{
    background:#e6f0ff;
}
</style>

<form action="../../docente/devoluciones/guardar.php" method="POST">

<label>Préstamo</label>
<input type="text" id="texto" class="input" readonly onclick="openModal()">

<input type="hidden" name="prestamo_id" id="prestamo_id">
<input type="hidden" name="material" id="material">

<label>Cantidad a devolver</label>
<input type="number" name="cantidad" min="1" class="input" required>

<label>Fecha devolución</label>
<input type="datetime-local" name="fecha_devolucion" class="input" required>

<label>Observaciones (opcional)</label>
<textarea name="observaciones" class="input" placeholder="Escribe observaciones..."></textarea>

<button class="btn" type="submit">Devolver</button>

</form>

<div class="overlay" id="overlay" onclick="closeModal()"></div>

<div class="modal" id="modal">

<h3>Selecciona préstamo</h3>

<?php if ($result && $result->num_rows > 0) { ?>
    <?php while($row = $result->fetch_assoc()){ ?>
        <div class="item" onclick="selectP('<?php echo $row['id']; ?>','<?php echo $row['material']; ?>','<?php echo $row['cantidad']; ?>')">
            📦 <?php echo $row['material']; ?> | <?php echo $row['cantidad']; ?>
        </div>
    <?php } ?>
<?php } else { ?>
    <div class="item" style="cursor: default;">No tienes préstamos pendientes active.</div>
<?php } ?>

</div>

<script>
function openModal(){
document.getElementById('modal').style.display='block';
document.getElementById('overlay').style.display='block';
}

function closeModal(){
document.getElementById('modal').style.display='none';
document.getElementById('overlay').style.display='none';
}

function selectP(id,mat,cant){
document.getElementById('prestamo_id').value=id;
document.getElementById('material').value=mat;
document.getElementById('texto').value=mat+" ("+cant+")";
closeModal();
}
</script>