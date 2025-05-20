<?php
include_once 'conexion.php';
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Propietario</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Estilos específicos para el formulario de registro de propietario */
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
            text-align: left;
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

        form input[type="submit"],
        form p a {
            display: inline-block;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease, color 0.3s ease;
            margin-top: 20px;
            font-size: 1em;
            text-align: center;
        }

        form input[type="submit"] {
            background-color: #4caf50;
            color: white;
            border: none;
            cursor: pointer;
        }

        form input[type="submit"]:hover {
            background-color: #43a047;
        }

        form p a {
            background-color: #2196f3;
            color: white;
        }

        form p a:hover {
            background-color: #1976d2;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Formulario de Registro de Propietario</h2>
        <hr>
        <form action="guardar_propietario.php" method="POST">
            <div>
                <label for="tipo_empresa">Tipo de Empresa:</label>
                <select name="tipo_empresa" id="tipo_empresa">
                    <option value="Persona Natural">Persona Natural</option>
                    <option value="Juridica">Jurídica</option>
                </select>
            </div>

            <div>
                <label for="tipo_doc">Tipo de Documento:</label>
                <select name="tipo_doc" id="tipo_doc">
                    <option value="CC">CC</option>
                    <option value="TI">TI</option>
                    <option value="CE">CE</option>
                </select>
            </div>

            <div>
                <label for="num_doc">Número de Documento:</label>
                <input type="text" name="num_doc" id="num_doc" required>
            </div>

            <div>
                <label for="nombre_propietario">Nombre del Propietario:</label>
                <input type="text" name="nombre_propietario" id="nombre_propietario" maxlength="100" required>
            </div>

            <div>
                <label for="dir_propietario">Dirección:</label>
                <input type="text" name="dir_propietario" id="dir_propietario" maxlength="150">
            </div>

            <div>
                <label for="tel_propietario">Teléfono:</label>
                <input type="text" name="tel_propietario" id="tel_propietario" maxlength="12">
            </div>

            <div>
                <label for="email_propietario">Email:</label>
                <input type="email" name="email_propietario" id="email_propietario" maxlength="50">
            </div>

            <div>
                <label for="contacto_prop">Nombre del Contacto:</label>
                <input type="text" name="contacto_prop" id="contacto_prop" maxlength="100">
            </div>

            <div>
                <label for="tel_contacto_prop">Teléfono del Contacto:</label>
                <input type="text" name="tel_contacto_prop" id="tel_contacto_prop" maxlength="12">
            </div>

            <div>
                <label for="email_contacto_prop">Email del Contacto:</label>
                <input type="email" name="email_contacto_prop" id="email_contacto_prop" maxlength="50">
            </div>

            <div style="grid-column: 1 / -1; display: flex; flex-direction: column; align-items: center; gap: 10px; margin-top: 20px;">
                <input type="submit" value="Guardar Propietario" formaction="guardar_propietario.php">
                <p><a href="consultar_propietario.php">Consultar Propietario</a></p>
            </div>
        </form>
    </div>
</body>
</html>