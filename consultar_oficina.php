<?php

include 'conexion.php';

//Consulta para obtener los almacenes
$sql = "SELECT cod_ofi, nom_ofi, dir_ofi, tel_ofi, email_ofi, latitud, longitud, foto_ofi FROM oficinas";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Oficinas</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Estilos específicos para la tabla de oficinas */
        h2 {
            color: #1e88e5;
            text-align: center;
            margin-bottom: 20px;
        }

        .tabla-oficinas {
            width: 100%;
            overflow-x: auto; /* Para hacer la tabla horizontalmente scrollable en pantallas pequeñas */
        }

        .tabla-oficinas table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden; /* Para que el border-radius funcione correctamente con thead/tbody */
        }

        .tabla-oficinas th,
        .tabla-oficinas td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .tabla-oficinas th {
            background-color: #2196f3;
            color: white;
            font-weight: bold;
        }

        .tabla-oficinas tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .tabla-oficinas tbody tr:hover {
            background-color: #f0f0f0;
        }

        .tabla-oficinas td a {
            text-decoration: none;
            color: #1e88e5;
            transition: color 0.3s ease;
            margin-right: 5px;
        }

        .tabla-oficinas td a:hover {
            color: #1565c0;
        }

        .tabla-oficinas td img {
            max-width: 100px;
            height: auto;
            display: block;
            margin-top: 5px;
        }

        .tabla-oficinas td form {
            margin-bottom: 0; /* Reset para evitar márgenes en el formulario dentro de la celda */
            display: inline-block; /* Para alinear el botón con otros elementos */
        }

        .tabla-oficinas td button[type="submit"] {
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

        .tabla-oficinas td button[type="submit"]:hover {
            background-color: #d32f2f;
        }

        .volver-inicio {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #2196f3;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .volver-inicio:hover {
            color: #1976d2;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Lista de Oficinas</h2>
        <hr>
        <div class="tabla-oficinas">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Dirección</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Ubicación</th>
                        <th>Foto</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
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
                            echo "<a href='http://www.google.com/maps/place/" . $row["latitud"] . "," . $row["longitud"] . "' target='_blank'>Ver en Maps</a>";
                        echo "</td>";

                        echo "<td>";
                            // Mostrar la foto justo después de Ver en Maps
                            if (!empty($row['foto_ofi'])) {
                                echo "<img src='" . $row['foto_ofi'] . "' alt='Foto de la Oficina' width='100' height='auto' />";
                            } else {
                                echo "Sin foto";
                            }
                        echo "</td>";

                        echo "<td>";
                            // Editar
                            echo "<a href='editar_oficina.php?id=" . $row["cod_ofi"] . "'>Editar</a> ";
                            // Eliminar
                            echo "<form action='eliminar_oficina.php' method='post' onsubmit='return confirm(\"¿Estás seguro de eliminar esta oficina?\");'>";
                                echo "<input type='hidden' name='cod_ofi' value='" . $row["cod_ofi"] . "'>";
                                echo "<button type='submit'>Eliminar</button>";
                            echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <a class="volver-inicio" href="oficina_crud.php">Volver al Inicio</a>
    </div>
</body>
</html>

<?php $conn->close(); ?>