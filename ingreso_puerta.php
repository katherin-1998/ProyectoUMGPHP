<?php
include("conexion.php");

// Obtener sedes para el filtro
$sedes = mysqli_query($conn, "SELECT sed_sede, sed_nombre FROM siu_sede");
?>

<h2 class="text-info">Reporte de Ingresos por Puerta</h2>

<!-- Formulario de filtros -->
<form id="formFiltros" class="row g-3 mb-4">
    <div class="col-md-4">
        <label class="form-label text-light">Sede</label>
        <select name="sede" class="form-select">
            <option value="">-- Seleccione sede --</option>
            <?php while($s = mysqli_fetch_assoc($sedes)): ?>
                <option value="<?php echo $s['sed_sede']; ?>"><?php echo $s['sed_nombre']; ?></option>
            <?php endwhile; ?>
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label text-light">Fecha</label>
        <input type="date" name="fecha" class="form-control">
    </div>
    <div class="col-md-4 d-flex align-items-end">
        <button type="submit" class="btn btn-primary w-100">Ver ingresos</button>
    </div>
</form>

<!-- Contenedor para la tabla -->
<div id="tablaResultados">
    <p class="text-muted">Seleccione sede y fecha para ver los ingresos.</p>
</div>

<script>
document.getElementById("formFiltros").addEventListener("submit", function(e) {
    e.preventDefault(); // evita recargar el dashboard

    const formData = new FormData(this);

    fetch("ingreso_puerta_ajax.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.text())
    .then(html => {
        document.getElementById("tablaResultados").innerHTML = html;
    })
    .catch(err => console.error("Error cargando resultados:", err));
});
</script>