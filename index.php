<?php
//session_start();

// Seguridad: si no hay sesión activa, regresa al login
//if(!isset($_SESSION['usuario'])){
   // header("Location: login.php");
   // exit();
//}
//include("conexion.php");
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
            <img src="IMG/Administrador.png" alt="Administrador" class="user-photo">
            <p class="text-white fw-bold">Administrador</p>
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
                <li class="nav-item"><a href="#" class="nav-link">Reportes por salón</a></li>
            </ul>
        </div>

        <!-- Contenido principal -->
        <div class="col-md-10 p-4 text-white">
            <div class="d-flex justify-content-end mb-3">
                <a href="cerrar_sesion_be.php" class="btn btn-danger">Cerrar sesión</a>
            </div>

            <!-- Área dinámica -->
            <div id="contenido">
                <!-- Dashboard por defecto -->
                <h2>Bienvenido al sistema</h2>
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
    // Cargar tabla desde archivo PHP externo
    fetch("tabla_registro.php")
        .then(res => res.text())
        .then(html => {
            document.getElementById("contenido").innerHTML = html;
        });
}
</script>

</body>
</html>
