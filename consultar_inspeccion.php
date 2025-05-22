<?php

include 'conexion.php';
session_start();
if (!isset($_SESSION['rol_usuario'])) {
    header("Location: ../login.php");
    exit();
}

//Consulta para obtener las inspecciones
$sql = "SELECT * FROM inspeccion";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de inspecciones</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Estilos específicos para la tabla de inspecciones */
        h2 {
            color: #1e88e5;
            text-align: center;
            margin-bottom: 20px;
        }

        .tabla-inspecciones {
            width: 100%;
            overflow-x: auto; /* Para hacer la tabla horizontalmente scrollable en pantallas pequeñas */
        }

        .tabla-inspecciones table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden; /* Para que el border-radius funcione correctamente con thead/tbody */
        }

        .tabla-inspecciones th,
        .tabla-inspecciones td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .tabla-inspecciones th {
            background-color: #2196f3;
            color: white;
            font-weight: bold;
        }

        .tabla-inspecciones tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .tabla-inspecciones tbody tr:hover {
            background-color: #f0f0f0;
        }

        .tabla-inspecciones td form {
            margin-bottom: 0; /* Reset para evitar márgenes en el formulario dentro de la celda */
        }

        .tabla-inspecciones td button[type="submit"] {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.9em;
            transition: background-color 0.3s ease;
        }

        .tabla-inspecciones td button[type="submit"]:hover {
            background-color: #d32f2f;
        }

        .volver-inicio,
        .menu-btn {
            display: block;
            margin: 20px auto 0 auto;
            text-align: center;
            color: white;
            background-color: #6c757d;
            padding: 10px 20px;
            border-radius: 4px;
            text-decoration: none;
            width: fit-content;
            transition: background-color 0.3s ease;
        }

        .volver-inicio:hover,
        .menu-btn:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Lista de inspecciones</h2>
        <hr>
        <div class="tabla-inspecciones">
            <table>
                <thead>
                    <tr>
                        <th>Código Inspección</th>
                        <th>Fecha de Inspección</th>
                        <th>Código Inmueble</th>
                        <th>Código Empleado</th>
                        <th>Comentario</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                            echo "<td>" . $row["cod_ins"] . "</td>";
                            echo "<td>" . $row["fecha_ins"] . "</td>";
                            echo "<td>" . $row["cod_inm"] . "</td>";
                            echo "<td>" . $row["cod_emp"] . "</td>";
                            echo "<td>" . $row["comentario"] . "</td>";
                            echo "<td>";
                                echo "<a href='editar_inspeccion.php?id=" . $row["cod_ins"] . "'>Editar</a>";
                                
                                echo "<form action='eliminar_inspeccion.php' method='post' onsubmit='return confirm(\"¿Estás seguro de eliminar esta inspección?\");'>";
                                    echo "<input type='hidden' name='cod_ins' value='" . $row["cod_ins"] . "'>";
                                    echo "<button type='submit'>Eliminar</button>";
                                echo "</form>";
                            echo "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div>
            <a class="volver-inicio" href="inspeccion_crud.php">Volver al Inicio</a>
        </div>
        <div>
        <?php
        if (isset($_SESSION['rol_usuario'])) {
            $rolUsuario = $_SESSION['rol_usuario'];
            $urlRedireccion = '';

            switch ($rolUsuario) {
                case 'admin':
                    $urlRedireccion = 'menu_admin.php';
                    break;
                case 'empleado':
                    $urlRedireccion = 'menu_empleado.php';
                    break;
                case 'cliente':
                    $urlRedireccion = 'menu_cliente.php';
                    break;
                default:
                    $urlRedireccion = 'login.php';
                    break;
            }
            echo '<a class="menu-btn" href="' . $urlRedireccion . '">Ir al Menú</a>';
        } else {
            echo '<a class="menu-btn" href="login.php">Ir al Menú</a>';
        }
        ?>   
        </div>
    </div>
</body>
</html>

<?php $conn->close(); ?>