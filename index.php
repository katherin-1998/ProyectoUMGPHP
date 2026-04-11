<?php
session_start();
if(!isset($_SESSION['usu_id'])){
    header("Location: login.php");
    exit();
}
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
            <img src="<?php echo !empty($_SESSION['usu_foto']) ? $_SESSION['usu_foto'] : 'IMG/Administrador.png'; ?>" alt="Foto" class="user-photo">
            <p class="text-white fw-bold"><?php echo $_SESSION['usu_nombre'].' '.$_SESSION['usu_apellido']; ?></p>
            <ul class="nav flex-column mt-3">
                <li class="nav-item"><a href="#" class="nav-link active" onclick="mostrarDashboard(); return false;">Dashboard</a></li>
                <li class="nav-item"><a href="#" class="nav-link" onclick="mostrarRegistro(); return false;">Registro de personas</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Búsqueda de personas registradas</a></li>
                <li class="nav-item"><a href="#" class="nav-link" onclick="mostrarIngresoPuerta(); return false;">Ingreso por puerta</a></li>
                <li class="nav-item"><a href="#" class="nav-link" onclick="mostrarIngresoSalon(); return false;">Ingreso por salón</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Entrar modelo</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Arbol de Asistencias</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Restricciones</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Gestión de cursos</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Reportes por puerta</a></li>
                <li class="nav-item"><a href="#" class="nav-link" onclick="mostrarReporteSalon(); return false;">Reportes por salón</a></li>
                <li class="nav-item"><a href="#" class="nav-link" onclick="mostrarReporteFecha(); return false;">Reportes por fecha y salón</a></li>
                <li class="nav-item"><a href="#" class="nav-link" onclick="mostrarPanelCatedratico(); return false;">Panel Catedrático</a></li>
            </ul>
        </div>

        <!-- Contenido principal -->
        <div class="col-md-10 p-4 text-white">
            <div class="d-flex justify-content-end mb-3">
                <a href="cerrar_sesion_be.php" class="btn btn-danger">Cerrar sesión</a>
            </div>

            <!-- ✅ CORREGIDO: id="contenido" que faltaba -->
            <div id="contenido">
                <h2>Bienvenido, <?php echo $_SESSION['usu_nombre']; ?></h2>
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
// ✅ Función reutilizable para cargar páginas y re-ejecutar sus scripts
function cargarContenido(url) {
    fetch(url)
        .then(res => {
            if (!res.ok) throw new Error("HTTP " + res.status);
            return res.text();
        })
        .then(html => {
            document.getElementById("contenido").innerHTML = html;
            // Re-ejecutar scripts embebidos en el HTML cargado
            const tempDiv = document.createElement("div");
            tempDiv.innerHTML = html;
            tempDiv.querySelectorAll("script").forEach(oldScript => {
                const newScript = document.createElement("script");
                newScript.textContent = oldScript.textContent;
                document.body.appendChild(newScript);
            });
        })
        .catch(err => console.error("Error cargando " + url + ":", err));
}

function mostrarDashboard() {
    document.getElementById("contenido").innerHTML = `
        <h2>Bienvenido, <?php echo $_SESSION['usu_nombre']; ?></h2>
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
    cargarContenido("tabla_registro.php");
}

// ✅ Sin duplicado — solo una definición
function mostrarIngresoPuerta() {
    fetch("ingreso_puerta.php")
        .then(res => {
            if (!res.ok) throw new Error("HTTP " + res.status);
            return res.text();
        })
        .then(html => {
            document.getElementById("contenido").innerHTML = html;
            const form = document.getElementById("formFiltros");
            if (form) {
                form.addEventListener("submit", function(e) {
                    e.preventDefault();
                    fetch("ingreso_puerta_ajax.php", { method: "POST", body: new FormData(form) })
                        .then(res => res.text())
                        .then(html => { document.getElementById("tablaResultados").innerHTML = html; })
                        .catch(err => console.error("Error:", err));
                });
            }
        })
        .catch(err => console.error("Error cargando ingreso_puerta.php:", err));
}

// ✅ Sin duplicado — solo una definición
function mostrarIngresoSalon() {
    fetch("ingreso_salon.php")
        .then(res => {
            if (!res.ok) throw new Error("HTTP " + res.status);
            return res.text();
        })
        .then(html => {
            document.getElementById("contenido").innerHTML = html;
            const form = document.getElementById("formSalon");
            if (form) {
                form.addEventListener("submit", function(e) {
                    e.preventDefault();
                    fetch("ingreso_salon_ajax.php", { method: "POST", body: new FormData(form) })
                        .then(res => res.text())
                        .then(html => { document.getElementById("tablaSalon").innerHTML = html; })
                        .catch(err => console.error("Error:", err));
                });
            }
        })
        .catch(err => console.error("Error cargando ingreso_salon.php:", err));
}

function mostrarReporteSalon() {
    cargarContenido("php/reporte_salon/index.php");
}

function mostrarReporteFecha() {
    cargarContenido("php/reporte_salon/reporte_fecha.php");
}

function mostrarPanelCatedratico() {
    cargarContenido("php/panel_catedratico/index.php");
}
</script>

</body>
</html>