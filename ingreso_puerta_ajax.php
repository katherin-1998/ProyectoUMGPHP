<?php
include("conexion.php");

$filtroSede = isset($_POST['sede']) ? $_POST['sede'] : '';
$filtroFecha = isset($_POST['fecha']) ? $_POST['fecha'] : '';

if ($filtroSede != '' && $filtroFecha != '') {
    $query = "
    SELECT s.sed_nombre AS sede,
           p.pue_nombre AS puerta,
           DATE(r.reg_fecha_hora) AS fecha,
           u.usu_nombre, u.usu_apellido,
           TIME(r.reg_fecha_hora) AS hora,
           u.usu_foto
    FROM siu_registro_ingreso r
    JOIN siu_usuario u ON r.usu_usuario = u.usu_usuario
    JOIN siu_puerta p ON r.pue_puerta = p.pue_puerta
    JOIN siu_sede s ON p.sed_sede = s.sed_sede
    WHERE s.sed_sede = '".mysqli_real_escape_string($conn, $filtroSede)."'
      AND DATE(r.reg_fecha_hora) = '".mysqli_real_escape_string($conn, $filtroFecha)."'
    ORDER BY s.sed_nombre, p.pue_nombre, fecha, hora;
    ";

    $result = mysqli_query($conn, $query);

    echo '<table class="table table-dark table-striped table-bordered align-middle">';
    echo '<thead><tr>
            <th>Sede</th>
            <th>Puerta</th>
            <th>Fecha</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Hora</th>
            <th>Foto</th>
          </tr></thead><tbody>';

    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            echo '<tr>
                    <td>'.$row['sede'].'</td>
                    <td>'.$row['puerta'].'</td>
                    <td>'.$row['fecha'].'</td>
                    <td>'.$row['usu_nombre'].'</td>
                    <td>'.$row['usu_apellido'].'</td>
                    <td>'.$row['hora'].'</td>
                    <td>';
            if($row['usu_foto']){
                echo '<img src="IMG/'.$row['usu_foto'].'" 
                           alt="Foto" 
                           class="img-thumbnail rounded-circle" 
                           style="width:40px; height:40px; object-fit:cover;">';
            } else {
                echo '<span class="text-muted">Sin foto</span>';
            }
            echo '</td></tr>';
        }
    } else {
        echo '<tr><td colspan="7" class="text-center text-warning">No se encontraron registros</td></tr>';
    }

    echo '</tbody></table>';
} else {
    echo "<p class='text-muted'>Seleccione sede y fecha para ver los ingresos.</p>";
}
?>