<?php include("conexion.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard BiometricUMG</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #000; /* Fondo negro */
        }
        .sidebar {
            background-color: #001f3f; /* Azul oscuro */
            min-height: 100vh;
        }
        .sidebar .nav-link {
            color: #fff;
            padding: 12px;
            margin: 4px 0;
            border-radius: 4px;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: #3399ff; /* Celeste */
            color: #000;
        }
        .user-photo {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- Menú lateral -->
        <div class="col-md-2 sidebar p-3 text-center">
            <!-- Foto del usuario -->
            <img src="IMG/Administrador.png" alt="Administrador" class="user-photo">
            <p class="text-white fw-bold">Administrador</p>


            <!-- Opciones del menú -->
            <ul class="nav flex-column mt-3">
                <li class="nav-item"><a href="index.php" class="nav-link active">Dashboard</a></li>
                <li class="nav-item"><a href="registro.php" class="nav-link">Registro de personas</a></li>
                <li class="nav-item"><a href="busqueda.php" class="nav-link">Búsqueda de personas registradas</a></li>
                <li class="nav-item"><a href="puerta.php" class="nav-link">Ingreso por puerta</a></li>
                <li class="nav-item"><a href="salon.php" class="nav-link">Ingreso por salón</a></li>
                <li class="nav-item"><a href="cursos.php" class="nav-link">Gestión de cursos</a></li>
                <li class="nav-item"><a href="reportes_puerta.php" class="nav-link">Reportes por puerta</a></li>
                <li class="nav-item"><a href="reportes_salon.php" class="nav-link">Reportes por salón</a></li>
            </ul>
        </div>

        <!-- Contenido principal -->
        <div class="col-md-10 p-4 text-white">
            <h2>Bienvenido al sistema de Registro de biometria</h2>
            <p><?php echo date("l, d F Y"); ?></p>

            <!-- Banner informativo -->
            <div class="alert alert-info text-dark">
                <strong>Próximas capacitaciones:</strong> Aquí puedes mostrar información sobre cursos, talleres o eventos próximos.
            </div>

            <!-- Calendario -->
            <h3 class="mt-4">Calendario</h3>
            <iframe src="https://calendar.google.com/calendar/embed?src=tu_correo%40gmail.com&ctz=America%2FGuatemala" 
                    style="border:0" width="100%" height="400" frameborder="0" scrolling="no"></iframe>
        </div>
    </div>
</div>
        <!-- Botón de cerrar sesión-->
        <div class="d-flex justify-content-end mb-3">
            <a href="logout.php" class="btn btn-danger">Cerrar sesión</a>
        </div>
</body>
</html>
