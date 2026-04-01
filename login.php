<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Universidad Mariano Gálvez</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/estilos.css">
</head>
<body>
    <header class="header-umg-limpio">
        <div class="contenedor-header-centrado">
            <img src="assets/images/Logo4.png" alt="Logo UMG" class="logo-umg-grande">
            <h1 class="nombre-universidad-grande">UNIVERSIDAD MARIANO GÁLVEZ</h1>
        </div>
    </header>

    <main class="main-login-azul">
        <div class="contenedor_todo">
            <div class="contenedor_login-register">
                <form action="login_usuario_be.php" method="POST">
                    <h2>Iniciar Sesión</h2>
                    <input type="text" placeholder="Correo Electrónico" name="correo" required>
                    <input type="password" placeholder="Contraseña" name="contrasena" required>
                    <button type="submit">Entrar</button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
