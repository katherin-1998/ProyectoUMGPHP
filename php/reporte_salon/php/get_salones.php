<?php
header('Content-Type: application/json');
include("../../../conexion.php");

if (!isset($_GET['id_nivel']) || empty($_GET['id_nivel'])) {
    echo json_encode([]);
    exit;
}

$id = $conn->real_escape_string($_GET['id_nivel']);
$res = $conn->query("SELECT sal_salon AS id_salon, sal_nombre AS nombre_salon FROM siu_salon WHERE niv_nivel = '$id'");

if (!$res) {
    echo json_encode(["error" => $conn->error]);
    exit;
}

echo json_encode($res->fetch_all(MYSQLI_ASSOC));
?>