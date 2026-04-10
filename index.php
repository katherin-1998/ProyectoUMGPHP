<?php
//session_start();
//if(!isset($_SESSION['usuario'])){
//    header("Location: login.php");
//    exit();
//}
//include("conexion.php");

//lo que to debo agregar
// AHORA: se activa la sesión y se valida con la variable correcta
/*session_start();
if(!isset($_SESSION['usu_id'])){
    header("Location: login.php");
    exit();
}
// =========================================
?>*/


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard BiometricUMG</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { background-color: #000; }
        .sidebar { background-color: #001f3f; min-height: 100vh; }
        .sidebar .nav-link { color: #fff; padding: 12px; margin: 4px 0; border-radius: 4px; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background-color: #3399ff; color: #000; }
        .user-photo { width: 100px; height: 100px; border-radius: 50%; object-fit: cover; margin-bottom: 10px; }
        table img { width: 60px; height: 60px; border-radius: 50%; object-fit: cover; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- Menú lateral -->
        <div class="col-md-2 sidebar p-3 text-center">
           <!-- ANTES: foto hardcodeada siempre mostraba la misma imagen -->
 <!--  <img src="IMG/Administrador.png" alt="Administrador" class="user-photo"> -->

<!-- AHORA: muestra la foto del usuario desde sesión, si no tiene foto usa la imagen por defecto -->
 <img src="<?php echo !empty($_SESSION['usu_foto']) ? $_SESSION['usu_foto'] : 'IMG/Administrador.png'; ?>" alt="Foto" class="user-photo"> 
           

<!-- ANTES: nombre hardcodeado siempre mostraba "Administrador" -->
 <!--<p class="text-white fw-bold">Administrador</p> -->

<!-- AHORA: muestra el nombre y apellido del usuario desde sesión -->
 <p class="text-white fw-bold">
    <?php echo $_SESSION['usu_nombre'].' '.$_SESSION['usu_apellido']; ?>
</p> 

 <!-- Datos adicionales del usuario desde sesión -->
 <p class="text-white" style="font-size: 0.8rem;">
  <?php echo $_SESSION['usu_nombre'].' '.$_SESSION['usu_apellido']; ?>
</p>
<p class="text-white" style="font-size: 0.8rem;">   <?php echo $_SESSION['usu_correo']; ?>
</p>
<p class="text-white" style="font-size: 0.8rem;">
    <?php echo $_SESSION['usu_tipo_desc']; ?>
</p>
<p class="text-white" style="font-size: 0.8rem;">
    <?php echo $_SESSION['usu_carnet']; ?>
</p>
<p class="text-white" style="font-size: 0.8rem;">
    <?php echo $_SESSION['usu_telefono']; ?>
</p> 



            <ul class="nav flex-column mt-3">
                <li class="nav-item"><a href="#" class="nav-link active" onclick="mostrarDashboard()">Dashboard</a></li>
                <li class="nav-item"><a href="#" class="nav-link" onclick="mostrarRegistro()">Registro de personas</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Búsqueda de personas registradas</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Ingreso por puerta</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Ingreso por salón</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Entrar modelo</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Arbol de Asistencias</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Restricciones</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Gestión de cursos</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Reportes por puerta</a></li>
                <li class="nav-item"><a href="#" class="nav-link" onclick="mostrarReporteSalon()">Reportes por salón</a></li>
                <li class="nav-item"><a href="#" class="nav-link" onclick="mostrarReporteFecha()">Reportes por fecha y salón</a></li>
            </ul>
        </div>

        <!-- Contenido principal -->
        <div class="col-md-10 p-4 text-white">
            <div class="d-flex justify-content-end mb-3">
                <a href="cerrar_sesion_be.php" class="btn btn-danger">Cerrar sesión</a>
            </div>

            <!-- Área dinámica -->
<!-- ANTES: mensaje generico -->
<h2>Bienvenido al sistema</h2>

<!-- AHORA: mensaje personalizado con el nombre del usuario -->
<!-- <h2>Bienvenido, <?php echo $_SESSION['usu_nombre']; ?></h2>--> 
            
                <p><?php echo date("l, d F Y"); ?></p>
                <div class="alert alert-info text-dark">
                    <strong>Próximas capacitaciones:</strong> Aquí puedes mostrar información sobre cursos, talleres o eventos próximos.
                </div>
                <h3 class="mt-4">Calendario</h3>
                <iframe src="https://calendar.google.com/calendar/embed?src=tu_correo%40gmail.com&ctz=America%2FGuatemala" 
                        style="border:0" width="100%" height="400" frameborder="0" scrolling="no"></iframe>
            </div>
        </div>
    </div>
</div>

<script>
function mostrarDashboard() {
    document.getElementById("contenido").innerHTML = `
        <h2>Bienvenido al sistema</h2>
        <p><?php echo date("l, d F Y"); ?></p>
        <div class="alert alert-info text-dark">
            <strong>Próximas capacitaciones:</strong> Aquí puedes mostrar información sobre cursos, talleres o eventos próximos.
        </div>
        <h3 class="mt-4">Calendario</h3>
        <iframe src="https://calendar.google.com/calendar/embed?src=tu_correo%40gmail.com&ctz=America%2FGuatemala" 
                style="border:0" width="100%" height="400" frameborder="0" scrolling="no"></iframe>
    `;
}

function mostrarRegistro() {
    fetch("tabla_registro.php")
        .then(res => res.text())
        .then(html => {
            document.getElementById("contenido").innerHTML = html;
        });
}

function mostrarReporteSalon() {
    fetch("php/reporte_salon/index.php")
        .then(res => res.text())
        .then(html => {
            document.getElementById("contenido").innerHTML = html;

            // Ejecutar el script inline que viene dentro del HTML cargado
            const tempDiv = document.createElement("div");
            tempDiv.innerHTML = html;
            tempDiv.querySelectorAll("script").forEach(oldScript => {
                const newScript = document.createElement("script");
                newScript.textContent = oldScript.textContent;
                document.body.appendChild(newScript);
            });
        });
}

function mostrarReporteFecha() {
    fetch("php/reporte_salon/reporte_fecha.php")
        .then(res => res.text())
        .then(html => {
            document.getElementById("contenido").innerHTML = html;

            // Re-ejecutar scripts inline (necesario porque innerHTML no los activa)
            const tempDiv = document.createElement("div");
            tempDiv.innerHTML = html;
            tempDiv.querySelectorAll("script").forEach(oldScript => {
                const newScript = document.createElement("script");
                newScript.textContent = oldScript.textContent;
                document.body.appendChild(newScript);
            });
        });
}
</script>

</body>
</html>