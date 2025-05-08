<?php include('conexion.php'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Cargo</title>
</head>
<body>
    <h1>CREAR CARGO</h1>
    <form action="guardar_cargos.php" method="POST">
        <label for="nom_cargo">Nombre del cargo:</label>
        <input type="text" id="nom_cargo" name="nom_cargo" required>
        <button type="submit">Guardar Cargo</button>
    </form>
    <p><a href="consultar_cargos.php">Consultar Cargos</a></p>
</body>
</html>
