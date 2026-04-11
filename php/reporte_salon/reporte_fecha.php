<?php
include("../../conexion.php");
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
    .rep-header { display: flex; align-items: center; gap: 12px; margin-bottom: 6px; }
    .rep-icon {
        width: 42px; height: 42px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.3rem; flex-shrink: 0;
        background: rgba(13,110,253,0.1);
    }
    .rep-title { font-size: 1.25rem; font-weight: 700; color: #1a2a3a; margin: 0; }
    .rep-subtitle { font-size: 0.85rem; color: #5a7a95; margin: 0 0 22px 54px; }
    .rep-divider { border: none; border-top: 1px solid #e0e8f0; margin: 0 0 22px 0; }
    .rep-label {
        font-size: 0.78rem; font-weight: 600; color: #3a6080;
        text-transform: uppercase; letter-spacing: .05em; margin-bottom: 6px;
    }
    .rep-select, .rep-date {
        background: #f5f8fb !important;
        color: #1a2a3a !important;
        border: 1px solid #b0c4d8 !important;
        border-radius: 8px !important;
        padding: 10px 14px !important;
        font-size: 0.9rem !important;
        width: 100%;
        transition: border-color .2s;
    }
    .rep-select:focus, .rep-date:focus {
        border-color: #0d6efd !important;
        box-shadow: 0 0 0 3px rgba(13,110,253,0.12) !important;
        outline: none !important;
    }
    .rep-select:disabled { opacity: 0.45 !important; cursor: not-allowed !important; }
    .rep-btn {
        border: none; border-radius: 9px; padding: 12px 20px;
        font-size: 0.95rem; font-weight: 600; width: 100%;
        cursor: pointer; margin-top: 6px;
        transition: opacity .2s, transform .1s;
        background: linear-gradient(90deg, #0d6efd, #3d9be9);
        color: #fff;
    }
    .rep-btn:hover  { opacity: .88; transform: translateY(-1px); }
    .rep-btn:active { transform: translateY(0); }
    .step-badge {
        display: inline-block; background: #e8f0fb; color: #0d6efd;
        font-size: 0.72rem; font-weight: 700; border-radius: 5px;
        padding: 2px 7px; margin-bottom: 5px; letter-spacing: .04em;
    }
    .rep-table-wrap { overflow-x: auto; margin-top: 20px; }
    .rep-table { width: 100%; border-collapse: collapse; font-size: 0.88rem; color: #1a2a3a; }
    .rep-table thead tr {
        background: #e8f0fb; color: #1a4a8a;
        text-transform: uppercase; font-size: 0.75rem; letter-spacing: .05em;
    }
    .rep-table th, .rep-table td { padding: 10px 14px; border-bottom: 1px solid #e0e8f0; white-space: nowrap; }
    .rep-table tbody tr:hover { background: #f0f6ff; }
    .rep-table tbody tr:nth-child(even) { background: #f8fafc; }
    .badge-est  { background:#dbeafe; color:#1d4ed8; border:1px solid #bfdbfe; padding:3px 10px; border-radius:20px; font-size:.78rem; font-weight:600; }
    .badge-prof { background:#fef9c3; color:#92400e; border:1px solid #fde68a; padding:3px 10px; border-radius:20px; font-size:.78rem; font-weight:600; }
    .badge-pres { background:#dcfce7; color:#166534; border:1px solid #bbf7d0; padding:3px 10px; border-radius:20px; font-size:.78rem; }
    .badge-ause { background:#fee2e2; color:#991b1b; border:1px solid #fecaca; padding:3px 10px; border-radius:20px; font-size:.78rem; }
    .rep-info-bar { display:flex; flex-wrap:wrap; gap:8px; margin-bottom:14px; }
    .rep-info-chip { background:#f0f6ff; border:1px solid #b0c4d8; border-radius:20px; padding:4px 14px; font-size:0.8rem; color:#3a6080; }
    .rep-info-chip strong { color: #1a2a3a; }
    .rep-count { font-size:0.8rem; color:#5a7a95; margin-top:10px; text-align:right; }
    .loading-box { text-align:center; padding:30px; color:#5a7a95; font-size:0.9rem; }
</style>

<div class="rep-wrapper">
    <div class="rep-card">
        <div class="rep-header">
            <div class="rep-icon">📅</div>
            <p class="rep-title">Reporte de Ingresos por Fecha y Salón</p>
        </div>
        <p class="rep-subtitle">
            Muestra los registros de ingreso al salón seleccionado
            <strong style="color:#a8d4f5">filtrados por una fecha específica</strong>,
            incluyendo horarios de clase.
        </p>
        <hr class="rep-divider">

        <div class="row g-3 mb-3">

            <!-- FECHA -->
            <div class="col-md-3">
                <div class="step-badge">PASO 1</div>
                <div class="rep-label">Fecha</div>
                <input type="date" id="fecha_rep2" class="rep-date">
            </div>

            <!-- SEDE -->
            <div class="col-md-3">
                <div class="step-badge">PASO 2</div>
                <div class="rep-label">Instalación (Sede)</div>
                <select id="sede_fecha2" class="rep-select">
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

            <!-- NIVEL -->
            <div class="col-md-3">
                <div class="step-badge">PASO 3</div>
                <div class="rep-label">Nivel de Instalación</div>
                <select id="nivel_fecha2" class="rep-select" disabled>
                    <option value="">— Seleccione Nivel —</option>
                </select>
            </div>

            <!-- SALÓN -->
            <div class="col-md-3">
                <div class="step-badge">PASO 4</div>
                <div class="rep-label">Salón de Clase</div>
                <select id="salon_fecha2" class="rep-select" disabled>
                    <option value="">— Seleccione Salón —</option>
                </select>
            </div>
        </div>

        <button class="rep-btn" id="btn_fecha2">
            🔍 &nbsp;Ver Ingresos por Fecha
        </button>

        <div id="resultado_fecha2"></div>
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

    const sedeFecha  = document.getElementById("sede_fecha2");
    const nivelFecha = document.getElementById("nivel_fecha2");
    const salonFecha = document.getElementById("salon_fecha2");
    const fechaInp   = document.getElementById("fecha_rep2");
    const btnFecha   = document.getElementById("btn_fecha2");

    sedeFecha.addEventListener("change",
        () => cargarNiveles(sedeFecha.value, nivelFecha, salonFecha));
    nivelFecha.addEventListener("change",
        () => cargarSalones(nivelFecha.value, salonFecha));

    btnFecha.addEventListener("click", function () {
        if (!fechaInp.value)   { alert("Selecciona una fecha.");  return; }
        if (!salonFecha.value) { alert("Selecciona un salón.");   return; }

        const div = document.getElementById("resultado_fecha2");
        div.innerHTML = '<div class="loading-box">⏳ Cargando datos...</div>';

        fetch(BASE + "get_reporte_fecha.php?id_salon=" + salonFecha.value + "&fecha=" + fechaInp.value)
            .then(r => r.text())
            .then(html => { div.innerHTML = html; })
            .catch(() => {
                div.innerHTML = "<div class='alert alert-danger mt-3'>Error al cargar el reporte.</div>";
            });
    });
})();
</script>