<form action="registro.php" method="post" enctype="multipart/form-data">
    <label>Nombre:</label>
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
