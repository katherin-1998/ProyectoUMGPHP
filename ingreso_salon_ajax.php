<?php
include("conexion.php");

$sede  = $_POST['sede']  ?? '';
$salon = $_POST['salon'] ?? '';
$fecha = $_POST['fecha'] ?? '';

if ($sede && $salon && $fecha) {
    $query = "SELECT s.sed_nombre AS sede,
                     sa.sal_nombre AS salon,
                     DATE(r.reg_fecha_hora) AS fecha,
                     u.usu_nombre, u.usu_apellido, u.usu_correo, u.usu_foto,
                     TIME(r.reg_fecha_hora) AS hora
              FROM siu_registro_ingreso r
              JOIN siu_usuario u ON r.usu_usuario = u.usu_usuario
              JOIN siu_salon sa ON r.sal_salon = sa.sal_salon
              JOIN siu_sede s ON sa.sed_sede = s.sed_sede
              WHERE s.sed_sede='".mysqli_real_escape_string($conn,$sede)."'
                AND sa.sal_salon='".mysqli_real_escape_string($conn,$salon)."'
                AND DATE(r.reg_fecha_hora)='".mysqli_real_escape_string($conn,$fecha)."'
              ORDER BY hora ASC";

    $res = mysqli_query($conn, $query);

    echo '<style>
        .rep-table-wrap { overflow-x:auto; margin-top:20px; }
        .rep-table { width:100%; border-collapse:collapse; font-size:0.88rem; color:#1a2a3a; }
        .rep-table thead tr { background:#e8f0fb; color:#1a4a8a; text-transform:uppercase; font-size:0.75rem; letter-spacing:.05em; }
        .rep-table th, .rep-table td { padding:10px 14px; border-bottom:1px solid #e0e8f0; white-space:nowrap; }
        .rep-table tbody tr:hover { background:#f0f6ff; }
        .rep-table tbody tr:nth-child(even) { background:#f8fafc; }
        .rep-count { font-size:0.8rem; color:#5a7a95; margin-top:10px; text-align:right; }
    </style>';

    $total = mysqli_num_rows($res);
    echo '<div class="rep-table-wrap">';
    echo '<table class="rep-table">';
    echo '<thead><tr>
            <th>Sede</th><th>Salón</th><th>Fecha</th>
            <th>Nombre</th><th>Apellido</th><th>Correo</th><th>Hora</th><th>Foto</th>
          </tr></thead><tbody>';

    if ($total > 0) {
        while ($row = mysqli_fetch_assoc($res)) {
            echo '<tr>
                    <td>'.$row['sede'].'</td>
                    <td>'.$row['salon'].'</td>
                    <td>'.$row['fecha'].'</td>
                    <td>'.$row['usu_nombre'].'</td>
                    <td>'.$row['usu_apellido'].'</td>
                    <td>'.$row['usu_correo'].'</td>
                    <td>'.$row['hora'].'</td>
                    <td>';
            if ($row['usu_foto']) {
                echo '<img src="IMG/'.$row['usu_foto'].'" alt="Foto"
                           style="width:38px;height:38px;border-radius:50%;object-fit:cover;border:2px solid #b0c4d8;">';
            } else {
                echo '<span style="color:#5a7a95;font-size:0.8rem;">Sin foto</span>';
            }
            echo '</td></tr>';
        }
    } else {
        echo '<tr><td colspan="8" style="text-align:center;padding:20px;color:#5a7a95;">No se encontraron registros</td></tr>';
    }

    echo '</tbody></table>';
    echo '<p class="rep-count">Total de registros: <strong>'.$total.'</strong></p>';
    echo '</div>';
} else {
    echo "<p style='color:#5a7a95;padding:20px;text-align:center;'>Seleccione sede, salón y fecha para ver los ingresos.</p>";
}
?>
