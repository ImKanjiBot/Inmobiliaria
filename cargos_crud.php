<?php
include ('conexion.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CARGOS</title>
</head>
<body>
    <h1>CREAR CARGOS</h1>
    <form action="guardar_cargos.php">
        <label for="nom_cargo">Nombre del cargo</label>
        <input type="text" id="nom_cargo" name="nom_cargo">
        <button type="submit">Guardar Cargo</button>
        <p><a href="consultar_cargos.php">Consultar cargos</a></p>

    </form>
    
</body>
</html>