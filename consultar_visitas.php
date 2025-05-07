<?php

include 'conexion.php';

//Conslta para obtener los almacenes
$sql = "SELECT 	cod_vis, fecha_vis, cod_cli, cod_emp, cod_inm, comenta_vis FROM visitas";
$result = $conn -> query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Visitas</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Estilos específicos para la tabla de visitas */
        .tabla-visitas {
            width: 100%;
            overflow-x: auto; /* Para hacer la tabla horizontalmente scrollable en pantallas pequeñas */
        }

        .tabla-visitas table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden; /* Para que el border-radius funcione correctamente con thead/tbody */
        }

        .tabla-visitas th,
        .tabla-visitas td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .tabla-visitas th {
            background-color: #2196f3;
            color: white;
            font-weight: bold;
        }

        .tabla-visitas tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .tabla-visitas tbody tr:hover {
            background-color: #f0f0f0;
        }

        .tabla-visitas td a {
            text-decoration: none;
            margin-right: 8px;
            color: #1e88e5;
            transition: color 0.3s ease;
        }

        .tabla-visitas td a:hover {
            color: #1565c0;
        }

        .tabla-visitas td form {
            display: inline;
            margin-left: 8px;
        }

        .tabla-visitas td button {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9em;
            transition: background-color 0.3s ease;
        }

        .tabla-visitas td button:hover {
            background-color: #d32f2f;
        }

        h2 {
            color: #1e88e5;
            text-align: center;
            margin-bottom: 20px;
        }

        .volver-inicio {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #1e88e5;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .volver-inicio:hover {
            color: #1565c0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Visitas</h2>
        <hr>
        <div class="tabla-visitas">
            <table>
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Empleado</th>
                        <th>Inmueble</th>
                        <th>Comentarios</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result -> num_rows > 0) {
                        while ($row = $result -> fetch_assoc()) {?>
                            <tr>
                                <td><?php echo $row['cod_vis']; ?></td>
                                <td><?php echo $row['fecha_vis']; ?></td>
                                <td><?php echo $row['cod_cli']; ?></td>
                                <td><?php echo $row['cod_emp']; ?></td>
                                <td><?php echo $row['cod_inm']; ?></td>
                                <td><?php echo $row['comenta_vis']; ?></td>
                                <td>
                                    <a href="editar_visita.php?id=<?=$row['cod_vis']?>">Editar</a>
                                    <form action="eliminar_visita.php" method="post" style="display:inline;" onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta visita?');">
                                        <input type="hidden" name="cod_vis" value="<?= $row['cod_vis'] ?>">
                                        <button type="submit">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php }
                    } else { ?>
                        <tr>
                            <td colspan="7">No hay visitas registradas </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <a href="visitas_crud.php" class="volver-inicio">Volver a inicio</a>
    </div>
</body>
</html>

<?php $conn -> close(); ?>