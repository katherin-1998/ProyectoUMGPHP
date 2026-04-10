<?php
header('Content-Type: application/json');
include($_SERVER['DOCUMENT_ROOT'] . "/ProyectoUMGPHP/conexion.php");

$id_usuario = isset($_GET['id_usuario']) ? $conn->real_escape_string($_GET['id_usuario']) : '';

if (!$id_usuario) {
    echo json_encode([]);
    exit;
}

$sql = "
    SELECT 
        cur_curso        AS id,
        cur_nombre       AS nombre,
        cur_horario_inicio AS inicio,
        cur_horario_fin    AS fin,
        cur_seccion      AS seccion
    FROM siu_curso
    WHERE usu_usuario = '$id_usuario'
      AND cur_activo = 1
    ORDER BY cur_horario_inicio ASC
";

$res = $conn->query($sql);
echo json_encode($res ? $res->fetch_all(MYSQLI_ASSOC) : []);
?>