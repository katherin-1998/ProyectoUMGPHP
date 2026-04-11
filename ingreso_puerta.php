<?php
include("conexion.php");
$sedes = mysqli_query($conn, "SELECT sed_sede, sed_nombre FROM siu_sede");
?>

<style>
    .rep-wrapper { width: 100%; padding: 0 0 40px 0; }
    .rep-card {
        background: #fff;
        border: 1px solid #d0dce8;
        border-radius: 14px;
        padding: 28px 32px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.07);
    }
    .rep-header { display:flex; align-items:center; gap:12px; margin-bottom:6px; }
    .rep-icon {
        width:42px; height:42px; border-radius:10px;
        display:flex; align-items:center; justify-content:center;
        font-size:1.3rem; flex-shrink:0;
        background: rgba(13,110,253,0.1);
    }
    .rep-title { font-size:1.25rem; font-weight:700; color:#1a2a3a; margin:0; }
    .rep-subtitle { font-size:0.85rem; color:#5a7a95; margin:0 0 22px 54px; }
    .rep-divider { border:none; border-top:1px solid #e0e8f0; margin:0 0 22px 0; }
    .rep-label { font-size:0.78rem; font-weight:600; color:#3a6080; text-transform:uppercase; letter-spacing:.05em; margin-bottom:6px; }
    .rep-select, .rep-date {
        background:#f5f8fb !important; color:#1a2a3a !important;
        border:1px solid #b0c4d8 !important; border-radius:8px !important;
        padding:10px 14px !important; font-size:0.9rem !important;
        width:100%; transition:border-color .2s;
    }
    .rep-select:focus, .rep-date:focus {
        border-color:#0d6efd !important;
        box-shadow:0 0 0 3px rgba(13,110,253,0.12) !important;
        outline:none !important;
    }
    .rep-btn {
        border:none; border-radius:9px; padding:12px 20px;
        font-size:0.95rem; font-weight:600; width:100%;
        cursor:pointer; margin-top:6px;
        transition:opacity .2s, transform .1s;
        background:linear-gradient(90deg,#0d6efd,#3d9be9); color:#fff;
    }
    .rep-btn:hover { opacity:.88; transform:translateY(-1px); }
    .rep-btn:active { transform:translateY(0); }
    .step-badge { display:inline-block; background:#e8f0fb; color:#0d6efd; font-size:0.72rem; font-weight:700; border-radius:5px; padding:2px 7px; margin-bottom:5px; }
    .rep-table-wrap { overflow-x:auto; margin-top:20px; }
    .rep-table { width:100%; border-collapse:collapse; font-size:0.88rem; color:#1a2a3a; }
    .rep-table thead tr { background:#e8f0fb; color:#1a4a8a; text-transform:uppercase; font-size:0.75rem; letter-spacing:.05em; }
    .rep-table th, .rep-table td { padding:10px 14px; border-bottom:1px solid #e0e8f0; white-space:nowrap; }
    .rep-table tbody tr:hover { background:#f0f6ff; }
    .rep-table tbody tr:nth-child(even) { background:#f8fafc; }
    .loading-box { text-align:center; padding:30px; color:#5a7a95; font-size:0.9rem; }
</style>

<div class="rep-wrapper">
    <div class="rep-card">
        <div class="rep-header">
            <div class="rep-icon">🚪</div>
            <p class="rep-title">Reporte de Ingresos por Puerta</p>
        </div>
        <p class="rep-subtitle">
            Muestra los registros de ingreso filtrados por <strong style="color:#1a4a8a">sede y fecha</strong>.
        </p>
        <hr class="rep-divider">

        <form id="formFiltros">
            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <div class="step-badge">PASO 1</div>
                    <div class="rep-label">Sede</div>
                    <select name="sede" class="rep-select">
                        <option value="">— Seleccione Sede —</option>
                        <?php while($s = mysqli_fetch_assoc($sedes)): ?>
                            <option value="<?php echo $s['sed_sede']; ?>"><?php echo $s['sed_nombre']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <div class="step-badge">PASO 2</div>
                    <div class="rep-label">Fecha</div>
                    <input type="date" name="fecha" class="rep-date">
                </div>
                <div class="col-md-4 d-flex flex-column justify-content-end">
                    <button type="submit" class="rep-btn">🔍 &nbsp;Ver Ingresos</button>
                </div>
            </div>
        </form>

        <div id="tablaResultados">
            <p class="loading-box">Seleccione sede y fecha para ver los ingresos.</p>
        </div>
    </div>
</div>

<script>
document.getElementById("formFiltros").addEventListener("submit", function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    document.getElementById("tablaResultados").innerHTML = '<div class="loading-box">Cargando datos...</div>';
    fetch("ingreso_puerta_ajax.php", { method: "POST", body: formData })
        .then(res => res.text())
        .then(html => { document.getElementById("tablaResultados").innerHTML = html; })
        .catch(err => console.error("Error cargando resultados:", err));
});
</script>
