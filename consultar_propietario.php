<?php
include("conexion.php");
session_start();
if (!isset($_SESSION['rol_usuario'])) {
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Propietarios</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Estilos específicos para la tabla de propietarios */
        .tabla-propietarios {
            width: 100%;
            overflow-x: auto; /* Para hacer la tabla horizontalmente scrollable en pantallas pequeñas */
        }

        .tabla-propietarios table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden; /* Para que el border-radius funcione correctamente con thead/tbody */
        }

        .tabla-propietarios th,
        .tabla-propietarios td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .tabla-propietarios th {
            background-color: #2196f3;
            color: white;
            font-weight: bold;
        }

        .tabla-propietarios tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .tabla-propietarios tbody tr:hover {
            background-color: #f0f0f0;
        }

        .tabla-propietarios td a {
            text-decoration: none;
            margin-right: 8px;
            color: #1e88e5;
            transition: color 0.3s ease;
        }

        .tabla-propietarios td a:hover {
            color: #1565c0;
        }

        .tabla-propietarios td form {
            display: inline;
            margin-left: 8px;
        }

        .tabla-propietarios td button {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9em;
            transition: background-color 0.3s ease;
        }

        .tabla-propietarios td button:hover {
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
        <h2>Lista de propietarios</h2>
        <hr>
        <div class="tabla-propietarios">
            <table>
                <thead>
                    <tr>
                        <th>Tipo de Empresa</th>
                        <th>Tipo documento</th>
                        <th>Número del Documento</th>
                        <th>Nombre del Propietario</th>
                        <th>Dirección Propietario</th>
                        <th>Teléfono Propietario</th>
                        <th>Email Propietario</th>
                        <th>Contacto Propietario</th>
                        <th>Teléfono Contacto</th>
                        <th>Email Contacto</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                        $sql = "SELECT * FROM propietarios";
                        $result = $conn->query($sql);

                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                                echo "<td>" . $row["tipo_empresa"] . "</td>";
                                echo "<td>" . $row["tipo_doc"] . "</td>";
                                echo "<td>" . $row["num_doc"] . "</td>";
                                echo "<td>" . $row["nombre_propietario"] . "</td>";
                                echo "<td>" . $row["dir_propietario"] . "</td>";
                                echo "<td>" . $row["tel_propietario"] . "</td>";
                                echo "<td>" . $row["email_propietario"] . "</td>";
                                echo "<td>" . $row["contacto_prop"] . "</td>";
                                echo "<td>" . $row["tel_contacto_prop"] . "</td>";
                                echo "<td>" . $row["email_contacto_prop"] . "</td>";

                                echo "<td>";
                                    echo "<a href='editar_propietario.php?id=" . $row["cod_propietario"] . "'>Editar</a>";

                                    echo "<form action='eliminar_propietario.php' method='post' style='display:inline; margin-left: 8px;'
                                          onsubmit='return confirm(\"¿Estás seguro de eliminar a " . $row["nombre_propietario"] . "?\");'>";
                                        echo "<input type='hidden' name='cod_propietario' value='" . $row["cod_propietario"] . "'>";
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
        <p><a href="propietarios.php" class="volver-inicio">Crear Nuevo Propietario</a></p>
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