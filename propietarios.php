<?php
include 'conexion.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Propietario</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        h2 {
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
            gap: 15px 20px;
        }

        label {
            color: #333;
            font-weight: bold;
            text-align: left;
        }

        input[type="text"],
        input[type="email"],
        select {
            width: calc(100% - 12px);
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 1em;
        }

        select {
            appearance: none;
            background-image: url('data:image/svg+xml;charset=UTF-8,<svg fill="%23333" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg>');
            background-repeat: no-repeat;
            background-position: right 8px center;
            background-size: 16px;
            padding-right: 30px;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        select:focus {
            outline: none;
            border-color: #2196f3;
            box-shadow: 0 0 5px rgba(33, 150, 243, 0.5);
        }

        input[type="submit"],
        p a {
            background-color: #4caf50;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s ease;
            text-decoration: none;
            text-align: center;
            display: block;
            margin-top: 20px;
        }

        input[type="submit"]:hover,
        p a:hover {
            background-color: #43a047;
        }

        p a {
            background-color: #007bff;
        }

        p a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Formulario de Registro de Propietario</h2>
        <hr>
        <form method="POST" action="guardar_propietario.php">
            <label for="tipo_empresa">Tipo de Empresa:</label>
            <select name="tipo_empresa" id="tipo_empresa">
                <option value="Persona Natural">Persona Natural</option>
                <option value="Juridica">Jurídica</option>
            </select>

            <label for="tipo_doc">Tipo de Documento:</label>
            <select name="tipo_doc" id="tipo_doc">
                <option value="CC">CC</option>
                <option value="TI">TI</option>
                <option value="CE">CE</option>
            </select>

            <label for="num_doc">Número de Documento:</label>
            <input type="text" name="num_doc" id="num_doc" required>

            <label for="nombre_propietario">Nombre del Propietario:</label>
            <input type="text" name="nombre_propietario" id="nombre_propietario" maxlength="100" required>

            <label for="dir_propietario">Dirección:</label>
            <input type="text" name="dir_propietario" id="dir_propietario" maxlength="150">

            <label for="tel_propietario">Teléfono:</label>
            <input type="text" name="tel_propietario" id="tel_propietario" maxlength="12">

            <label for="email_propietario">Email:</label>
            <input type="email" name="email_propietario" id="email_propietario" maxlength="50">

            <label for="contacto_prop">Nombre del Contacto:</label>
            <input type="text" name="contacto_prop" id="contacto_prop" maxlength="100">

            <label for="tel_contacto_prop">Teléfono del Contacto:</label>
            <input type="text" name="tel_contacto_prop" id="tel_contacto_prop" maxlength="12">

            <label for="email_contacto_prop">Email del Contacto:</label>
            <input type="email" name="email_contacto_prop" id="email_contacto_prop" maxlength="50">

            <input type="submit" value="Guardar Propietario">
        </form>
        <p><a href="consultar_propietario.php">Consultar Propietario</a></p>
    </div>
</body>
</html>