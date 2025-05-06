<?php
session_start();
if (!isset($_SESSION['rol_usuario']) || $_SESSION['rol_usuario'] !== 'empleado') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Menú de Empleado</title>
</head>
<body>
    <h2>Menú de Empleado</h2>
    <p>Bienvenido, <?php echo $_SESSION['usuario']; ?> (Empleado)</p>
    <ul>
        <li><a href="consultar_clientes.php">Clientes</a></li>
        <li><a href="inmuebles\consultar_inmueble.php">Inmuebles</a></li>
        <li><a href="consultar_visitas.php">Visitas</a></li>
        <li><a href="consultar_oficina.php">Oficinas</a></li>
        <li><a href="consultar_inspeccion.php">Inspección</a></li>
    </ul>
    <p><a href="logout.php">Cerrar Sesión</a></p>
</body>
</html>