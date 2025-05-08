<?php
include("conexion.php");

// Verificar si el ID está en la URL
if (isset($_GET["id"])) {
    $cod_emp = $_GET["id"];

    // Obtener datos del empleado
    $sql = "SELECT * FROM empleados WHERE cod_emp = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $cod_emp);
    $stmt->execute();
    $result = $stmt->get_result();
    $empleado = $result->fetch_assoc();
    $stmt->close();

    if (!$empleado) {
        echo "Empleado no encontrado.";
        exit;
    }
} else {
    echo "ID no proporcionado.";
    exit;
}

// Procesar el formulario si se envía
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST['cod_emp'])) {
        die("Error: Falta el código del empleado (cod_emp).");
    }

    // Recibir datos
    $ced_emp = $_POST['ced_emp'];
    $tipo_doc = $_POST['tipo_doc'];
    $nom_emp = $_POST['nom_emp'];
    $dir_emp = $_POST['dir_emp'];
    $tel_emp = $_POST['tel_emp'];
    $email_emp = $_POST['email_emp'];
    $rh_emp = $_POST['rh_emp'];
    $fecha_nac = $_POST['fecha_nac'];
    $cod_cargo = $_POST['cod_cargo'];
    $salario = $_POST['salario'];
    $gastos = $_POST['gastos'];
    $comision = $_POST['comision'];
    $fecha_ing = $_POST['fecha_ing'];
    $fecha_ret = $_POST['fecha_ret'];
    $nom_contacto = $_POST['nom_contacto'];
    $dir_contacto = $_POST['dir_contacto'];
    $tel_contacto = $_POST['tel_contacto'];
    $email_contacto = $_POST['email_contacto'];
    $relacion_contacto = $_POST['relacion_contacto'];
    $cod_ofi = $_POST['cod_ofi'];
    $cod_emp = $_POST['cod_emp'];

    // Actualizar empleado (NUEVO STATEMENT)
    $sql = "UPDATE empleados SET ced_emp = ?, tipo_doc=?, nom_emp=?, dir_emp=?, tel_emp=?, email_emp=?, rh_emp=?, fecha_nac=?, 
            cod_cargo=?, salario=?, gastos=?, comision=?, fecha_ing=?, fecha_ret=?, 
            nom_contacto=?, dir_contacto=?, tel_contacto=?, email_contacto=?, 
            relacion_contacto=?, cod_ofi=? WHERE cod_emp=?";

    // Crear nuevo statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "isssisssiiiissssissii", 
        $ced_emp, $tipo_doc, $nom_emp, $dir_emp, $tel_emp, $email_emp, $rh_emp, $fecha_nac,
        $cod_cargo, $salario, $gastos, $comision, $fecha_ing, $fecha_ret,
        $nom_contacto, $dir_contacto, $tel_contacto, $email_contacto, $relacion_contacto,
        $cod_ofi, $cod_emp
    );

    if ($stmt->execute()) {
        echo "<script>alert('Empleado actualizado correctamente'); window.location.href='consultar_empleados.php';</script>";
    } else {
        echo "<script>alert('Error al actualizar el empleado');</script>";
    }

    // Cerrar statement y conexión
    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Empleado</title>
</head>
<body>
    <h2>Editar Empleado</h2>
    <form method = POST>

    <input type="hidden" name="cod_emp" value="<?= isset($empleado["cod_emp"]) ? $empleado["cod_emp"] : '' ?>">

    <label for="tipo_doc">Tipo de Documento:</label>
    <select name="tipo_doc" id="tipo_doc" value="<?= $empleado["tipo_doc"] ?>" required>
            <option value="CEDULA">Cédula</option>
            <option value="CE">CE</option>
            <option value="TI">TI</option>
        </select><br><br>
    
        <label for="ced_emp">Número de Documento:</label>
        <input type="text" name="ced_emp" id="ced_emp" value="<?= $empleado["ced_emp"] ?>" required><br><br>

        <label for="nom_emp">Nombre:</label>
        <input type="text" name="nom_emp" id="nom_emp" value="<?= $empleado["nom_emp"] ?>" required><br><br>

        <label for="dir_emp">Dirección:</label>
        <input type="text" name="dir_emp" id="dir_emp" value="<?= $empleado["dir_emp"] ?>"><br><br>

        <label for="tel_emp">Teléfono:</label>
        <input type="text" name="tel_emp" id="tel_emp" value="<?= $empleado["tel_emp"] ?>"><br><br>

        <label for="email_emp">Email:</label>
        <input type="email" name="email_emp" id="email_emp" value="<?= $empleado["email_emp"] ?>"><br><br>

        <label for="rh_emp">RH:</label>
        <input type="text" name="rh_emp" id="rh_emp" value="<?= $empleado["rh_emp"] ?>"><br><br>

        <label for="fecha_nac">Fecha de Nacimiento:</label>
        <input type="date" name="fecha_nac" id="fecha_nac" value="<?= $empleado["fecha_nac"] ?>"><br><br>

        <label>Cargo:</label>
        <select name="cod_cargo"  value="<?= $empleado["cod_cargo"] ?>" required>
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
        <input type="number" name="salario" id="salario" value="<?= $empleado["salario"] ?>"><br><br>

        <label for="gastos">Gastos:</label>
        <input type="number" name="gastos" id="gastos" value="<?= $empleado["gastos"] ?>"><br><br>

        <label for="comision">Comisión:</label>
        <input type="number" name="comision" id="comision" value="<?= $empleado["comision"] ?>"><br><br>

        <label for="fecha_ing">Fecha de Ingreso:</label>
        <input type="date" name="fecha_ing" id="fecha_ing" value="<?= $empleado["fecha_ing"] ?>"><br><br>

        <label for="fecha_ret">Fecha de Retiro:</label>
        <input type="date" name="fecha_ret" id="fecha_ret" value="<?= $empleado["fecha_ret"] ?>"><br><br>

        <h3>Información de Contacto de Emergencia</h3>

        <label for="nom_contacto">Nombre del Contacto:</label>
        <input type="text" name="nom_contacto" id="nom_contacto" value="<?= $empleado["nom_contacto"] ?>"><br><br>

        <label for="dir_contacto">Dirección del Contacto:</label>
        <input type="text" name="dir_contacto" id="dir_contacto" value="<?= $empleado["dir_contacto"] ?>"><br><br>

        <label for="tel_contacto">Teléfono del Contacto:</label>
        <input type="text" name="tel_contacto" id="tel_contacto" value="<?= $empleado["tel_contacto"] ?>"><br><br>

        <label for="email_contacto">Email del Contacto:</label>
        <input type="email" name="email_contacto" id="email_contacto" value="<?= $empleado["email_contacto"] ?>"><br><br>

        <label for="relacion_contacto">Relación con el Contacto:</label>
        <input type="text" name="relacion_contacto" id="relacion_contacto" value="<?= $empleado["relacion_contacto"] ?>"><br><br>

        <label>Oficina:</label>
        <select name="cod_ofi" value="<?= $empleado["cod_ofi"] ?>" required>
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
</body>
</html>