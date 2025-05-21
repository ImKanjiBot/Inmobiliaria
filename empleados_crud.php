<?php
include 'conexion.php';
session_start();
if (!isset($_SESSION['rol_usuario'])) {
    // Si no ha iniciado sesión, redirige a login.php
    header("Location: login.php");
    exit();
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Empleado</title>
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

        input[type="submit"],
        button {
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

        input[type="submit"]:hover,
        button:hover {
            background-color: #43a047;
        }

        button {
            background-color: #007bff;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Formulario de Registro de Empleado</h2>
        <hr>
        <form action="guardar_empleado.php" method="POST">

            <input type="hidden" name="cod_emp">

            <label for="tipo_doc">Tipo de Documento:</label>
            <select name="tipo_doc" id="tipo_doc" required>
                <option value="CEDULA">Cédula</option>
                <option value="CE">CE</option>
                <option value="TI">TI</option>
            </select>

            <label for="ced_emp">Número de Documento:</label>
            <input type="text" name="ced_emp" id="ced_emp" required>

            <label for="nom_emp">Nombre:</label>
            <input type="text" name="nom_emp" id="nom_emp" required>

            <label for="dir_emp">Dirección:</label>
            <input type="text" name="dir_emp" id="dir_emp">

            <label for="tel_emp">Teléfono:</label>
            <input type="text" name="tel_emp" id="tel_emp">

            <label for="email_emp">Email:</label>
            <input type="email" name="email_emp" id="email_emp">

            <label for="rh_emp">RH:</label>
            <input type="text" name="rh_emp" id="rh_emp" maxlength="50">

            <label for="fecha_nac">Fecha de Nacimiento:</label>
            <input type="date" name="fecha_nac" id="fecha_nac">

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
            </select>

            <label for="salario">Salario:</label>
            <input type="number" name="salario" id="salario">

            <label for="gastos">Gastos:</label>
            <input type="number" name="gastos" id="gastos">

            <label for="comision">Comisión:</label>
            <input type="number" name="comision" id="comision">

            <label for="fecha_ing">Fecha de Ingreso:</label>
            <input type="date" name="fecha_ing" id="fecha_ing">

            <label for="fecha_ret">Fecha de Retiro:</label>
            <input type="date" name="fecha_ret" id="fecha_ret">

            <h3>Información de Contacto de Emergencia</h3>

            <label for="nom_contacto">Nombre del Contacto:</label>
            <input type="text" name="nom_contacto" id="nom_contacto">

            <label for="dir_contacto">Dirección del Contacto:</label>
            <input type="text" name="dir_contacto" id="dir_contacto">

            <label for="tel_contacto">Teléfono del Contacto:</label>
            <input type="text" name="tel_contacto" id="tel_contacto">

            <label for="email_contacto">Email del Contacto:</label>
            <input type="email" name="email_contacto" id="email_contacto">

            <label for="relacion_contacto">Relación con el Contacto:</label>
            <input type="text" name="relacion_contacto" id="relacion_contacto">

            <label>Oficina:</label>
            <select name="cod_ofi" required>
                <option value="">Seleccione la oficina</option>
                <?php
                    //Obtener codigo de la oficina
                    $sqlOfi = "SELECT * FROM oficinas";
                    $resultOfi = $conn->query($sqlOfi);
                    while ($rowOfi = $resultOfi->fetch_assoc()){
                        echo "<option value='".$rowOfi['cod_ofi']."'>".$rowOfi['nom_ofi']."</option>";
                    }
                ?>
            </select>

            <input type="submit" value="Guardar Empleado">
        </form>
        <button onclick="window.location.href='consultar_empleados.php' ">Consultar Empleados</button>
    </div>
</body>
</html>