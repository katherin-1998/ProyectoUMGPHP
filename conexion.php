<?php
$host = "localhost";
$user = "root";
$pass = "UX6ClfMEE7";
$db   = "sistema_umg";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}
?>


 