<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Clientes</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Estilos específicos para la tabla de clientes */
        .tabla-clientes {
            width: 100%;
            overflow-x: auto; /* Para hacer la tabla horizontalmente scrollable en pantallas pequeñas */
        }

        .tabla-clientes table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden; /* Para que el border-radius funcione correctamente con thead/tbody */
        }

        .tabla-clientes th,
        .tabla-clientes td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .tabla-clientes th {
            background-color: #2196f3;
            color: white;
            font-weight: bold;
        }

        .tabla-clientes tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .tabla-clientes tbody tr:hover {
            background-color: #f0f0f0;
        }

        .tabla-clientes td a {
            text-decoration: none;
            margin-right: 8px;
            color: #1e88e5;
            transition: color 0.3s ease;
        }

        .tabla-clientes td a:hover {
            color: #1565c0;
        }

        .mensaje {
            color: green;
            margin-bottom: 15px;
            padding: 10px;
            background-color: #e6ffe6;
            border: 1px solid #c3e6c3;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Consultar Clientes</h1>
        <hr>

        <?php if (isset($_GET['mensaje'])): ?>
            <p class="mensaje"><?php echo $_GET['mensaje']; ?></p>
        <?php endif; ?>

        <div class="tabla-clientes">
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Documento</th>
                        <th>Dirección</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Tipo de Inmueble</th>
                        <th>Valor Máximo</th>
                        <th>Empleado a Cargo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require_once 'conexion.php';

                    $sql = "SELECT
                                    c.nom_cli,
                                    c.doc_cli,
                                    c.tipo_doc_cli,
                                    c.dir_cli,
                                    c.tel_cli,
                                    c.email_cli,
                                    ti.nom_tipoinm AS tipo_inmueble,
                                    c.valor_maximo,
                                    e.nom_emp AS empleado_gestion,
                                    c.cod_cli
                                FROM clientes c
                                INNER JOIN tipo_inmueble ti ON c.cod_tipoinm = ti.cod_tipoinm
                                INNER JOIN empleados e ON c.cod_emp = e.cod_emp";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["nom_cli"] . "</td>";
                            echo "<td>" . $row["tipo_doc_cli"] . " " . $row["doc_cli"] . "</td>";
                            echo "<td>" . $row["dir_cli"] . "</td>";
                            echo "<td>" . $row["tel_cli"] . "</td>";
                            echo "<td>" . $row["email_cli"] . "</td>";
                            echo "<td>" . $row["tipo_inmueble"] . "</td>";
                            echo "<td>" . $row["valor_maximo"] . "</td>";
                            echo "<td>" . $row["empleado_gestion"] . "</td>";
                            echo "<td>";
                            echo "<a href='editar_cliente.php?id=" . $row["cod_cli"] . "'>Editar</a> | ";
                            echo "<a href='eliminar_cliente.php?id=" . $row["cod_cli"] . "' onclick=\"return confirm('¿Está seguro que desea eliminar a " . $row["nom_cli"] . "?')\">Eliminar</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9'>No se encontraron clientes.</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>

        <p><a href="cliente_crud.php">Crear Nuevo Cliente</a></p>
    </div>
</body>
</html>