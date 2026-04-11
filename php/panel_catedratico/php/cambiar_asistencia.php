<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

ini_set('display_errors', 1);
error_reporting(E_ALL);

include($_SERVER['DOCUMENT_ROOT'] . "/ProyectoUMGPHP/conexion.php");

// Si no llega POST, devolver error claro
if (!isset($_POST['id_asistencia'])) {
    echo json_encode([
        'ok'  => false, 
        'msg' => 'No llego el POST. Metodo: ' . $_SERVER['REQUEST_METHOD']
    ]);
    exit;
}

$id_asistencia = $conn->real_escape_string($_POST['id_asistencia']);

if (!$id_asistencia) {
    echo json_encode(['ok' => false, 'msg' => 'ID vacio']);
    exit;
}

$res = $conn->query("SELECT asi_presente FROM siu_asistencia WHERE asi_asistencia = '$id_asistencia'");

if (!$res || $res->num_rows === 0) {
    echo json_encode(['ok' => false, 'msg' => 'No encontrado. ID: ' . $id_asistencia]);
    exit;
}

$fila         = $res->fetch_assoc();
$nuevo_estado = $fila['asi_presente'] == 1 ? 0 : 1;
$update       = $conn->query("UPDATE siu_asistencia SET asi_presente = $nuevo_estado WHERE asi_asistencia = '$id_asistencia'");

if ($update) {
    echo json_encode(['ok' => true, 'nuevo' => $nuevo_estado, 'msg' => 'OK']);
} else {
    echo json_encode(['ok' => false, 'msg' => $conn->error]);
}
?>