<?php

include 'conexion.php';

//Consulta para obtener los almacenes
$sql = "SELECT cod_ofi, nom_ofi, dir_ofi, tel_ofi, email_ofi, latitud, longitud, foto_ofi FROM oficinas";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Oficinas</title>
</head>
<body>
    <h2>Lista de Oficinas</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Dirección</th>
                <th>Telefono</th>
                <th>Email</th>
                <th>Ubicación</th>
                <th>Foto</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['cod_ofi']; ?></td>
                        <td><?php echo $row['nom_ofi']; ?></td>
                        <td><?php echo $row['dir_ofi']; ?></td>
                        <td><?php echo $row['tel_ofi']; ?></td>
                        <td><?php echo $row['email_ofi']; ?></td>
                        <td>
                            <a href="https://www.google.com/maps/search/?api=1&query=<?php echo $row['latitud']; ?>,<?php echo $row['longitud']; ?>" target="_blank">Ver en Maps</a>
                        </td>
                        <td>
                            <?php if ($row['foto_ofi']) { ?>
                                <img src="<?php echo $row['foto_ofi']; ?>" alt="Foto de la Oficina" width="100" height="100" />
                            <?php } else { ?>
                                Sin foto
                            <?php } ?>
                        </td>
                    </tr>
                <?php }
            } else { ?>
                <tr>
                    <td colspan="5">No hay oficinas registradas.</td>
                </tr>    
            <?php } ?>
        </tbody>
    </table>
    
    <a href="oficina_crud.php">Volver al Inicio</a>
</body>
</html>

<?php $conn->close(); ?>