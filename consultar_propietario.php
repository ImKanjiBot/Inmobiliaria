<?php
include("conexion.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>consultar</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
       <h2>Lista de propietarios</h2>
        <table>
            <tr>
            <th>Tipo de Empresa</th>
            <th>Tipo documento</th>
            <th>numero del documento</th>
            <th>nombre del propietario</th>
            <th>Direccion Propietario</th>
            <th>telefono propietario</th>
            <th>email propietario</th>
            <th>contacto propietario</th>
            <th>telefono contacto propietario</th>
            <th>email contacto propietario</th>
            <th>Acciones</th>
            </tr>
            <?php
              
                $sql = "SELECT * FROM propietarios";
                $result = $conn->query($sql);

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                        echo "<td>" . $row["tipo_empresa"] . "</td>";
                        echo "<td>" . $row["tipo_doc"] .  "</td>";
                        echo "<td>" . $row["num_doc"] . "</td>";
                        echo "<td>" . $row["nombre_propietario"] . "</td>";
                        echo "<td>" . $row["dir_propietario"] . "</td>";
                        echo "<td>" . $row["tel_propietario"] . "</td>";
                        echo "<td>" . $row["email_propietario"] . "</td>";
                        echo "<td>" . $row["contacto_prop"] . "</td>";
                        echo "<td>" . $row["tel_contacto_prop"] . "</td>";
                        echo "<td>" . $row["email_contacto_prop"] . "</td>";

                        echo "<td>
                                <a href='editar_propietario.php?id=" . $row["cod_propietario"] . "'>Editar</a>

                                <form action='eliminar_propietario.php' method='post' style='display:inline;'
                                onsubmit='return confirm(\"¿Estás seguro de eliminar este propietario?\");'>

                                    <input type='hidden' name='num_doc' value='" . $row["num_doc"] . "'>
                                    <button type='submit'>Eliminar</button>
                                </form>
                            </td>";
                    echo "</tr>";    
                }
            ?>

        </table>
</body>
</html>
