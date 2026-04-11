<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include($_SERVER['DOCUMENT_ROOT'] . "/conexion.php");
$id_usuario_actual = 52;
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
    .rep-select {
        background:#f5f8fb !important; color:#1a2a3a !important;
        border:1px solid #b0c4d8 !important; border-radius:8px !important;
        padding:10px 14px !important; font-size:0.9rem !important;
        width:100%; transition:border-color .2s;
    }
    .rep-select:focus { border-color:#0d6efd !important; box-shadow:0 0 0 3px rgba(13,110,253,0.12) !important; outline:none !important; }
    .rep-btn {
        border:none; border-radius:9px; padding:12px 20px;
        font-size:0.95rem; font-weight:600; width:100%;
        cursor:pointer; margin-top:6px;
        transition:opacity .2s, transform .1s;
        background:linear-gradient(90deg,#0d6efd,#3d9be9); color:#fff;
    }
    .rep-btn:hover { opacity:.88; transform:translateY(-1px); }
    .rep-table-wrap { overflow-x:auto; margin-top:20px; }
    .rep-table { width:100%; border-collapse:collapse; font-size:0.88rem; color:#1a2a3a; }
    .rep-table thead tr { background:#e8f0fb; color:#1a4a8a; text-transform:uppercase; font-size:0.75rem; letter-spacing:.05em; }
    .rep-table th, .rep-table td { padding:10px 14px; border-bottom:1px solid #e0e8f0; white-space:nowrap; }
    .rep-table tbody tr:hover { background:#f0f6ff; }
    .rep-table tbody tr:nth-child(even) { background:#f8fafc; }
    .badge-pres { background:#dcfce7; color:#166534; border:1px solid #bbf7d0; padding:3px 10px; border-radius:20px; font-size:.78rem; }
    .badge-ause { background:#fee2e2; color:#991b1b; border:1px solid #fecaca; padding:3px 10px; border-radius:20px; font-size:.78rem; }
    .rep-info-bar { display:flex; flex-wrap:wrap; gap:8px; margin-bottom:14px; }
    .rep-info-chip { background:#f0f6ff; border:1px solid #b0c4d8; border-radius:20px; padding:4px 14px; font-size:0.8rem; color:#3a6080; }
    .rep-info-chip strong { color:#1a2a3a; }
    .rep-count { font-size:0.8rem; color:#5a7a95; margin-top:10px; text-align:right; }
    .loading-box { text-align:center; padding:30px; color:#5a7a95; font-size:0.9rem; }
    .step-badge { display:inline-block; background:#e8f0fb; color:#0d6efd; font-size:0.72rem; font-weight:700; border-radius:5px; padding:2px 7px; margin-bottom:5px; }
    .curso-hint { font-size:0.8rem; color:#5a7a95; margin-top:6px; }
    .btn-cambiar {
        background:#e8f0fb; color:#1a4a8a;
        border:1px solid #b0c4d8; border-radius:8px;
        padding:6px 14px; font-size:0.82rem;
        cursor:pointer; transition:background .2s;
    }
    .btn-cambiar:hover  { background:#0d6efd; color:#fff; }
    .btn-cambiar:disabled { opacity:0.5; cursor:not-allowed; }
</style>

<div class="rep-wrapper">
    <div class="rep-card">
        <div class="rep-header">
            <div class="rep-icon">&#128104;&#8205;&#127979;</div>
            <p class="rep-title">Panel del Catedratico — Asistencia por Curso</p>
        </div>
        <p class="rep-subtitle">
            Selecciona un curso para ver la lista de estudiantes y su estado de asistencia.
        </p>
        <hr class="rep-divider">

        <div class="mb-3">
            <div class="step-badge">PASO 1</div>
            <div class="rep-label">Selecciona tu curso</div>
            <select id="curso_select_panel" class="rep-select">
                <option value="">— Seleccione un curso —</option>
                <?php
                $sql = "SELECT cur_curso AS id, cur_nombre AS nombre,
                               cur_horario_inicio AS inicio, cur_horario_fin AS fin,
                               cur_seccion AS seccion
                        FROM siu_curso
                        WHERE usu_usuario = '$id_usuario_actual'
                        AND cur_activo = 1
                        ORDER BY cur_horario_inicio ASC";
                $res = $conn->query($sql);
                if ($res && $res->num_rows > 0) {
                    while ($c = $res->fetch_assoc()) {
                        echo "<option value='{$c['id']}'>";
                        echo "[{$c['id']}] {$c['nombre']} | Seccion {$c['seccion']} | {$c['inicio']} - {$c['fin']}";
                        echo "</option>";
                    }
                } else {
                    echo '<option value="">— Sin cursos asignados —</option>';
                }
                ?>
            </select>
            <p class="curso-hint">El listado muestra: ID · Nombre · Seccion · Horario inicio - fin</p>
        </div>

        <button class="rep-btn" id="btn_ver_panel">
            Ver Asistencia del Curso
        </button>

        <div id="resultado_panel" class="mt-4"></div>
    </div>
</div>

<script>
// Usamos nombre único para evitar conflictos con otros scripts
window.panelCatedratico = (function () {
    var BASE = "/ProyectoUMGPHP/php/panel_catedratico/php/";

    function asignarBotones() {
        var botones = document.querySelectorAll(".btn-cambiar");
        botones.forEach(function(btn) {
            // Clonar para eliminar listeners previos
            var nuevo = btn.cloneNode(true);
            btn.parentNode.replaceChild(nuevo, btn);

            nuevo.addEventListener("click", function() {
                var idAsistencia = this.getAttribute("data-id");
                var btnRef = this;

                btnRef.disabled = true;
                btnRef.textContent = "Procesando...";

                var formData = new FormData();
                formData.append("id_asistencia", idAsistencia);

                fetch(BASE + "cambiar_asistencia.php", {
                    method: "POST",
                    body: formData
                })
                .then(function(r) { return r.json(); })
                .then(function(data) {
                    if (data.ok) {
                        var celda = document.getElementById("estado_" + idAsistencia);
                        if (data.nuevo == 1) {
                            celda.innerHTML = '<span class="badge-pres">Presente</span>';
                        } else {
                            celda.innerHTML = '<span class="badge-ause">Ausente</span>';
                        }
                        btnRef.textContent = "Cambiar";
                        btnRef.disabled = false;
                    } else {
                        alert("Error: " + data.msg);
                        btnRef.textContent = "Cambiar";
                        btnRef.disabled = false;
                    }
                })
                .catch(function(err) {
                    console.error("Error fetch cambiar:", err);
                    alert("Error de conexion al cambiar asistencia.");
                    btnRef.textContent = "Cambiar";
                    btnRef.disabled = false;
                });
            });
        });
    }

    function cargarAsistencia() {
        var cursoSel = document.getElementById("curso_select_panel");
        if (!cursoSel.value) {
            alert("Por favor selecciona un curso.");
            return;
        }
        var resultado = document.getElementById("resultado_panel");
        resultado.innerHTML = '<div class="loading-box">Cargando asistencia...</div>';

        fetch(BASE + "get_asistencia_curso.php?id_curso=" + cursoSel.value)
            .then(function(r) { return r.text(); })
            .then(function(html) {
                resultado.innerHTML = html;
                // Asignar eventos DESPUÉS de insertar el HTML
                asignarBotones();
            })
            .catch(function() {
                resultado.innerHTML = "<div class='alert alert-danger mt-3'>Error al cargar.</div>";
            });
    }

    var btnVer  = document.getElementById("btn_ver_panel");
    var cursoS  = document.getElementById("curso_select_panel");

    if (btnVer) btnVer.addEventListener("click", cargarAsistencia);
    if (cursoS) cursoS.addEventListener("change", function() {
        if (this.value) cargarAsistencia();
    });

    return { cargarAsistencia: cargarAsistencia };
})();
</script>