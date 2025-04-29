<?php
session_start();
include("conexion.php");

if (isset($_SESSION['usuario'])) {
    header("Location: menu.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesion</title>
    <link rel="stylesheet" href="">
</head>
<body>
    <div class="container">
        <h2>Iniciar Sesion</h2>
        <form action="procesar_login.php" method="POST">
            <label>Usuario</label>
            <input type="text" name="usuario" required><br><br>

            <label>Contraseña</label>
            <input type="password" name="contraseña" required><br>

            <button type="submit">Ingresar</button>
        </form>
    </div>
    
</body>
</html>
?>