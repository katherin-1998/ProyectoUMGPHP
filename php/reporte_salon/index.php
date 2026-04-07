<?php
include("../../conexion.php");
?>

<style>
    .rep-wrapper {
        max-width: 960px;
        margin: 0 auto;
        padding: 10px 0 40px 0;
    }
    .rep-card {
        background: linear-gradient(135deg, #0d1b2a 0%, #1a2a3a 100%);
        border: 1px solid #1e6fb5;
        border-radius: 14px;
        padding: 28px 32px;
        box-shadow: 0 4px 24px rgba(30, 111, 181, 0.15);
    }
    .rep-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 6px;
    }
    .rep-icon {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        flex-shrink: 0;
    }
    .rep-icon.azul  { background: rgba(13, 110, 253, 0.2); }
    .rep-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #fff;
        margin: 0;
    }
    .rep-subtitle {
        font-size: 0.85rem;
        color: #8aadcc;
        margin: 0 0 22px 54px;
    }
    .rep-divider {
        border: none;
        border-top: 1px solid #1e3a55;
        margin: 0 0 22px 0;
    }
    .rep-label {
        font-size: 0.78rem;
        font-weight: 600;
        color: #7bafd4;
        text-transform: uppercase;
        letter-spacing: .05em;
        margin-bottom: 6px;
    }
    .rep-select, .rep-date {
        background: #0a1628 !important;
        color: #e0eaf4 !important;
        border: 1px solid #1e4d7a !important;
        border-radius: 8px !important;
        padding: 10px 14px !important;
        font-size: 0.9rem !important;
        transition: border-color .2s;
    }
    .rep-select:focus, .rep-date:focus {
        border-color: #3d9be9 !important;
        box-shadow: 0 0 0 3px rgba(61,155,233,0.15) !important;
        outline: none !important;
    }
    .rep-select:disabled {
        opacity: 0.45 !important;
        cursor: not-allowed !important;
    }
    .rep-btn {
        border: none;
        border-radius: 9px;
        padding: 12px 20px;
        font-size: 0.95rem;
        font-weight: 600;
        width: 100%;
        cursor: pointer;
        margin-top: 6px;
        transition: opacity .2s, transform .1s;
    }
    .rep-btn:hover  { opacity: .88; transform: translateY(-1px); }
    .rep-btn:active { transform: translateY(0); }
    .rep-btn.azul   { background: linear-gradient(90deg,#0d6efd,#3d9be9); color:#fff; }
    .step-badge {
        display: inline-block;
        background: #1e3a55;
        color: #7bafd4;
        font-size: 0.72rem;
        font-weight: 700;
        border-radius: 5px;
        padding: 2px 7px;
        margin-bottom: 5px;
        letter-spacing: .04em;
    }
    /* Tabla resultado */
    .rep-table-wrap { overflow-x: auto; margin-top: 20px; }
    .rep-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.88rem;
        color: #dce8f5;
    }
    .rep-table thead tr {
        background: #0d3557;
        color: #a8d4f5;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: .05em;
    }
    .rep-table th, .rep-table td {
        padding: 10px 14px;
        border-bottom: 1px solid #162840;
        white-space: nowrap;
    }
    .rep-table tbody tr:hover { background: #0f2540; }
    .rep-table tbody tr:nth-child(even) { background: #0b1e33; }
    .badge-est  { background:#0d6efd22; color:#6ea8fe; border:1px solid #1a4a8a; padding:3px 10px; border-radius:20px; font-size:.78rem; font-weight:600; }
    .badge-prof { background:#f0a50022; color:#ffc107; border:1px solid #7a5200; padding:3px 10px; border-radius:20px; font-size:.78rem; font-weight:600; }
    .badge-pres { background:#0f5132; color:#75e0a7; border:1px solid #0f5132; padding:3px 10px; border-radius:20px; font-size:.78rem; }
    .badge-ause { background:#58151c; color:#f1888d; border:1px solid #58151c; padding:3px 10px; border-radius:20px; font-size:.78rem; }
    .rep-info-bar {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 14px;
    }
    .rep-info-chip {
        background: #0d2540;
        border: 1px solid #1e4d7a;
        border-radius: 20px;
        padding: 4px 14px;
        font-size: 0.8rem;
        color: #a8d4f5;
    }
    .rep-info-chip strong { color: #fff; }
    .rep-count {
        font-size: 0.8rem;
        color: #5a8ab0;
        margin-top: 10px;
        text-align: right;
    }
    .loading-box {
        text-align: center;
        padding: 30px;
        color: #5a8ab0;
        font-size: 0.9rem;
    }
</style>

<div class="rep-wrapper">

    <!-- ══════════════════════════════════════════ -->
    <!--        REPORTE HISTÓRICO POR SALÓN         -->
    <!-- ══════════════════════════════════════════ -->
    <div class="rep-card">
        <div class="rep-header">
            <div class="rep-icon azul"></div>
            <p class="rep-title">Reporte Histórico de Ingresos por Salón</p>
        </div>
        <p class="rep-subtitle">
            Muestra <strong style="color:#a8d4f5">todos los registros históricos</strong>
            de ingreso al salón seleccionado, sin importar la fecha.
        </p>
        <hr class="rep-divider">

        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <div class="step-badge">PASO 1</div>
                <div class="rep-label">Instalación (Sede)</div>
                <select id="sede_hist" class="form-select rep-select">
                    <option value="">— Seleccione Sede —</option>
                    <?php
                    $r = $conn->query("SELECT sed_sede, sed_nombre FROM siu_sede");
                    while ($row = $r->fetch_assoc()):
                    ?>
                        <option value="<?= $row['sed_sede'] ?>">
                            <?= htmlspecialchars($row['sed_nombre']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="col-md-4">
                <div class="step-badge">PASO 2</div>
                <div class="rep-label">Nivel de Instalación</div>
                <select id="nivel_hist" class="form-select rep-select" disabled>
                    <option value="">— Seleccione Nivel —</option>
                </select>
            </div>
            <div class="col-md-4">
                <div class="step-badge">PASO 3</div>
                <div class="rep-label">Salón de Clase</div>
                <select id="salon_hist" class="form-select rep-select" disabled>
                    <option value="">— Seleccione Salón —</option>
                </select>
            </div>
        </div>

        <button class="rep-btn azul" id="btn_hist">
             &nbsp;Ver Listado Histórico (Estudiantes y Catedráticos)
        </button>

        <div id="resultado_hist"></div>
    </div>

</div>

<script>
(function () {
    const BASE = "/ProyectoUMGPHP/php/reporte_salon/php/";

    function cargarNiveles(idSede, nivelSel, salonSel) {
        nivelSel.innerHTML = '<option value="">— Seleccione Nivel —</option>';
        salonSel.innerHTML = '<option value="">— Seleccione Salón —</option>';
        nivelSel.disabled = true;
        salonSel.disabled = true;
        if (!idSede) return;

        fetch(BASE + "get_niveles.php?id_instalacion=" + idSede)
            .then(r => r.json())
            .then(data => {
                if (data.length > 0) {
                    nivelSel.disabled = false;
                    data.forEach(n => {
                        nivelSel.innerHTML +=
                            `<option value="${n.id_nivel}">${n.nombre_nivel}</option>`;
                    });
                }
            }).catch(e => console.error("Error niveles:", e));
    }

    function cargarSalones(idNivel, salonSel) {
        salonSel.innerHTML = '<option value="">— Seleccione Salón —</option>';
        salonSel.disabled = true;
        if (!idNivel) return;

        fetch(BASE + "get_salones.php?id_nivel=" + idNivel)
            .then(r => r.json())
            .then(data => {
                if (data.length > 0) {
                    salonSel.disabled = false;
                    data.forEach(s => {
                        salonSel.innerHTML +=
                            `<option value="${s.id_salon}">${s.nombre_salon}</option>`;
                    });
                }
            }).catch(e => console.error("Error salones:", e));
    }

    const sedeHist  = document.getElementById("sede_hist");
    const nivelHist = document.getElementById("nivel_hist");
    const salonHist = document.getElementById("salon_hist");
    const btnHist   = document.getElementById("btn_hist");

    sedeHist.addEventListener("change",
        () => cargarNiveles(sedeHist.value, nivelHist, salonHist));
    nivelHist.addEventListener("change",
        () => cargarSalones(nivelHist.value, salonHist));

    btnHist.addEventListener("click", function () {
        if (!salonHist.value) { alert("Selecciona un salón."); return; }
        const div = document.getElementById("resultado_hist");
        div.innerHTML = '<div class="loading-box"> Cargando datos...</div>';

        fetch(BASE + "consultar_reporte.php?id_salon=" + salonHist.value)
            .then(r => r.text())
            .then(html => { div.innerHTML = html; })
            .catch(() => {
                div.innerHTML = "<div class='alert alert-danger mt-3'>Error al cargar el reporte.</div>";
            });
    });

})();
</script>