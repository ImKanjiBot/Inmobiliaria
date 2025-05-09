<?php
// Incluir el archivo de conexión a la base de datos
require_once 'conexion.php';

// Iniciar la sesión para los mensajes
session_start();

// Consultar todos los contratos, uniendo con la tabla de clientes
$sql = "SELECT
    c.cod_con,
    cli.nom_cli AS nombre_cliente,
    c.fecha_con,
    c.fecha_ini,
    c.fecha_fin,
    c.meses,
    c.valor_con,
    c.deposito_con,
    c.metodo_pago_con,
    c.dato_pago,
    c.archivo_con
FROM contratos c
JOIN clientes cli ON c.cod_cli = cli.cod_cli";

$resultado = $conn->query($sql);
$contratos = [];
if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $contratos[] = $fila;
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Contratos</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Estilos específicos para la tabla de contratos */
        .tabla-contratos {
            width: 100%;
            overflow-x: auto; /* Para hacer la tabla horizontalmente scrollable en pantallas pequeñas */
        }

        .tabla-contratos table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden; /* Para que el border-radius funcione correctamente con thead/tbody */
        }

        .tabla-contratos th,
        .tabla-contratos td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .tabla-contratos th {
            background-color: #2196f3;
            color: white;
            font-weight: bold;
        }

        .tabla-contratos tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .tabla-contratos tbody tr:hover {
            background-color: #f0f0f0;
        }

        .tabla-contratos td a {
            text-decoration: none;
            margin-right: 8px;
            color: #1e88e5;
            transition: color 0.3s ease;
        }

        .tabla-contratos td a:hover {
            color: #1565c0;
        }

        .mensaje {
            background-color: #e6ffe6;
            color: green;
            border: 1px solid green;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            text-align: center;
        }

        h1 {
            color: #1e88e5;
            text-align: center;
            margin-bottom: 20px;
        }

        .registrar-nuevo {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #4caf50;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .registrar-nuevo:hover {
            color: #43a047;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Lista de Contratos</h1>
        <hr>

        <?php if (isset($_SESSION['mensaje'])): ?>
            <div class="mensaje">
                <?php echo $_SESSION['mensaje']; ?>
                <?php unset($_SESSION['mensaje']); ?>
            </div>
        <?php endif; ?>

        <div class="tabla-contratos">
            <table>
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Cliente</th>
                        <th>Fecha Contrato</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Fin</th>
                        <th>Meses</th>
                        <th>Valor</th>
                        <th>Depósito</th>
                        <th>Método Pago</th>
                        <th>Dato Pago</th>
                        <th>Archivo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($contratos)): ?>
                        <tr><td colspan="12">No hay contratos registrados.</td></tr>
                    <?php else: ?>
                        <?php foreach ($contratos as $contrato): ?>
                            <tr>
                                <td><?php echo $contrato['cod_con']; ?></td>
                                <td><?php echo $contrato['nombre_cliente']; ?></td>
                                <td><?php echo $contrato['fecha_con']; ?></td>
                                <td><?php echo $contrato['fecha_ini']; ?></td>
                                <td><?php echo $contrato['fecha_fin']; ?></td>
                                <td><?php echo $contrato['meses']; ?></td>
                                <td><?php echo number_format($contrato['valor_con']); ?></td>
                                <td><?php echo number_format($contrato['deposito_con']); ?></td>
                                <td><?php echo $contrato['metodo_pago_con']; ?></td>
                                <td><?php echo $contrato['dato_pago']; ?></td>
                                <td><?php echo $contrato['archivo_con']; ?></td>
                                <td>
                                    <a href="editar_contrato.php?id=<?php echo $contrato['cod_con']; ?>">Editar</a>
                                    <a href="eliminar_contrato.php?id=<?php echo $contrato['cod_con']; ?>" onclick="return confirm('¿Desea eliminar este contrato?')">Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <p class="registrar-nuevo"><a href="contratos_crud.php">Registrar Nuevo Contrato</a></p>
    </div>
</body>
</html>