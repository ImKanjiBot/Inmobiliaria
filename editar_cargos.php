<?php

include('conexion.php');

$row = null;

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $cod_cargo = intval($_GET['id']);
    $sql = "SELECT * FROM cargos WHERE cod_cargo = $cod_cargo";
    $result = $conn->query($sql);

    if ($result && $result->num_rows === 1) {
        $row = $result->fetch_assoc();
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Cargo</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Estilos específicos para el formulario de edición de cargos */
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

        form button[type="submit"] {
            background-color: #4caf50;
            color: white;
            border: none;
            cursor: pointer;
            padding: 10px 15px;
            border-radius: 5px;
            font-size: 1em;
            transition: background-color 0.3s ease;
        }

        form button[type="submit"]:hover {
            background-color: #43a047;
        }

        form a {
            display: inline-block;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease, color 0.3s ease;
            margin-top: 10px;
        }

        form a {
            background-color: #f44336;
            color: white;
        }

        form a:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Editar Cargo</h1>
        <hr>
        <?php if ($row): ?>
    <form action="actualizar_cargos.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="cod_cargo" value="<?php echo $row['cod_cargo']; ?>">
        <label for="nom_cargo">Nombre del Cargo:</label>
        <input type="text" name="nom_cargo" id="nom_cargo" value="<?php echo $row['nom_cargo']; ?>" required>
        <div>
            <button type="submit">Actualizar</button>
            <a href="consultar_cargos.php">Cancelar</a>
        </div>
    </form>
        <?php else: ?>
    <p style="color:red; text-align:center;">Cargo no encontrado.</p>
        <?php endif; ?>
    </div>
</body>
</html>
