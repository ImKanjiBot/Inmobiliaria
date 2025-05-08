consultar empleados

<?php
include("conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Empleados</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .tabla-empleados {
            width: 100%;
            overflow-x: auto;
        }

        .tabla-empleados table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        .tabla-empleados th,
        .tabla-empleados td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .tabla-empleados th {
            background-color: #4caf50;
            color: white;
            font-weight: bold;
        }

        .tabla-empleados tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .tabla-empleados tbody tr:hover {
            background-color: #f0f0f0;
        }

        .tabla-empleados td a {
            text-decoration: none;
            margin-right: 8px;
            color: #388e3c;
        }

        .tabla-empleados td button {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9em;
        }

        .tabla-empleados td button:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Lista de empleados</h2>
        <hr>
        <div class="tabla-empleados">
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Tipo Doc</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Dirección</th>
                        <th>Horas Extra</th>
                        <th>F. Nacimiento</th>
                        <th>Código Cargo</th>
                        <th>Salario</th>
                        <th>Gastos</th>
                        <th>Comisión</th>
                        <th>F. Ingreso</th>
                        <th>F. Retiro</th>
                        <th>Contacto</th>
                        <th>Dir. Contacto</th>
                        <th>Tel. Contacto</th>
                        <th>Email Contacto</th>
                        <th>Relación</th>
                        <th>Código Oficina</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sql = "SELECT * FROM empleados";
                        $result = $conn->query($sql);

                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                                echo "<td>" . $row["tipo_doc"] . "</td>";
                                echo "<td>" . $row["ced_emp"] . "</td>";
                                echo "<td>" . $row["nom_emp"] . "</td>";
                                echo "<td>" . $row["dir_emp"] . "</td>";
                                echo "<td>" . $row["tel_emp"] . "</td>";
                                echo "<td>" . $row["email_emp"] . "</td>";
                                echo "<td>" . $row["rh_emp"] . "</td>";
                                echo "<td>" . $row["fecha_nac"] . "</td>";
                                echo "<td>" . $row["cod_cargo"] . "</td>";
                                echo "<td>" . $row["salario"] . "</td>";
                                echo "<td>" . $row["gastos"] . "</td>";
                                echo "<td>" . $row["comision"] . "</td>";
                                echo "<td>" . $row["fecha_ing"] . "</td>";
                                echo "<td>" . $row["fecha_ret"] . "</td>";
                                echo "<td>" . $row["nom_contacto"] . "</td>";
                                echo "<td>" . $row["dir_contacto"] . "</td>";
                                echo "<td>" . $row["tel_contacto"] . "</td>";
                                echo "<td>" . $row["email_contacto"] . "</td>";
                                echo "<td>" . $row["relacion_contacto"] . "</td>";
                                echo "<td>" . $row["cod_ofi"] . "</td>";

                                echo "<td>";
                                    echo "<a href='editar_empleado.php?id=" . $row["cod_emp"] . "'>Editar</a>";
                                    echo "<form action='eliminar_empleado.php' method='post' onsubmit='return confirm(\"¿Eliminar a " . $row["nom_emp"] . "?\");'>";
                                        echo "<input type='hidden' name='cod_emp' value='" . $row["cod_emp"] . "'>";
                                        echo "<button type='submit'>Eliminar</button>";
                                    echo "</form>";
                                echo "</td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
        <p><a href="crear_empleado.php">Crear Nuevo Empleado</a></p>
    </div>
</body>
</html>