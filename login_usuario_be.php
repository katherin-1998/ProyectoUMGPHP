<?php
// Iniciamos la sesión para poder guardar datos del usuario
session_start();

// Incluimos el archivo de conexión a la base de datos
include("conexion.php"); 

// Capturamos los datos que el usuario escribió en el formulario
$identificador = $_POST['identificador']; // Ej: ADMIN-001, PROF-001, 3590-24-00001
$contrasena    = $_POST['contrasena'];    // Contraseña que escribió el usuario

// Construimos la consulta SQL
// Buscamos al usuario en la tabla siu_usuario
// y traemos también el tipo de usuario (ESTUDIANTE, PROFESOR, ADMIN, SEGURIDAD)
// usando INNER JOIN con la tabla siu_tipo_usuario
// Solo buscamos usuarios activos (usu_activo = 1)
$query = "SELECT u.*, t.tiu_descripcion 
          FROM siu_usuario u
          INNER JOIN siu_tipo_usuario t ON u.tiu_tipo_usuario = t.tiu_tipo_usuario
          WHERE u.usu_carnet = '$identificador'
          AND u.usu_activo = 1";

// Ejecutamos la consulta en la base de datos
$resultado = mysqli_query($conn, $query);

// Verificamos si encontró algún usuario con ese identificador
if(mysqli_num_rows($resultado) > 0){

    // Obtenemos los datos del usuario encontrado como arreglo
    $usuario = mysqli_fetch_assoc($resultado);

    // Verificamos la contraseña usando bcrypt (password_verify)
    // compara la contraseña escrita con el hash guardado en la BD
    if(password_verify($contrasena, $usuario['usu_contrasena'])){

        // Contraseña correcta
        // Guardamos solo el ID en SESSION temporalmente
        // sesion.php se encargará de traer el resto de datos
        $_SESSION['usu_id'] = $usuario['usu_usuario'];

        // Llamamos a sesion.php que consulta los datos completos
        // y redirige según el tipo de usuario
        include("sesion.php");
        exit;

    } else {
        // La contraseña no coincide con el hash guardado
        echo '<script>
            alert("Contraseña incorrecta");
            window.location = "login.php";
        </script>';
        exit;
    }

} else {
    // No se encontró ningún usuario con ese identificador
    // o el usuario está inactivo (usu_activo = 0)
    echo '<script>
        alert("Usuario no encontrado o inactivo");
        window.location = "login.php";
    </script>';
    exit;
}
?>
