<?php
include 'conexion.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visitas Crud</title>
</head>
<body>
    <h2>Registro de Visitas</h2>

    <form action="guardar_vistas.php">

    <label for="fecha_vis">Fecha de la visita:</label>
    <input type="date" id="fecha_vis" name="fecha_vis"/><br>

    <label>Codigo del Cliente:</label>
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
        </select> <br>

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
        </select><br>

        <label>Direccion del inmueble:</label>
        <select name="cod_inm" required>
                <option value="">Seleccione el código del empleado</option>
            <?php

            //Obtener codigo del empleado
            $sqlCat = "SELECT * FROM inmuebles";
            $resultCat = $conn->query($sqlCat);
            while ($rowCat = $resultCat->fetch_assoc()){
                echo "<option value='".$rowCat['cod_inm']."'>".$rowCat['dir_inm']."</option>";
            }
            ?>
        </select><br>

        <label>Comentarios de la visita</label>
            <textarea id="comenta_vis" name="comenta_vis"></textarea><br><br>

            <button type="submit">Guardar Visita</button>
    </form>
            <button onclick="window.location.href='consultar_visitas.php'"> Consultar Visitas</button>
</body>
</html>