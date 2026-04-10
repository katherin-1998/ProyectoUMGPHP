<?php
header('Content-Type: text/html; charset=utf-8');
include($_SERVER['DOCUMENT_ROOT'] . "/ProyectoUMGPHP/conexion.php");

$id_curso = isset($_GET['id_curso']) ? $conn->real_escape_string($_GET['id_curso']) : '';

if (!$id_curso) {
    echo "<div class='alert alert-warning'>Falta el curso.</div>";
    exit;
}

$infoCurso = $conn->query("
    SELECT c.cur_nombre, c.cur_horario_inicio, c.cur_horario_fin,
           c.cur_seccion, u.usu_nombre, u.usu_apellido
    FROM siu_curso c
    JOIN siu_usuario u ON c.usu_usuario = u.usu_usuario
    WHERE c.cur_curso = '$id_curso'
")->fetch_assoc();

$sql = "
    SELECT 
        u.usu_identificador,
        u.usu_nombre,
        u.usu_apellido,
        a.asi_asistencia,
        a.asi_fecha,
        a.asi_presente
    FROM siu_usuario_curso uc
    JOIN siu_usuario u ON uc.usu_usuario = u.usu_usuario
    LEFT JOIN siu_asistencia a 
        ON a.usu_usuario = uc.usu_usuario 
       AND a.cur_curso   = uc.cur_curso
    WHERE uc.cur_curso = '$id_curso'
      AND u.tiu_tipo_usuario = 1
    ORDER BY u.usu_apellido ASC
";

$res   = $conn->query($sql);
$filas = $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
?>

<style>
    .btn-cambiar {
        background: #1e3a55;
        color: #a8d4f5;
        border: 1px solid #1e4d7a;
        border-radius: 8px;
        padding: 6px 14px;
        font-size: 0.82rem;
        cursor: pointer;
        transition: background .2s;
    }
    .btn-cambiar:hover  { background: #0d6efd; color: #fff; }
    .btn-cambiar:disabled { opacity: 0.5; cursor: not-allowed; }
</style>

<div class="rep-info-bar mb-3">
    <span class="rep-info-chip">Curso: <strong><?= htmlspecialchars($infoCurso['cur_nombre']) ?></strong></span>
    <span class="rep-info-chip">Seccion: <strong><?= htmlspecialchars($infoCurso['cur_seccion']) ?></strong></span>
    <span class="rep-info-chip">Horario: <strong><?= $infoCurso['cur_horario_inicio'] ?> - <?= $infoCurso['cur_horario_fin'] ?></strong></span>
    <span class="rep-info-chip">Catedratico: <strong><?= htmlspecialchars($infoCurso['usu_nombre'].' '.$infoCurso['usu_apellido']) ?></strong></span>
</div>

<?php if (empty($filas)): ?>
    <div class="alert alert-warning">No hay estudiantes registrados en este curso.</div>
<?php else: ?>
    <div class="rep-table-wrap">
        <table class="rep-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Identificador</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Ultima Fecha</th>
                    <th>Estado</th>
                    <th>Cambiar</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; foreach ($filas as $f): ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= htmlspecialchars($f['usu_identificador']) ?></td>
                    <td><?= htmlspecialchars($f['usu_nombre']) ?></td>
                    <td><?= htmlspecialchars($f['usu_apellido']) ?></td>
                    <td><?= $f['asi_fecha'] ?? '<span style="color:#5a8ab0">Sin registro</span>' ?></td>
                    <td id="estado_<?= $f['asi_asistencia'] ?>">
                        <?php if (is_null($f['asi_asistencia'])): ?>
                            <span class="badge-ause">Sin registro</span>
                        <?php elseif ($f['asi_presente'] == 1): ?>
                            <span class="badge-pres">Presente</span>
                        <?php else: ?>
                            <span class="badge-ause">Ausente</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (!is_null($f['asi_asistencia'])): ?>
                            <button 
                                class="btn-cambiar"
                                id="btn_<?= $f['asi_asistencia'] ?>"
                                data-id="<?= $f['asi_asistencia'] ?>">
                                Cambiar
                            </button>
                        <?php else: ?>
                            <span style="color:#5a8ab0; font-size:0.8rem">N/A</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <p class="rep-count">Total estudiantes: <?= count($filas) ?></p>
<?php endif; ?>

<script>
(function() {
    const BASE = "/ProyectoUMGPHP/php/panel_catedratico/php/";

    // Asignar evento a todos los botones cambiar
    document.querySelectorAll(".btn-cambiar").forEach(function(btn) {
        btn.addEventListener("click", function() {
            const idAsistencia = this.getAttribute("data-id");
            const btnRef = this;

            btnRef.disabled = true;
            btnRef.textContent = "Procesando...";

            const formData = new FormData();
            formData.append("id_asistencia", idAsistencia);

            fetch(BASE + "cambiar_asistencia.php", {
                method: "POST",
                body: formData
            })
            .then(function(r) { return r.json(); })
            .then(function(data) {
                if (data.ok) {
                    const celda = document.getElementById("estado_" + idAsistencia);
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
            .catch(function() {
                alert("Error de conexion.");
                btnRef.textContent = "Cambiar";
                btnRef.disabled = false;
            });
        });
    });
})();
</script>