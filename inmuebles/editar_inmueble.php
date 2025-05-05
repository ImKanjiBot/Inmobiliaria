<?php
include '../conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM inmuebles WHERE cod_inm= '$id'";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
    } else {
        echo "Inmueble no encontrado.";
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
    <title>Editar Inmueble</title>
</head>
<body>
    <h2>Editar Inmueble</h2>
    <form action="actualizar_inmueble.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="cod_inm" value="<?php echo $row['cod_inm']; ?>">

        <label for="dir_inm">Dirección del Inmueble:</label>
        <input type="text" id="dir_inm" name="dir_inm" value="<?php echo $row['dir_inm']; ?>" required><br>

        <label for="barrio_inm">Barrio:</label>
        <input type="text" id="barrio_inm" name="barrio_inm" value="<?php echo $row['barrio_inm']; ?>" required><br>

        <label for="ciudad_inm">Ciudad:</label>
        <input type="text" id="ciudad_inm" name="ciudad_inm" value="<?php echo $row['ciudad_inm']; ?>" required><br>

        <label for="departamento_inm">Departamento:</label>
        <input type="text" id="departamento_inm" name="departamento_inm" value="<?php echo $row['departamento_inm']; ?>" required><br>

        <label>Ubicación (Latitud y Longitud):</label>
        <input type="text" id="latitud" name="latitud" value="<?php echo $row['latitud']; ?>" readonly><br>
        <input type="text" id="longitud" name="longitud" value="<?php echo $row['longitud']; ?>" readonly><br>


        <label for="foto">Foto del Inmueble:</label>
        <input type="file" id="foto" name="foto">
        <p>Foto actual: <?php echo basename($row['foto']); ?></p><br>

        <label for="web_p1">Web 1:</label>
        <input type="text" id="web_p1" name="web_p1" value="<?php echo $row['web_p1']; ?>" required><br>

        <label for="web_p2">Web 2:</label>
        <input type="text" id="web_p2" name="web_p2" value="<?php echo $row['web_p2']; ?>" required><br>

        <label>Tipo de inmueble:</label>
        <select name="cod_tipoinm" required>
            <option value="">Seleccione un tipo de inmueble</option>
            <?php
            $sqlCat = "SELECT cod_tipoinm, nom_tipoinm FROM tipo_inmueble";
            $resultCat = $conn->query($sqlCat);
            while ($rowCat = $resultCat->fetch_assoc()){
                $selected = $rowCat['cod_tipoinm'] == $row['cod_tipoinm'] ? 'selected' : '';
                echo "<option value='{$rowCat['cod_tipoinm']}' $selected>{$rowCat['nom_tipoinm']}</option>";
            }
            ?>
        </select>
        <br>
        <label for="num_hab">Número de habitaciones:</label>
        <input type="text" id="num_hab" name="num_hab" value="<?php echo $row['num_hab']; ?>" required><br>

        <label for="precio_alq">Precio mensual del alquiler:</label>
        <input type="text" id="precio_alq" name="precio_alq" value="<?php echo $row['precio_alq']; ?>" required><br>

        <label>Nombre del propietario:</label>
        <select name="cod_propietario" required>
            <option value="">Seleccione el propietario</option>
            <?php
            $sqlCat = "SELECT cod_propietario, nombre_propietario FROM propietarios";
            $resultCat = $conn->query($sqlCat);
            while ($rowCat = $resultCat->fetch_assoc()){
                $selected = $rowCat['cod_propietario'] == $row['cod_propietario'] ? 'selected' : '';
                echo "<option value='{$rowCat['cod_propietario']}' $selected>{$rowCat['nombre_propietario']}</option>";
            }
            ?>
        </select>
        <br>
        <label>Características del inmueble:</label>
        <select name="caracteristica_inm" required>
            <option value="conjunto" <?php if($row['caracteristica_inm'] == 'conjunto') echo 'selected'; ?>>Conjunto</option>
            <option value="urbanizacion" <?php if($row['caracteristica_inm'] == 'urbanizacion') echo 'selected'; ?>>Urbanización</option>
        </select>
        <br>
        <label>Notas del Inmueble:</label>
        <textarea name="notas_inm"><?php echo $row['notas_inm']; ?></textarea>
        <br>
        <label>Nombre del empleado:</label>
        <select name="cod_emp" required>
            <option value="">Seleccione el empleado</option>
            <?php
            $sqlCat = "SELECT * FROM empleados";
            $resultCat = $conn->query($sqlCat);
            while ($rowCat = $resultCat->fetch_assoc()){
                $selected = $rowCat['cod_emp'] == $row['cod_emp'] ? 'selected' : '';
                echo "<option value='{$rowCat['cod_emp']}' $selected>{$rowCat['nom_emp']}</option>";
            }
            ?>
        </select>
        <br>
        <label>Código de la Oficina:</label>
        <select name="cod_ofi" required>
            <option value="">Seleccione la oficina</option>
            <?php
            $sqlCat = "SELECT * FROM oficinas";
            $resultCat = $conn->query($sqlCat);
            while ($rowCat = $resultCat->fetch_assoc()){
                $selected = $rowCat['cod_ofi'] == $row['cod_ofi'] ? 'selected' : '';
                echo "<option value='{$rowCat['cod_ofi']}' $selected>{$rowCat['nom_ofi']}</option>";
            }
            ?>
        </select>
        <br>
        <button type="submit">Actualizar Inmueble</button>
    </form>

    
</body>
</html>
