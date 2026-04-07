<?php
header('Content-Type: text/html; charset=utf-8');
include("../../../conexion.php");

$id_salon = isset($_GET['id_salon']) ? $conn->real_escape_string($_GET['id_salon']) : '';
$fecha    = isset($_GET['fecha'])    ? $conn->real_escape_string($_GET['fecha'])    : '';

if (!$id_salon || !$fecha) {
    echo "<div class='alert alert-warning'>Faltan parámetros.</div>";
    exit;
}

$info = $conn->query("
    SELECT sal.sal_nombre, niv.niv_nombre, sed.sed_nombre
    FROM siu_salon sal
    JOIN siu_nivel niv ON sal.niv_nivel = niv.niv_nivel
    JOIN siu_sede  sed ON sal.sed_sede  = sed.sed_sede
    WHERE sal.sal_salon = '$id_salon'
")->fetch_assoc();

$sql = "
    SELECT
        u.usu_nombre,
        u.usu_apellido,
        u.usu_identificador,
        t.tiu_descripcion  AS tipo,
        c.cur_nombre,
        c.cur_horario_inicio,
        c.cur_horario_fin,
        a.asi_fecha,
        a.asi_presente
    FROM siu_asistencia a
    JOIN siu_usuario      u ON a.usu_usuario      = u.usu_usuario
    JOIN siu_tipo_usuario t ON u.tiu_tipo_usuario  = t.tiu_tipo_usuario
    JOIN siu_curso        c ON a.cur_curso         = c.cur_curso
    WHERE c.sal_salon = '$id_salon'
      AND DATE(a.asi_fecha) = '$fecha'
    ORDER BY t.tiu_tipo_usuario ASC, u.usu_apellido ASC
";

$res   = $conn->query($sql);
$filas = $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
?>

<h6 class="text-warning mb-3">
    Sede: <strong><?= htmlspecialchars($info['sed_nombre']) ?></strong> &nbsp;|&nbsp;
    Nivel: <strong><?= htmlspecialchars($info['niv_nombre']) ?></strong> &nbsp;|&nbsp;
    Salón: <strong><?= htmlspecialchars($info['sal_nombre']) ?></strong> &nbsp;|&nbsp;
    Fecha: <strong><?= htmlspecialchars($fecha) ?></strong>
</h6>

<?php if (empty($filas)): ?>
    <div class="alert alert-warning">No hay registros para esta fecha y salón.</div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-dark table-bordered table-hover table-sm">
            <thead class="table-warning text-dark">
                <tr>
                    <th>#</th>
                    <th>Identificador</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Tipo</th>
                    <th>Curso</th>
                    <th>Inicio Clase</th>
                    <th>Fin Clase</th>
                    <th>Fecha Ingreso</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; foreach ($filas as $f): ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= htmlspecialchars($f['usu_identificador']) ?></td>
                    <td><?= htmlspecialchars($f['usu_nombre']) ?></td>
                    <td><?= htmlspecialchars($f['usu_apellido']) ?></td>
                    <td>
                        <?= $f['tipo'] === 'PROFESOR'
                            ? '<span class="badge bg-warning text-dark">Catedrático</span>'
                            : '<span class="badge bg-info text-dark">Estudiante</span>' ?>
                    </td>
                    <td><?= htmlspecialchars($f['cur_nombre']) ?></td>
                    <td><?= htmlspecialchars($f['cur_horario_inicio']) ?></td>
                    <td><?= htmlspecialchars($f['cur_horario_fin']) ?></td>
                    <td><?= htmlspecialchars($f['asi_fecha']) ?></td>
                    <td>
                        <?= $f['asi_presente'] == 1
                            ? '<span class="badge bg-success">Presente</span>'
                            : '<span class="badge bg-danger">Ausente</span>' ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <p class="text-muted small">Total registros: <?= count($filas) ?></p>
<?php endif; ?>