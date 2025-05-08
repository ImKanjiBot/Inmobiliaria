<?php
include 'conexion.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Empleados</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Empleado</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Formulario de Registro de Empleado</h2>
    <form action="guardar_empleado.php" method="POST">

        <input type="hidden" name="cod_emp">

        <label for="tipo_doc">Tipo de Documento:</label>
        <select name="tipo_doc" id="tipo_doc" required>
            <option value="CEDULA">Cédula</option>
            <option value="CE">CE</option>
            <option value="TI">TI</option>
        </select><br><br>

        <label for="ced_emp">Número de Documento:</label>
        <input type="text" name="ced_emp" id="ced_emp" required><br><br>

        <label for="nom_emp">Nombre:</label>
        <input type="text" name="nom_emp" id="nom_emp" required><br><br>

        <label for="dir_emp">Dirección:</label>
        <input type="text" name="dir_emp" id="dir_emp"><br><br>

        <label for="tel_emp">Teléfono:</label>
        <input type="text" name="tel_emp" id="tel_emp"><br><br>

        <label for="email_emp">Email:</label>
        <input type="email" name="email_emp" id="email_emp"><br><br>

        <label for="rh_emp">RH:</label>
        <input type="text" name="rh_emp" id="rh_emp" maxlength="50"><br><br>

        <label for="fecha_nac">Fecha de Nacimiento:</label>
        <input type="date" name="fecha_nac" id="fecha_nac"><br><br>

        <label>Cargo:</label>
        <select name="cod_cargo" required>
            <option value="">Seleccione su cargo</option>
            <?php
                // Obtener cargos
                $sqlCat = "SELECT cod_cargo, nom_cargo FROM cargos";
                $resultCat = $conn->query($sqlCat);
                while ($rowCat = $resultCat->fetch_assoc()){
                    echo "<option value='".$rowCat['cod_cargo']."'>".$rowCat['nom_cargo']."</option>";
                }
            ?>
        </select> <br><br>

        <label for="salario">Salario:</label>
        <input type="number" name="salario" id="salario"><br><br>

        <label for="gastos">Gastos:</label>
        <input type="number" name="gastos" id="gastos"><br><br>

        <label for="comision">Comisión:</label>
        <input type="number" name="comision" id="comision"><br><br>

        <label for="fecha_ing">Fecha de Ingreso:</label>
        <input type="date" name="fecha_ing" id="fecha_ing"><br><br>

        <label for="fecha_ret">Fecha de Retiro:</label>
        <input type="date" name="fecha_ret" id="fecha_ret"><br><br>

        <h3>Información de Contacto de Emergencia</h3>

        <label for="nom_contacto">Nombre del Contacto:</label>
        <input type="text" name="nom_contacto" id="nom_contacto"><br><br>

        <label for="dir_contacto">Dirección del Contacto:</label>
        <input type="text" name="dir_contacto" id="dir_contacto"><br><br>

        <label for="tel_contacto">Teléfono del Contacto:</label>
        <input type="text" name="tel_contacto" id="tel_contacto"><br><br>

        <label for="email_contacto">Email del Contacto:</label>
        <input type="email" name="email_contacto" id="email_contacto"><br><br>

        <label for="relacion_contacto">Relación con el Contacto:</label>
        <input type="text" name="relacion_contacto" id="relacion_contacto"><br><br>

        <label>Oficina:</label>
        <select name="cod_ofi" required>
                <option value="">Seleccione la oficina</option>
            <?php
            //Obtener codigo de la oficina
            $sqlCat = "SELECT * FROM oficinas";
            $resultCat = $conn->query($sqlCat);
            while ($rowCat = $resultCat->fetch_assoc()){
                echo "<option value='".$rowCat['cod_ofi']."'>".$rowCat['nom_ofi']."</option>";
            }
            ?>
        </select> <br><br>

        <input type="submit" value="Guardar Empleado">
    </form>
    <button onclick="window.location.href='consultar_empleados.php' ">Consultar Empleados</button>
</body>
</html>
</body>
</html>
