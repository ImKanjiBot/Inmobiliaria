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
    <style>
        .container p a {
            color: #ffff;
            display: inline-block;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease, color 0.3s ease;
            margin-top: 10px;
        }

        .container p a {
            background-color: #4caf50;
        }

        .container p a:hover {
            background-color: #43a047;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Menú de Administrador</h2>
        <p>Bienvenido, <?php echo $_SESSION['usuario']; ?> (Administrador)</p>
        <ul>
            <li><a href="propietarios.php">Propietarios</a></li>
            <li><a href="cliente_crud.php">Clientes</a></li>
            <li><a href="inspeccion_crud.php">Inspección</a></li>
            <li><a href="contratos_crud.php">Contratos</a></li>
            <li><a href="inmuebles\inmueble_crud.php">Inmuebles</a></li>
            <li><a href="oficina_crud.php">Oficinas</a></li>
            <li><a href="visitas_crud.php">Visitas</a></li>
            <li><a href="cargos_crud.php">Cargos</a></li>
            <li><a href="empleados_crud.php">Empleados</a></li>
        </ul>
        <p><a href="logout.php">Cerrar Sesión</a></p>
    </div>
</body>
</html>