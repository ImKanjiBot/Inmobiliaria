<?php

include 'conexion.php';

//Consulta para obtener las inspecciones
$sql = "SELECT * FROM inspeccion";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de inspecciones</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Lista de inspecciones</h2>
    <table>
        <tr>
            <th>codigo inspeccion</th>
            <th>fecha de inspeccion</th>
            <th>codigo inmueble</th>
            <th>codigo empleado</th>
            <th>comentario</th>
            <th>Acción</th>
        </tr>
    <?php
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
            echo "<td>" . $row["cod_ins"] . "</td>";
            echo "<td>" . $row["fecha_ins"] . "</td>";
            echo "<td>" . $row["cod_inm"] . "</td>";
            echo "<td>" . $row["cod_emp"] . "</td>";
            echo "<td>" . $row["comentario"] . "</td>";
            echo "<td>";
                echo "<form action='eliminar_inspeccion.php' method='post' onsubmit='return confirm(\"¿Estas seguro de eliminar esta inspeccion?\");'>";
                echo "<input type='hidden' name='cod_ins' value='" . $row["cod_ins"] . "'>";
                echo "<button type='submit'>Eliminar</button>";
                echo "</form>";
            echo "</td>";
        echo "</tr>";
    }
    ?>
    </table>
    
    <a href="inspeccion_crud.php">Volver al Inicio</a>
</body>
</html>

<?php $conn->close(); ?>
