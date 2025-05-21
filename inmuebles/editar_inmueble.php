<?php
include '../conexion.php';
session_start();
if (!isset($_SESSION['rol_usuario'])) {
    header("Location: ../login.php");
    exit();
}

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
            max-width: 500px;
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
        input[type="file"],
        select,
        textarea {
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

        textarea {
            resize: vertical;
            min-height: 80px;
        }

        input[type="text"]:read-only {
            background-color: #eee;
            cursor: not-allowed;
        }

        input[type="text"]:focus,
        input[type="file"]:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #2196f3;
            box-shadow: 0 0 5px rgba(33, 150, 243, 0.5);
        }

        button[type="submit"], .menu-btn, .cancel-btn {
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s ease;
            margin-top: 20px;
            width: 100%;
            display: block;
            text-align: center;
        }

        button[type="submit"] {
            background-color: #4caf50;
            color: white;
        }

        button[type="submit"]:hover {
            background-color: #43a047;
        }

        .menu-btn {
            background-color: #6c757d;
            color: white;
        }

        .menu-btn:hover {
            background-color: #5a6268;
        }

        .cancel-btn {
            background-color: #dc3545;
            color: white;
        }

        .cancel-btn:hover {
            background-color: #c82333;
        }

        p {
            grid-column: 1 / -1;
            font-size: 0.9em;
            color: #777;
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Editar Inmueble</h2>
        <hr>
        <form action="actualizar_inmueble.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="cod_inm" value="<?php echo $row['cod_inm']; ?>">

            <label for="dir_inm">Dirección del Inmueble:</label>
            <input type="text" id="dir_inm" name="dir_inm" value="<?php echo $row['dir_inm']; ?>" required>

            <label for="barrio_inm">Barrio:</label>
            <input type="text" id="barrio_inm" name="barrio_inm" value="<?php echo $row['barrio_inm']; ?>" required>

            <label for="ciudad_inm">Ciudad:</label>
            <input type="text" id="ciudad_inm" name="ciudad_inm" value="<?php echo $row['ciudad_inm']; ?>" required>

            <label for="departamento_inm">Departamento:</label>
            <input type="text" id="departamento_inm" name="departamento_inm" value="<?php echo $row['departamento_inm']; ?>" required>

            <label>Ubicación (Latitud y Longitud):</label>
            <input type="text" id="latitud" name="latitud" value="<?php echo $row['latitud']; ?>" readonly>
            <input type="text" id="longitud" name="longitud" value="<?php echo $row['longitud']; ?>" readonly>

            <label for="foto">Foto del Inmueble:</label>
            <input type="file" id="foto" name="foto">
            <p>Foto actual: <?php echo basename($row['foto']); ?></p>

            <label for="web_p1">Web 1:</label>
            <input type="text" id="web_p1" name="web_p1" value="<?php echo $row['web_p1']; ?>" required>

            <label for="web_p2">Web 2:</label>
            <input type="text" id="web_p2" name="web_p2" value="<?php echo $row['web_p2']; ?>" required>

            <label for="cod_tipoinm">Tipo de inmueble:</label>
            <select name="cod_tipoinm" id="cod_tipoinm" required>
                <option value="">Seleccione un tipo de inmueble</option>
                <?php
                $sqlTipoInm = "SELECT cod_tipoinm, nom_tipoinm FROM tipo_inmueble";
                $resultTipoInm = $conn->query($sqlTipoInm);
                while ($rowTipoInm = $resultTipoInm->fetch_assoc()){
                    $selected = $rowTipoInm['cod_tipoinm'] == $row['cod_tipoinm'] ? 'selected' : '';
                    echo "<option value='{$rowTipoInm['cod_tipoinm']}' $selected>{$rowTipoInm['nom_tipoinm']}</option>";
                }
                ?>
            </select>

            <label for="num_hab">Número de habitaciones:</label>
            <input type="text" id="num_hab" name="num_hab" value="<?php echo $row['num_hab']; ?>" required>

            <label for="precio_alq">Precio mensual del alquiler:</label>
            <input type="text" id="precio_alq" name="precio_alq" value="<?php echo $row['precio_alq']; ?>" required>

            <label for="cod_propietario">Nombre del propietario:</label>
            <select name="cod_propietario" id="cod_propietario" required>
                <option value="">Seleccione el propietario</option>
                <?php
                $sqlPropietario = "SELECT cod_propietario, nombre_propietario FROM propietarios";
                $resultPropietario = $conn->query($sqlPropietario);
                while ($rowPropietario = $resultPropietario->fetch_assoc()){
                    $selected = $rowPropietario['cod_propietario'] == $row['cod_propietario'] ? 'selected' : '';
                    echo "<option value='{$rowPropietario['cod_propietario']}' $selected>{$rowPropietario['nombre_propietario']}</option>";
                }
                ?>
            </select>

            <label for="caracteristica_inm">Características del inmueble:</label>
            <select name="caracteristica_inm" id="caracteristica_inm" required>
                <option value="conjunto" <?php if($row['caracteristica_inm'] == 'conjunto') echo 'selected'; ?>>Conjunto</option>
                <option value="urbanizacion" <?php if($row['caracteristica_inm'] == 'urbanizacion') echo 'selected'; ?>>Urbanización</option>
            </select>

            <label for="notas_inm">Notas del Inmueble:</label>
            <textarea name="notas_inm" id="notas_inm"><?php echo $row['notas_inm']; ?></textarea>

            <label for="cod_emp">Nombre del empleado:</label>
            <select name="cod_emp" id="cod_emp" required>
                <option value="">Seleccione el empleado</option>
                <?php
                $sqlEmpleado = "SELECT cod_emp, nom_emp FROM empleados";
                $resultEmpleado = $conn->query($sqlEmpleado);
                while ($rowEmpleado = $resultEmpleado->fetch_assoc()){
                    $selected = $rowEmpleado['cod_emp'] == $row['cod_emp'] ? 'selected' : '';
                    echo "<option value='{$rowEmpleado['cod_emp']}' $selected>{$rowEmpleado['nom_emp']}</option>";
                }
                ?>
            </select>

            <label for="cod_ofi">Código de la Oficina:</label>
            <select name="cod_ofi" id="cod_ofi" required>
                <option value="">Seleccione la oficina</option>
                <?php
                $sqlOficina = "SELECT cod_ofi, nom_ofi FROM oficinas";
                $resultOficina = $conn->query($sqlOficina);
                while ($rowOficina = $resultOficina->fetch_assoc()){
                    $selected = $rowOficina['cod_ofi'] == $row['cod_ofi'] ? 'selected' : '';
                    echo "<option value='{$rowOficina['cod_ofi']}' $selected>{$rowOficina['nom_ofi']}</option>";
                }
                ?>
            </select>

            <button type="submit">Actualizar Inmueble</button>
            <button type="button" class="cancel-btn" onclick="window.location.href='inmueble_crud.php'">Cancelar</button>
        </form>

        <?php
        if (isset($_SESSION['rol_usuario'])) {
            $rolUsuario = $_SESSION['rol_usuario'];
            $urlRedireccion = '';

            switch ($rolUsuario) {
                case 'admin':
                    $urlRedireccion = '../menu_admin.php';
                    break;
                case 'empleado':
                    $urlRedireccion = '../menu_empleado.php';
                    break;
                case 'cliente':
                    $urlRedireccion = '../menu_cliente.php';
                    break;
                default:
                    $urlRedireccion = '../login.php';
                    break;
            }
            echo '<button class="menu-btn" onclick="window.location.href=\'' . $urlRedireccion . '\'">Ir al Menú</button>';
        } else {
            echo '<button class="menu-btn" onclick="window.location.href=\'../login.php\'">Ir al Menú</button>';
        }
        ?>
    </div>
</body>
</html>

