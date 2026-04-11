<?php
include("conexion.php");

$sede = $_POST['sede'] ?? '';
$salon = $_POST['salon'] ?? '';
$fecha = $_POST['fecha'] ?? '';

if($sede && $salon && $fecha){
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
    $res = mysqli_query($conn,$query);

    echo '<table class="table table-dark table-striped table-bordered align-middle">';
    echo '<thead><tr>
            <th>Sede</th><th>Salón</th><th>Fecha</th>
            <th>Nombre</th><th>Apellido</th><th>Correo</th><th>Hora</th><th>Foto</th>
          </tr></thead><tbody>';

    if(mysqli_num_rows($res)>0){
        while($row=mysqli_fetch_assoc($res)){
            echo '<tr>
                    <td>'.$row['sede'].'</td>
                    <td>'.$row['salon'].'</td>
                    <td>'.$row['fecha'].'</td>
                    <td>'.$row['usu_nombre'].'</td>
                    <td>'.$row['usu_apellido'].'</td>
                    <td>'.$row['usu_correo'].'</td>
                    <td>'.$row['hora'].'</td>
                    <td>';
            if($row['usu_foto']){
                echo '<img src="IMG/'.$row['usu_foto'].'" 
                           class="img-thumbnail rounded-circle" 
                           style="width:40px; height:40px; object-fit:cover;">';
            } else {
                echo '<span class="text-muted">Sin foto</span>';
            }
            echo '</td></tr>';
        }
    } else {
        echo '<tr><td colspan="8" class="text-center text-warning">No se encontraron registros</td></tr>';
    }

    echo '</tbody></table>';
} else {
    echo "<p class='text-muted'>Seleccione sede, salón y fecha para ver los ingresos.</p>";
}
?>