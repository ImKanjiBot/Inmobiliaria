<?php
include 'conexion.php';

session_start(); // Asegúrate de iniciar la sesión en cada página protegida

if (!isset($_SESSION['id_usuario'])) {
    // El usuario no ha iniciado sesión, redirigir a la página de inicio de sesión
    header("Location: login.php"); // Asumo que tu página de inicio de sesión es login.php
    exit();
}

// Si la variable de sesión 'id_usuario' existe, el usuario ha iniciado sesión
// y puedes continuar mostrando el contenido de la página protegida.

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Visitas</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Estilos específicos para el formulario de registro de visitas */
        h2 {
            color: #1e88e5;
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            display: grid;
            grid-template-columns: auto;
            gap: 15px;
        }

        form label {
            display: block;
            margin-bottom: 5px;
            color: #333;
            font-weight: bold;
        }

        form input[type="date"],
        form select,
        form textarea {
            width: calc(100% - 12px);
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 1em;
        }

        form select {
            appearance: none;
            background-image: url('data:image/svg+xml;charset=UTF-8,<svg fill="%23333" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg>');
            background-repeat: no-repeat;
            background-position: right 8px center;
            background-size: 16px;
            padding-right: 30px;
        }

        form input[type="date"]:focus,
        form select:focus,
        form textarea:focus {
            outline: none;
            border-color: #2196f3;
            box-shadow: 0 0 5px rgba(33, 150, 243, 0.5);
        }

        .buttons-container {
            display: flex;
            justify-content: center; /* Centra los elementos horizontalmente */
            gap: 10px; /* Espacio entre los botones */
            margin-top: 20px;
        }

        .buttons-container button {
            background-color: #4caf50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s ease;
            text-decoration: none;
        }

        .buttons-container button:hover {
            background-color: #43a047;
        }

        .buttons-container a {
            background-color: #2196f3;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s ease;
            text-decoration: none;
        }

        .buttons-container a:hover {
            background-color: #1976d2;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Registro de Visitas</h2>
        <hr>
        <form action="guardar_visitas.php" method="POST">

            <div>
                <label for="fecha_vis">Fecha de la visita:</label>
                <input type="date" id="fecha_vis" name="fecha_vis" required>
            </div>

            <div>
                <label>Código del Cliente:</label>
                <select name="cod_cli" required>
                    <option value="">Seleccione el código del cliente</option>
                    <?php
                    //Obtener codigo del cliente
                    $sqlCat = "SELECT * FROM clientes";
                    $resultCat = $conn->query($sqlCat);
                    while ($rowCat = $resultCat->fetch_assoc()){
                        echo "<option value='".$rowCat['cod_cli']."'>".$rowCat['nom_cli']."</option>";
                    }
                    ?>
                </select>
            </div>

            <div>
                <label>Nombre del empleado:</label>
                <select name="cod_emp" required>
                    <option value="">Seleccione el nombre del empleado</option>
                    <?php
                    //Obtener codigo del empleado
                    $sqlCat = "SELECT * FROM empleados";
                    $resultCat = $conn->query($sqlCat);
                    while ($rowCat = $resultCat->fetch_assoc()){
                        echo "<option value='".$rowCat['cod_emp']."'>".$rowCat['nom_emp']."</option>";
                    }
                    ?>
                </select>
            </div>

            <div>
                <label>Dirección del inmueble:</label>
                <select name="cod_inm" required>
                    <option value="">Seleccione la dirección del inmueble</option>
                    <?php
                    //Obtener codigo del inmueble
                    $sqlCat = "SELECT * FROM inmuebles";
                    $resultCat = $conn->query($sqlCat);
                    while ($rowCat = $resultCat->fetch_assoc()){
                        echo "<option value='".$rowCat['cod_inm']."'>".$rowCat['dir_inm']."</option>";
                    }
                    ?>
                </select>
            </div>

            <div>
                <label>Comentarios de la visita:</label>
                <textarea id="comenta_vis" name="comenta_vis"></textarea>
            </div>

            <div class="buttons-container">
                <button type="submit">Guardar Visita</button>
                <a href="consultar_visitas.php">Consultar Visitas</a>
            </div>
        </form>


        <?php

        // Verificar si la variable de sesión 'rol_usuario' existe
        if (isset($_SESSION['rol_usuario'])) {
            $rolUsuario = $_SESSION['rol_usuario'];
            $urlRedireccion = '';

            // Determinar la URL de redirección según el rol
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
                    // Si el rol no coincide con ninguno conocido, podrías redirigir a una página por defecto o mostrar un mensaje de error.
                    $urlRedireccion = 'login.php'; // Ejemplo de página por defecto
                    break;
            }

            // Generar el enlace "Volver" dinámicamente
            echo '<a href="' . $urlRedireccion . '">Volver</a>';

        } else {
            // Si la variable de sesión 'rol_usuario' no está definida (por alguna razón),
            // podrías redirigir a una página de inicio de sesión o a una página por defecto.
            echo '<p><a href="login.php">Volver</a></p>'; // Ejemplo: Volver a la página de inicio de sesión
        }
        ?>
    </div>
</body>
</html>