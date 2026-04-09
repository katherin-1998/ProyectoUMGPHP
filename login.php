<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Universidad Mariano Gálvez</title>
    <!-- Fuente Roboto de Google -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <!-- Estilos propios del proyecto -->
    <link rel="stylesheet" href="assets/css/estilos.css">
</head>
<body>

    <!-- Encabezado con logo y nombre de la universidad -->
    <header class="header-umg-limpio">
        <div class="contenedor-header-centrado">
            <img src="assets/images/Logo4.png" alt="Logo UMG" class="logo-umg-grande">
            <h1 class="nombre-universidad-grande">UNIVERSIDAD MARIANO GÁLVEZ</h1>
        </div>
    </header>

    <!-- Sección principal con el formulario de login -->
    <main class="main-login-azul">
        <div class="contenedor__todo">
            <div class="contenedor__login-register">

                <!-- Formulario que envía los datos a login_usuario_be.php -->
                <!-- method="POST" significa que los datos van ocultos en la petición -->
                <form action="login_usuario_be.php" method="POST" class="formulario__login">
                    <h2>Iniciar Sesión</h2>

                    <!-- Campo para el identificador: carnet o código de usuario -->
                    <input type="text" placeholder="Usuario" name="identificador" required>

                    <!-- Campo para la contraseña, type="password" oculta lo que escribe -->
                    <input type="password" placeholder="Contraseña" name="contrasena" required>

                    <!-- Botón que envía el formulario -->
                    <button type="submit">Entrar</button>
                </form>

            </div>
        </div>
    </main>

</body>
</html>
