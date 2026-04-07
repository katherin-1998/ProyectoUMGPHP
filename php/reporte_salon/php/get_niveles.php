<?php
header('Content-Type: application/json');
include("../../../conexion.php");

if (!isset($_GET['id_instalacion']) || empty($_GET['id_instalacion'])) {
    echo json_encode([]);
    exit;
}

$id = $conn->real_escape_string($_GET['id_instalacion']);
$res = $conn->query("SELECT niv_nivel AS id_nivel, niv_nombre AS nombre_nivel FROM siu_nivel WHERE sed_sede = '$id'");

if (!$res) {
    echo json_encode(["error" => $conn->error]);
    exit;
}

echo json_encode($res->fetch_all(MYSQLI_ASSOC));
?>