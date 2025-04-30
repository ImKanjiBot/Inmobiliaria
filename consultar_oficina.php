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
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Lista de Oficinas</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Dirección</th>
            <th>Telefono</th>
            <th>Email</th>
            <th>Ubicación</th>
            <th>Foto</th>
            <th>Acciones</th>
        </tr>
    <?php
    $sql = "SELECT * FROM oficinas";
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) { 
        echo "<tr>";
        echo "<td>" . $row["cod_ofi"] . "</td>";
        echo "<td>" . $row["nom_ofi"] . "</td>";
        echo "<td>" . $row["dir_ofi"] . "</td>";
        echo "<td>" . $row["tel_ofi"] . "</td>";
        echo "<td>" . $row["email_ofi"] . "</td>";

        // Celda de acciones (Maps, Foto, Editar, Eliminar)
        echo "<td>";
        
        // Ver en Maps
        echo "<a href='https://www.google.com/maps/search/?api=1&query=" . $row["latitud"] . "," . $row["longitud"] . "' target='_blank'>Ver en Maps</a><br>";

        
        echo "</td>";

        echo "<td>";
        // Mostrar la foto justo después de Ver en Maps
        if (!empty($row['foto_ofi'])) {
            echo "<img src='" . $row['foto_ofi'] . "' alt='Foto de la Oficina' width='100' height='100' /><br>";
        } else {
            echo "Sin foto<br>";
        }
        
        echo "</td>";

        
        echo "<td>";

        // Editar
        echo "<a href='editar_oficina.php?id=" . $row["cod_ofi"] . "'>Editar</a> ";

        // Eliminar
        echo "<form action='eliminar_oficina.php' method='post' onsubmit='return confirm(\"¿Estas seguro de eliminar esta oficina?\");'>";
        echo "<input type='hidden' name='cod_ofi' value='" . $row["cod_ofi"] . "'>";
        echo "<button type='submit'>Eliminar</button>";
        echo "</form>";
        
        echo "</td>";
        echo "</tr>";
    }
    ?>
    </table>
    
    <a href="oficina_crud.php">Volver al Inicio</a>
</body>
</html>

<?php $conn->close(); ?>