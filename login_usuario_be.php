<?php
session_start();
include("conexion.php"); 

$correo = $_POST['correo'];
$contrasena = $_POST['contrasena'];

// Aquí cambias 'usuarios' por el nombre real de tu tabla
$sql = "SELECT * FROM siu_usuario_bkp WHERE correo='$correo' AND contrasena='$contrasena'";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $_SESSION['usuario'] = $correo;
    header("Location: index.php");
    exit();
} else {
    echo '<script>
            alert("Usuario o contraseña incorrectos");
            window.location = "login.php";
          </script>';
}
?>

