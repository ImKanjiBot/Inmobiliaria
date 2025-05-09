<?php
include('conexion.php');

session_start();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consultar Cargos</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        h1 {
            text-align: center;
            color: #1e88e5;
            margin-bottom: 20px;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.05);
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

        a {
            color: #007bff;
            text-decoration: none;
            transition: color 0.3s ease;
            margin-right: 10px;
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
        }

        button:hover {
            background-color: #d32f2f;
        }

        p a {
            display: block;
            margin-top: 20px;
            text-align: center;
            color: #28a745;
            text-decoration: none;
            transition: color 0.3s ease;
            background-color: #e9ecef;
            padding: 10px;
            border-radius: 5px;
        }

        p a:hover {
            color: #1e7e34;
            background-color: #d1e7dd;
        }

        .actions {
            white-space: nowrap;
        }

        .actions form {
            display: inline;
            margin-left: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Consultar Cargos</h1>
        <hr>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Cargo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM cargos";
                    $result = $conn->query($sql);

                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                            echo "<td>" . $row["nom_cargo"] . "</td>";
                            echo "<td class='actions'>";
                                echo "<a href='editar_cargos.php?id=" . $row["cod_cargo"] . "'>Editar</a>";
                                echo "<form action='eliminar_cargos.php' method='post' onsubmit='return confirm(\"¿Eliminar a " . $row["nom_cargo"] . "?\");'>";
                                    echo "<input type='hidden' name='cod_cargo' value='" . $row["cod_cargo"] . "'>";
                                    echo "<button type='submit'>Eliminar</button>";
                                echo "</form>";
                            echo "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <p><a href="cargos_crud.php">Crear Nuevo Cargo</a></p>
    </div>
</body>
</html>