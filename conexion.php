<?php
$servername = "localhost";
$username   = "root";   // tu usuario MySQL
$password   = "Verstappenmybeloved1.";       // tu contraseña MySQL (si no tienes, déjalo vacío)
$database   = "sistema_umg"; 

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>

 