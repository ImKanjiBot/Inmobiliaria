<?php include('conexion.php'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Cargo</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Estilos específicos para el formulario de creación de cargos */
        h1 {
            text-align: center;
            color: #1e88e5;
            margin-bottom: 20px;
        }

        form {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: 20px auto;
            display: grid;
            gap: 15px;
        }

        form label {
            display: block;
            margin-bottom: 5px;
            color: #333;
            font-weight: bold;
            text-align: left;
        }

        form input[type="text"] {
            width: calc(100% - 12px);
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 1em;
        }

        form input[type="text"]:focus {
            outline: none;
            border-color: #2196f3;
            box-shadow: 0 0 5px rgba(33, 150, 243, 0.5);
        }

        form button[type="submit"],
        form p a {
            display: inline-block;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease, color 0.3s ease;
            margin-top: 10px;
            font-size: 1em;
            text-align: center;
        }

        form button[type="submit"] {
            background-color: #4caf50;
            color: white;
            border: none;
            cursor: pointer;
            width: 100%;
        }

        form button[type="submit"]:hover {
            background-color: #43a047;
        }

        form p a {
            background-color: #2196f3;
            color: white;
            width: 100%;
        }

        form p a:hover {
            background-color: #1976d2;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Crear Cargo</h1>
        <hr>
        <form action="guardar_cargos.php" method="POST">
            <div>
                <label for="nom_cargo">Nombre del cargo:</label>
                <input type="text" id="nom_cargo" name="nom_cargo" required>
            </div>
            <button type="submit">Guardar Cargo</button>
        </form>
        <p><a href="consultar_cargos.php">Consultar Cargos</a></p>
    </div>
</body>
</html>