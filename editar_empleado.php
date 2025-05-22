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
            max-width: 600px;
            margin: 20px auto;
            display: grid;
            grid-template-columns: auto 1fr;
            gap: 15px 20px;
        }

        h3 {
            color: #333;
            grid-column: 1 / -1; /* Ocupa toda la fila */
            margin-top: 20px;
            margin-bottom: 10px;
            text-align: center;
        }

        label {
            color: #333;
            font-weight: bold;
            text-align: left;
        }

        input[type="text"],
        input[type="email"],
        input[type="date"],
        input[type="number"],
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
        input[type="date"]:focus,
        input[type="number"]:focus,
        select:focus {
            outline: none;
            border-color: #2196f3;
            box-shadow: 0 0 5px rgba(33, 150, 243, 0.5);
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            grid-column: 1 / -1;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }

        form a {
            display: inline-block;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease, color 0.3s ease;
            margin-top: 20px;
            font-size: 1em;
        }

        input[type="submit"]:hover {
            background-color: #43a047;
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
        <h2>Editar Empleado</h2>
        <hr>
        <form method="POST">

            <input type="hidden" name="cod_emp" value="<?= isset($empleado["cod_emp"]) ? $empleado["cod_emp"] : '' ?>">

            <label for="tipo_doc">Tipo de Documento:</label>
            <select name="tipo_doc" id="tipo_doc" required>
                <option value="CEDULA" <?= (isset($empleado["tipo_doc"]) && $empleado["tipo_doc"] == 'CEDULA') ? 'selected' : '' ?>>Cédula</option>
                <option value="CE" <?= (isset($empleado["tipo_doc"]) && $empleado["tipo_doc"] == 'CE') ? 'selected' : '' ?>>CE</option>
                <option value="TI" <?= (isset($empleado["tipo_doc"]) && $empleado["tipo_doc"] == 'TI') ? 'selected' : '' ?>>TI</option>
            </select>

            <label for="ced_emp">Número de Documento:</label>
            <input type="text" name="ced_emp" id="ced_emp" value="<?= isset($empleado["ced_emp"]) ? $empleado["ced_emp"] : '' ?>" required>

            <label for="nom_emp">Nombre:</label>
            <input type="text" name="nom_emp" id="nom_emp" value="<?= isset($empleado["nom_emp"]) ? $empleado["nom_emp"] : '' ?>" required>

            <label for="dir_emp">Dirección:</label>
            <input type="text" name="dir_emp" id="dir_emp" value="<?= isset($empleado["dir_emp"]) ? $empleado["dir_emp"] : '' ?>">

            <label for="tel_emp">Teléfono:</label>
            <input type="text" name="tel_emp" id="tel_emp" value="<?= isset($empleado["tel_emp"]) ? $empleado["tel_emp"] : '' ?>">

            <label for="email_emp">Email:</label>
            <input type="email" name="email_emp" id="email_emp" value="<?= isset($empleado["email_emp"]) ? $empleado["email_emp"] : '' ?>">

            <label for="rh_emp">RH:</label>
            <input type="text" name="rh_emp" id="rh_emp" value="<?= isset($empleado["rh_emp"]) ? $empleado["rh_emp"] : '' ?>">

            <label for="fecha_nac">Fecha de Nacimiento:</label>
            <input type="date" name="fecha_nac" id="fecha_nac" value="<?= isset($empleado["fecha_nac"]) ? $empleado["fecha_nac"] : '' ?>">

            <label>Cargo:</label>
            <select name="cod_cargo" required>
                <option value="">Seleccione su cargo</option>
                <?php
                    // Obtener cargos
                    $sqlCat = "SELECT cod_cargo, nom_cargo FROM cargos";
                    $resultCat = $conn->query($sqlCat);
                    while ($rowCat = $resultCat->fetch_assoc()){
                        $selected = (isset($empleado["cod_cargo"]) && $empleado["cod_cargo"] == $rowCat['cod_cargo']) ? 'selected' : '';
                        echo "<option value='".$rowCat['cod_cargo']."' ".$selected.">".$rowCat['nom_cargo']."</option>";
                    }
                ?>
            </select>

            <label for="salario">Salario:</label>
            <input type="number" name="salario" id="salario" value="<?= isset($empleado["salario"]) ? $empleado["salario"] : '' ?>">

            <label for="gastos">Gastos:</label>
            <input type="number" name="gastos" id="gastos" value="<?= isset($empleado["gastos"]) ? $empleado["gastos"] : '' ?>">

            <label for="comision">Comisión:</label>
            <input type="number" name="comision" id="comision" value="<?= isset($empleado["comision"]) ? $empleado["comision"] : '' ?>">

            <label for="fecha_ing">Fecha de Ingreso:</label>
            <input type="date" name="fecha_ing" id="fecha_ing" value="<?= isset($empleado["fecha_ing"]) ? $empleado["fecha_ing"] : '' ?>">

            <label for="fecha_ret">Fecha de Retiro:</label>
            <input type="date" name="fecha_ret" id="fecha_ret" value="<?= isset($empleado["fecha_ret"]) ? $empleado["fecha_ret"] : '' ?>">

            <h3>Información de Contacto de Emergencia</h3>

            <label for="nom_contacto">Nombre del Contacto:</label>
            <input type="text" name="nom_contacto" id="nom_contacto" value="<?= isset($empleado["nom_contacto"]) ? $empleado["nom_contacto"] : '' ?>">

            <label for="dir_contacto">Dirección del Contacto:</label>
            <input type="text" name="dir_contacto" id="dir_contacto" value="<?= isset($empleado["dir_contacto"]) ? $empleado["dir_contacto"] : '' ?>">

            <label for="tel_contacto">Teléfono del Contacto:</label>
            <input type="text" name="tel_contacto" id="tel_contacto" value="<?= isset($empleado["tel_contacto"]) ? $empleado["tel_contacto"] : '' ?>">

            <label for="email_contacto">Email del Contacto:</label>
            <input type="email" name="email_contacto" id="email_contacto" value="<?= isset($empleado["email_contacto"]) ? $empleado["email_contacto"] : '' ?>">

            <label for="relacion_contacto">Relación con el Contacto:</label>
            <input type="text" name="relacion_contacto" id="relacion_contacto" value="<?= isset($empleado["relacion_contacto"]) ? $empleado["relacion_contacto"] : '' ?>">

            <label>Oficina:</label>
            <select name="cod_ofi" required>
                <option value="">Seleccione la oficina</option>
                <?php
                    //Obtener codigo de la oficina
                    $sqlOfi = "SELECT * FROM oficinas";
                    $resultOfi = $conn->query($sqlOfi);
                    while ($rowOfi = $resultOfi->fetch_assoc()){
                        $selected = (isset($empleado["cod_ofi"]) && $empleado["cod_ofi"] == $rowOfi['cod_ofi']) ? 'selected' : '';
                        echo "<option value='".$rowOfi['cod_ofi']."' ".$selected.">".$rowOfi['nom_ofi']."</option>";
                    }
                ?>
            </select>
            <div>
                <input type="submit" value="Guardar Empleado">
                <a href="consultar_empleados.php">Cancelar</a>
            </div>
            
        </form>
    </div>
</body>
</html>