<?php
include ('conexion.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cargo</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .form-container {
            max-width: 400px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: left; /* Alinear el texto del formulario a la izquierda */
        }

        .form-container h1 {
            color: #1e88e5;
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #333;
            font-weight: bold;
        }

        .form-group input[type="text"] {
            width: calc(100% - 12px);
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 1em;
        }

        .form-group input[type="text"]:focus {
            outline: none;
            border-color: #2196f3;
            box-shadow: 0 0 5px rgba(33, 150, 243, 0.5);
        }

        .form-container button[type="submit"] {
            background-color: #4caf50;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s ease;
            width: 100%; /* Hacer que el botón ocupe todo el ancho del contenedor del formulario */
            display: block; /* Para que el ancho funcione correctamente */
            margin-top: 20px;
        }

        .form-container button[type="submit"]:hover {
            background-color: #43a047;
        }

        .form-container p {
            margin-top: 20px;
            text-align: center;
        }

        .form-container p a {
            color: #007bff;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .form-container p a:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h1>Crear Cargo</h1>
            <hr>
            <form action="guardar_cargos.php" method="POST">
                <div class="form-group">
                    <label for="nom_cargo">Nombre del cargo:</label>
                    <input type="text" id="nom_cargo" name="nom_cargo" required>
                </div>
                <button type="submit">Guardar Cargo</button>
                <p><a href="consultar_cargos.php">Consultar cargos</a></p>
            </form>
        </div>
    </div>
</body>
</html>