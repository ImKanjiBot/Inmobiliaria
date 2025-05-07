<?php

include 'conexion.php';

//Conslta para obtener los almacenes
$sql = "SELECT  cod_vis, fecha_vis, cod_cli, cod_emp, cod_inm, comenta_vis FROM visitas";
$result = $conn -> query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de visitas</title>
</head>
<body>
    <h2>Visitas</h2>
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
                    <td colspan="5">No hay visitas registradas </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <a href="visitas_crud.php">Volver a inicio</a>
</body>
</html>

<?php $conn -> close(); ?>