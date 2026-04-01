<?php
include("conexion.php");
$sql = "SELECT p.id, p.nombre, p.curso, p.seccion, p.foto, i.fecha_hora 
        FROM ingresos i 
        JOIN personas p ON i.persona_id = p.id 
        ORDER BY i.fecha_hora DESC LIMIT 10";
$res = $conn->query($sql);

echo "<h2>Últimos ingresos</h2>";
echo "<table class='table table-dark table-striped'>
        <thead>
            <tr>
                <th>✔</th>
                <th>Nombre</th>
                <th>Curso</th>
                <th>Sección</th>
                <th>Foto</th>
            </tr>
        </thead>
        <tbody>";
while($row = $res->fetch_assoc()){
    echo "<tr>
            <td><input type='checkbox' value='{$row['id']}'></td>
            <td>{$row['nombre']}</td>
            <td>{$row['curso']}</td>
            <td>{$row['seccion']}</td>
            <td><img src='{$row['foto']}' width='60' height='60' style='border-radius:50%;'></td>
          </tr>";
}
echo "</tbody></table>";
?>
