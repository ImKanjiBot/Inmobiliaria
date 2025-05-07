<?php
include 'conexion.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Propietario</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Formulario de Registro de Propietario</h2>
    <form method="POST">
        <label for="tipo_empresa">Tipo de Empresa:</label>
        <select name="tipo_empresa" id="tipo_empresa">
            <option value="Persona Natural">Persona Natural</option>
            <option value="Juridica">Jurídica</option>
        </select>
        <br><br>

        <label for="tipo_doc">Tipo de Documento:</label>
        <select name="tipo_doc" id="tipo_doc">
            <option value="CC">CC</option>
            <option value="TI">TI</option>
            <option value="CE">CE</option>
        </select>
        <br><br>

        <label for="num_doc">Número de Documento:</label>
        <input type="text" name="num_doc" id="num_doc" required>
        <br><br>

        <label for="nombre_propietario">Nombre del Propietario:</label>
        <input type="text" name="nombre_propietario" id="nombre_propietario" maxlength="100" required>
        <br><br>

        <label for="dir_propietario">Dirección:</label>
        <input type="text" name="dir_propietario" id="dir_propietario" maxlength="150">
        <br><br>

        <label for="tel_propietario">Teléfono:</label>
        <input type="text" name="tel_propietario" id="tel_propietario" maxlength="12">
        <br><br>

        <label for="email_propietario">Email:</label>
        <input type="email" name="email_propietario" id="email_propietario" maxlength="50">
        <br><br>

        <label for="contacto_prop">Nombre del Contacto:</label>
        <input type="text" name="contacto_prop" id="contacto_prop" maxlength="100">
        <br><br>

        <label for="tel_contacto_prop">Teléfono del Contacto:</label>
        <input type="text" name="tel_contacto_prop" id="tel_contacto_prop" maxlength="12">
        <br><br>

        <label for="email_contacto_prop">Email del Contacto:</label>
        <input type="email" name="email_contacto_prop" id="email_contacto_prop" maxlength="50">
        <br><br>

        <input type="submit" value="Guardar Propietario" formaction="guardar_propietario.php">
        <p><a href="consultar_propietario.php">consultar Propietario</a></p>

    </form>
   
</body>|
</html>
