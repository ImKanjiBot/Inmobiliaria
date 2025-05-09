<?php

include '../conexion.php';

//Conslta para obtener los almacenes
$sql = "SELECT  cod_inm, dir_inm, barrio_inm, ciudad_inm, departamento_inm,  latitud, longitud, foto, web_p1, web_p2, cod_tipoinm, num_hab, precio_alq, cod_propietario, caracteristica_inm, notas_inm, cod_emp, cod_ofi FROM inmuebles";
$result = $conn -> query($sql);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Inmuebles</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        h2 {
            text-align: center;
            color: #1e88e5;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        thead th {
            background-color: #f2f2f2;
            color: #333;
            font-weight: bold;
            padding: 10px;
            text-align: left;
            border-bottom: 2px solid #ddd;
        }

        tbody td {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tbody tr:hover {
            background-color: #e9e9e9;
        }

        img {
            max-width: 100px;
            height: auto;
            display: block;
            margin: 0 auto;
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        a {
            color: #007bff;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        a:hover {
            color: #0056b3;
        }

        button {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.9em;
            transition: background-color 0.3s ease;
            margin-left: 5px;
        }

        button:hover {
            background-color: #d32f2f;
        }

        .actions {
            white-space: nowrap;
        }

        .actions form {
            display: inline;
        }

        .actions a {
            display: inline-block;
            margin-right: 5px;
            background-color: #28a745;
            color: white;
            padding: 8px 12px;
            border-radius: 4px;
        }

        .actions a:hover {
            background-color: #218838;
        }

        .volver-inicio {
            display: block;
            margin-top: 20px;
            text-align: center;
            color: #007bff;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .volver-inicio:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Lista de Inmuebles</h2>
        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Dirección</th>
                    <th>Barrio</th>
                    <th>Ciudad</th>
                    <th>Departamento</th>
                    <th>Ubicación</th>
                    <th>Foto</th>
                    <th>Web 1</th>
                    <th>Web 2</th>
                    <th>Tipo Inm.</th>
                    <th>Habitaciones</th>
                    <th>Alquiler</th>
                    <th>Propietario</th>
                    <th>Características</th>
                    <th>Notas</th>
                    <th>Empleado</th>
                    <th>Oficina</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result -> num_rows > 0) {
                    while ($row = $result -> fetch_assoc()) {?>
                        <tr>
                            <td><?php echo $row['cod_inm']; ?></td>
                            <td><?php echo $row['dir_inm']; ?></td>
                            <td><?php echo $row['barrio_inm']; ?></td>
                            <td><?php echo $row['ciudad_inm']; ?></td>
                            <td><?php echo $row['departamento_inm']; ?></td>
                            <td>
                                <a href="https://www.google.com/maps/place/<?php echo $row['latitud']; ?>,<?php echo $row['longitud']; ?>" target="_blank">Ver en Maps</a>
                            </td>
                            <td>
                                <?php if ($row['foto']) { ?>
                                    <img src="<?php echo $row['foto']; ?>" alt="Foto del Inmueble">
                                <?php }  else { ?>
                                    Sin foto
                                <?php } ?>
                            </td>
                            <td><?php echo $row['web_p1']; ?></td>
                            <td><?php echo $row['web_p2']; ?></td>
                            <td><?php echo $row['cod_tipoinm']; ?></td>
                            <td><?php echo $row['num_hab']; ?></td>
                            <td><?php echo $row['precio_alq']; ?></td>
                            <td><?php echo $row['cod_propietario']; ?></td>
                            <td><?php echo $row['caracteristica_inm']; ?></td>
                            <td><?php echo $row['notas_inm']; ?></td>
                            <td><?php echo $row['cod_emp']; ?></td>
                            <td><?php echo $row['cod_ofi']; ?></td>
                            <td class="actions">
                                <a href="editar_inmueble.php?id=<?=$row['cod_inm']?>">Editar</a>
                                <form action="eliminar_inmueble.php" method="post" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este inmueble?');">
                                    <input type="hidden" name="cod_inm" value="<?= $row['cod_inm'] ?>">
                                    <button type="submit">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php }
                } else { ?>
                    <tr>
                        <td colspan="18">No hay inmuebles registrados</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <a href="inmueble_crud.php" class="volver-inicio">Volver a inicio</a>
    </div>
</body>
</html>

<?php $conn -> close(); ?>