<?php
session_start();
if (!isset($_SESSION['rol_usuario']) || $_SESSION['rol_usuario'] !== 'cliente') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Menú de Cliente</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Menú de Cliente</h2>
        <p>Bienvenido, <?php echo $_SESSION['usuario']; ?> (Cliente)</p>
        <ul>
            <li><a href="inmuebles\consultar_inmueble.php">Ver Inmuebles</a></li>
            <li><a href="consultar_visitas.php">Mis Visitas</a></li>
            <li><a href="consultar_contratos.php">Mis Contratos</a></li>
        </ul>
        <p><a href="logout.php">Cerrar Sesión</a></p>
    </div>
</body>
</html>