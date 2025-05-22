<?php
include("conexion.php");
session_start();
if (!isset($_SESSION['rol_usuario'])) {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM propietarios WHERE cod_propietario = '$id'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
    } else {
        echo "<div class='container'>Propietario no encontrado. <a href='consultar_propietario.php'>Volver</a></div>";
        exit;
    }
} else {
    echo "<div class='container'>ID no proporcionado. <a href='consultar_propietario.php'>Volver</a></div>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Propietario</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Estilos específicos para el formulario de edición de propietario */
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
            margin-bottom: 20px;
            display: grid;
            grid-template-columns: auto; /* Una columna para etiquetas y otra para inputs */
            gap: 15px;
        }

        form label {
            display: block;
            margin-bottom: 5px;
            color: #333;
            font-weight: bold;
        }

        form input[type="text"],
        form input[type="email"],
        form select {
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

        form input[type="text"]:focus,
        form input[type="email"]:focus,
        form select:focus {
            outline: none;
            border-color: #2196f3;
            box-shadow: 0 0 5px rgba(33, 150, 243, 0.5);
        }

        form input[type="submit"] {
            background-color: #2196f3;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s ease;
            grid-column: 1 / -1; /* Hacer que el botón ocupe toda la fila */
            margin-top: 15px;
        }

        form input[type="submit"]:hover {
            background-color: #1976d2;
        }

        p a {
            display: inline-block;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
            margin-top: 5px;
        }

        p a {
            background-color: #f44336;
            color: white;
        }

        p a:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Editar Propietario</h1>
        <hr>
        <form action="actualizar_propietario.php" method="POST">
            <input type="hidden" name="cod_propietario" value="<?php echo $row['cod_propietario']; ?>">

            <div>
                <label for="tipo_empresa">Tipo de empresa:</label>
                <select name="tipo_empresa" id="tipo_empresa">
                    <option value="Persona Natural" <?php if($row['tipo_empresa'] == 'Persona Natural') echo 'selected'; ?>>Persona Natural</option>
                    <option value="Empresa" <?php if($row['tipo_empresa'] == 'Empresa') echo 'selected'; ?>>Empresa</option>
                </select>
            </div>

            <div>
                <label for="tipo_doc">Tipo de documento:</label>
                <select name="tipo_doc" id="tipo_doc">
                    <option value="CC" <?php if($row['tipo_doc'] == 'CC') echo 'selected'; ?>>Cédula de ciudadanía (CC)</option>
                    <option value="NIT" <?php if($row['tipo_doc'] == 'NIT') echo 'selected'; ?>>NIT</option>
                    <option value="CE" <?php if($row['tipo_doc'] == 'CE') echo 'selected'; ?>>Cédula de extranjería (CE)</option>
                    <option value="TI" <?php if($row['tipo_doc'] == 'TI') echo 'selected'; ?>>Tarjeta de Identidad (TI)</option>
                </select>
            </div>

            <div>
                <label for="num_doc">Número de documento:</label>
                <input type="text" name="num_doc" id="num_doc" value="<?php echo $row['num_doc']; ?>">
            </div>

            <div>
                <label for="nombre_propietario">Nombre del propietario:</label>
                <input type="text" name="nombre_propietario" id="nombre_propietario" value="<?php echo $row['nombre_propietario']; ?>">
            </div>

            <div>
                <label for="dir_propietario">Dirección del propietario:</label>
                <input type="text" name="dir_propietario" id="dir_propietario" value="<?php echo $row['dir_propietario']; ?>">
            </div>

            <div>
                <label for="tel_propietario">Teléfono del propietario:</label>
                <input type="text" name="tel_propietario" id="tel_propietario" value="<?php echo $row['tel_propietario']; ?>">
            </div>

            <div>
                <label for="email_propietario">Email del propietario:</label>
                <input type="email" name="email_propietario" id="email_propietario" value="<?php echo $row['email_propietario']; ?>">
            </div>

            <div>
                <label for="contacto_prop">Nombre de contacto:</label>
                <input type="text" name="contacto_prop" id="contacto_prop" value="<?php echo $row['contacto_prop']; ?>">
            </div>

            <div>
                <label for="tel_contacto_prop">Teléfono del contacto:</label>
                <input type="text" name="tel_contacto_prop" id="tel_contacto_prop" value="<?php echo $row['tel_contacto_prop']; ?>">
            </div>

            <div>
                <label for="email_contacto_prop">Email del contacto:</label>
                <input type="email" name="email_contacto_prop" id="email_contacto_prop" value="<?php echo $row['email_contacto_prop']; ?>">
            </div>

            <input type="submit" name="actualizar" value="Actualizar">
        </form>
        <p><a href="consultar_propietario.php">Volver</a></p>
    </div>
</body>
</html>