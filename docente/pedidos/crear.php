<?php
include $_SERVER['DOCUMENT_ROOT'] . "../../includes/conexion.php";

$sql = "SELECT nombre, cantidad FROM materiales ORDER BY nombre ASC";
$result = $conn->query($sql);
?>

<h2>Pedir material</h2>

<style>
.input {
    width: 100%;
    padding: 10px;
    margin-top: 8px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
}

.dropdown {
    position: relative;
    width: 100%;
}

.options {
    display: none;
    position: absolute;
    width: 100%;
    background: white;
    border: 1px solid #ccc;
    max-height: 220px;
    overflow-y: auto;
    z-index: 1000;
}

.option {
    padding: 10px;
    cursor: pointer;
}

.option:hover {
    background: #e6f0ff;
}

.search {
    width: 100%;
    padding: 8px;
    border: none;
    border-bottom: 1px solid #ddd;
    outline: none;
}

.label{
    margin-top: 15px;
    display: block;
    font-weight: bold;
}
</style>

<form action="../../docente/pedidos/guardar.php" method="POST">

<!-- MATERIAL -->
<div class="dropdown">

<label class="label">Material</label>

<input 
    type="text" 
    id="materialInput" 
    class="input" 
    placeholder="Selecciona material"
    readonly
    onclick="toggleOptions()"
>

<input type="hidden" name="material" id="material">

<div class="options" id="options">

<input 
    type="text" 
    class="search" 
    placeholder="Buscar..."
    onkeyup="filterList(this)"
>

<div id="list">

<?php while($row = $result->fetch_assoc()){ ?>
    <div class="option"
        onclick="selectMaterial('<?php echo $row['nombre']; ?>')">

        <?php echo $row['nombre']; ?>
        (Stock: <?php echo $row['cantidad']; ?>)

    </div>
<?php } ?>

</div>

</div>

</div>

<!-- CANTIDAD -->
<label class="label">Cantidad</label>

<input 
    type="number" 
    name="cantidad" 
    class="input" 
    placeholder="Cantidad"
    min="1"
    required
>

<!-- FECHA Y HORA DEL PEDIDO -->
<label class="label">
    Fecha y hora del préstamo
</label>

<input 
    type="datetime-local"
    name="fecha_prestamo"
    class="input"
    required
>

<!-- PEDIR POR ADELANTADO -->
<label class="label">
    Reservar material para después (opcional)
</label>

<input 
    type="datetime-local"
    name="fecha_reserva"
    class="input"
>

<!-- FECHA DEVOLUCIÓN -->
<label class="label">
    Fecha y hora estimada de devolución
</label>

<input 
    type="datetime-local"
    name="fecha_devolucion"
    class="input"
>

<br><br>

<button type="submit">
    Solicitar
</button>

</form>

<script>

function toggleOptions() {

    let options = document.getElementById('options');

    options.style.display =
        (options.style.display === 'block')
        ? 'none'
        : 'block';
}

function selectMaterial(nombre) {

    document.getElementById('materialInput').value = nombre;

    document.getElementById('material').value = nombre;

    document.getElementById('options').style.display = 'none';
}

function filterList(input) {

    let filter = input.value.toLowerCase();

    let items = document.querySelectorAll('.option');

    items.forEach(item => {

        item.style.display =
            item.innerText.toLowerCase().includes(filter)
            ? "block"
            : "none";
    });
}

// cerrar dropdown al hacer clic fuera
document.addEventListener('click', function(e){

    if(!e.target.closest('.dropdown')){

        document.getElementById('options').style.display = 'none';
    }
});
</script>