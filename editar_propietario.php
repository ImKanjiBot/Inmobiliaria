<?php
include("conexion.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM propietarios WHERE cod_propietario = '$id'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
    } else {
        echo "Propietario no encontrado.";
        exit;
    }
} else {
    echo "ID no proporcionado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Propietario</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Editar Propietario</h1>
    <form action="actualizar_propietario.php" method="POST">
        <input type="hidden" name="cod_propietario" value="<?php echo $row['cod_propietario']; ?>">

       <label for="tipo_empresa">Tipo de empresa:</label>
        <select name="tipo_empresa" id="tipo_empresa">
            <option value="Persona Natural" <?php if($row['tipo_empresa'] == 'Persona Natural') echo 'selected'; ?>>Persona Natural</option>
            <option value="Empresa" <?php if($row['tipo_empresa'] == 'Empresa') echo 'selected'; ?>>Empresa</option>
        </select><br>
        <label for="tipo_doc">Tipo de documento:</label>
        <select name="tipo_doc" id="tipo_doc">
            <option value="CC" <?php if($row['tipo_doc'] == 'CC') echo 'selected'; ?>>Cédula de ciudadanía (CC)</option>
            <option value="NIT" <?php if($row['tipo_doc'] == 'NIT') echo 'selected'; ?>>NIT</option>
            <option value="CE" <?php if($row['tipo_doc'] == 'CE') echo 'selected'; ?>>Cédula de extranjería (CE)</option>
            <option value="TI" <?php if($row['tipo_doc'] == 'TI') echo 'selected'; ?>>Tarjeta de Identidad (TI)</option>
        </select><br>


        <label for="num_doc">Número de documento:</label>
        <input type="text" name="num_doc" id="num_doc" value="<?php echo $row['num_doc']; ?>"><br>

        <label for="nombre_propietario">Nombre del propietario:</label>
        <input type="text" name="nombre_propietario" id="nombre_propietario" value="<?php echo $row['nombre_propietario']; ?>"><br>

        <label for="dir_propietario">Dirección del propietario:</label>
        <input type="text" name="dir_propietario" id="dir_propietario" value="<?php echo $row['dir_propietario']; ?>"><br>

        <label for="tel_propietario">Teléfono del propietario:</label>
        <input type="text" name="tel_propietario" id="tel_propietario" value="<?php echo $row['tel_propietario']; ?>"><br>

        <label for="email_propietario">Email del propietario:</label>
        <input type="email" name="email_propietario" id="email_propietario" value="<?php echo $row['email_propietario']; ?>"><br>

        <label for="contacto_prop">Nombre de contacto:</label>
        <input type="text" name="contacto_prop" id="contacto_prop" value="<?php echo $row['contacto_prop']; ?>"><br>

        <label for="tel_contacto_prop">Teléfono del contacto:</label>
        <input type="text" name="tel_contacto_prop" id="tel_contacto_prop" value="<?php echo $row['tel_contacto_prop']; ?>"><br>

        <label for="email_contacto_prop">Email del contacto:</label>
        <input type="email" name="email_contacto_prop" id="email_contacto_prop" value="<?php echo $row['email_contacto_prop']; ?>"><br>

        <input type="submit" name="actualizar" value="Actualizar">
    </form>
</body>
</html>
