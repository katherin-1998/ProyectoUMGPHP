<form action="registro.php" method="post" enctype="multipart/form-data">
    <label>Administrador</label>
    <input type="text" name="nombre" required><br>

    <label>Tipo:</label>
    <select name="tipo">
        <option value="Estudiante">Estudiante</option>
        <option value="Docente">Docente</option>
        <option value="Admin">Admin</option>
    </select><br>

    <label>Foto:</label>
    <input type="file" name="foto" required><br>

    <button type="submit">Registrar</button>
</form>
<?php
include("conexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $tipo = $_POST['tipo'];

    // Carpeta de destino
    $directorio = "IMG/";
    $archivo = $directorio . basename($_FILES["foto"]["name"]);

    // Subir archivo
    if (move_uploaded_file($_FILES["foto"]["tmp_name"], $archivo)) {
        // Guardar en la base de datos
        $sql = "INSERT INTO personas (nombre, tipo, foto) VALUES ('$nombre', '$tipo', '$archivo')";
        if ($conn->query($sql) === TRUE) {
            echo "Persona registrada con éxito.";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Error al subir la foto.";
    }
}
?>