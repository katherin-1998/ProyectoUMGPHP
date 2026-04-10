<?php
header('Content-Type: text/html; charset=utf-8');
include("../../../conexion.php");

$id_salon = isset($_GET['id_salon']) ? trim($_GET['id_salon']) : '';
if (!$id_salon) { 
    echo "<div class='alert alert-warning'>Falta el salón.</div>"; 
    exit; 
}

// ✅ PREPARED STATEMENT para la primera consulta
$stmt = $conn->prepare("
    SELECT sal.sal_nombre, niv.niv_nombre, sed.sed_nombre
    FROM siu_salon sal
    JOIN siu_nivel niv ON sal.niv_nivel = niv.niv_nivel
    JOIN siu_sede  sed ON sal.sed_sede  = sed.sed_sede
    WHERE sal.sal_salon = ?
");
$stmt->bind_param("s", $id_salon);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<div class='alert alert-warning'>Salón no encontrado.</div>";
    exit;
}
$info = $result->fetch_assoc();
$stmt->close();

//  PREPARED STATEMENT para la segunda consulta
$stmt = $conn->prepare("
    SELECT u.usu_nombre, u.usu_apellido, u.usu_identificador,
           t.tiu_descripcion AS tipo,
           c.cur_nombre, a.asi_fecha, a.asi_presente
    FROM siu_asistencia a
    JOIN siu_usuario      u ON a.usu_usuario     = u.usu_usuario
    JOIN siu_tipo_usuario t ON u.tiu_tipo_usuario = t.tiu_tipo_usuario
    JOIN siu_curso        c ON a.cur_curso        = c.cur_curso
    WHERE c.sal_salon = ?
    ORDER BY t.tiu_tipo_usuario ASC, u.usu_apellido ASC
");
$stmt->bind_param("s", $id_salon);
$stmt->execute();
$result = $stmt->get_result();
$filas = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<div class="rep-info-bar mt-3">
    <span class="rep-info-chip"> Sede: <strong><?= htmlspecialchars($info['sed_nombre']) ?></strong></span>
    <span class="rep-info-chip"> Nivel: <strong><?= htmlspecialchars($info['niv_nombre']) ?></strong></span>
    <span class="rep-info-chip"> Salón: <strong><?= htmlspecialchars($info['sal_nombre']) ?></strong></span>
</div>

<?php if (empty($filas)): ?>
    <div class="alert alert-warning mt-2">No hay registros históricos para este salón.</div>
<?php else: ?>
    <div class="rep-table-wrap">
        <table class="rep-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Identificador</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Tipo</th>
                    <th>Curso</th>
                    <th>Fecha</th>
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
                            ? '<span class="badge-prof">Catedrático</span>'
                            : '<span class="badge-est">Estudiante</span>' ?>
                    </td>
                    <td><?= htmlspecialchars($f['cur_nombre']) ?></td>
                    <td><?= htmlspecialchars($f['asi_fecha']) ?></td>
                    <td>
                        <?= $f['asi_presente'] == 1
                            ? '<span class="badge-pres">Presente</span>'
                            : '<span class="badge-ause">Ausente</span>' ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <p class="rep-count">Total de registros: <?= count($filas) ?></p>
<?php endif; ?>