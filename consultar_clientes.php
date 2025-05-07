<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Clientes</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            max-width: 1000px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
        }

        hr {
            margin: 15px 0;
        }

        .tabla-clientes table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .tabla-clientes th,
        .tabla-clientes td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .tabla-clientes th {
            background-color: #007bff;
            color: #fff;
            text-align: center;
        }

        .tabla-clientes tr:hover {
            background-color: #f1f1f1;
        }

        .tabla-clientes td a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
            transition: color 0.3s;
        }

        .tabla-clientes td a:hover {
            color: #0056b3;
        }

        .tabla-clientes td:last-child {
            text-align: center;
        }

        .tabla-clientes tr:last-child td {
            border-bottom: none;
        }

        p a {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 20px;
            background-color: #28a745;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        p a:hover {
            background-color: #218838;
        }

        /* Mensaje de éxito */
        p.mensaje {
            color: green;
            font-weight: bold;
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
                                c.notas_cliente,
                                e.nom_emp AS empleado_gestion,
                                c.fecha_creacion,
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
