<?php
session_start();
if (!isset($_SESSION['rol_usuario']) || $_SESSION['rol_usuario'] !== 'admin') {
    header("Location: login.php"); // Redirigir si no es administrador
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Menú de Administrador</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Menú de Administrador</h2>
        <p>Bienvenido, <?php echo $_SESSION['usuario']; ?> (Administrador)</p>
        <ul>
            <li><a href="consultar_propietario.php">Propietarios</a></li>
            <li><a href="consultar_clientes.php">Clientes</a></li>
            <li><a href="consultar_inspeccion.php">Inspección</a></li>
            <li><a href="contratos_crud.php">Contratos</a></li>
            <li><a href="inmuebles\consultar_inmueble.php">Inmuebles</a></li>
            <li><a href="consultar_oficina.php">Oficinas</a></li>
            <li><a href="visitas_crud.php">Visitas</a></li>
        </ul>
        <p><a href="logout.php">Cerrar Sesión</a></p>
    </div>
</body>
</html>