<?php
// Este archivo consulta los datos completos del usuario
// que acaba de iniciar sesión y los guarda en SESSION

// Incluimos la conexión a la base de datos
include("conexion.php");

// Obtenemos el ID del usuario que acaba de entrar
$usu_id = $_SESSION['usu_id'];

// Consultamos todos sus datos desde la base de datos
// incluyendo su tipo de usuario y carrera
$query = "SELECT u.*, t.tiu_descripcion, c.car_nombre
          FROM siu_usuario u
          INNER JOIN siu_tipo_usuario t ON u.tiu_tipo_usuario = t.tiu_tipo_usuario
          LEFT JOIN siu_carrera c ON u.car_carrera = c.car_carrera
          WHERE u.usu_usuario = '$usu_id'";

$resultado = mysqli_query($conn, $query);
$usuario = mysqli_fetch_assoc($resultado);

// Guardamos todos los datos en SESSION
// para que cualquier página del sistema pueda usarlos
$_SESSION['usu_id']        = $usuario['usu_usuario'];
$_SESSION['usu_nombre']    = $usuario['usu_nombre'];
$_SESSION['usu_apellido']  = $usuario['usu_apellido'];
$_SESSION['usu_correo']    = $usuario['usu_correo'];
// usu_identificador es el carnet/codigo del usuario en la tabla siu_usuario
$_SESSION['usu_carnet']    = $usuario['usu_identificador'];
$_SESSION['usu_telefono']  = $usuario['usu_telefono'];
$_SESSION['usu_foto']      = $usuario['usu_foto'];
$_SESSION['usu_seccion']   = $usuario['usu_seccion'];
$_SESSION['usu_tipo']      = $usuario['tiu_tipo_usuario'];
$_SESSION['usu_tipo_desc'] = $usuario['tiu_descripcion'];
$_SESSION['usu_carrera']   = $usuario['car_nombre'];

// Redirigimos según el tipo de usuario
// Solo existen dos tipos: ADMIN y PROFESOR
switch($usuario['tiu_tipo_usuario']){
    case 2: // PROFESOR
        header("Location: profesor.php");
        break;
    case 3: // ADMIN
        header("Location: index.php");
        break;
    default: // Cualquier otro tipo no tiene acceso
        echo '<script>
            alert("No tienes permiso para acceder al sistema");
            window.location = "login.php";
        </script>';
        break;
}
exit;
?>