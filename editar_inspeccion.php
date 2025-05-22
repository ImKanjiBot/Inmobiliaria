<?php
// Incluir el archivo de conexión a la base de datos
require_once 'conexion.php';
session_start();
if (!isset($_SESSION['rol_usuario'])) {
    header("Location: ../login.php");
    exit();
}

// Verificar si se recibió el ID de la inspección a editar
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $cod_ins = $_GET['id'];

    // Consultar la inspección específica y las tablas relacionadas
    $sql = "SELECT
        i.cod_ins,
        i.fecha_ins,
        i.cod_inm,
        inm.dir_inm AS direccion_inmueble,
        i.cod_emp,
        emp.nom_emp AS nombre_empleado,
        i.comentario
    FROM inspeccion i
    JOIN inmuebles inm ON i.cod_inm = inm.cod_inm
    JOIN empleados emp ON i.cod_emp = emp.cod_emp
    WHERE i.cod_ins = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $cod_ins);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows == 1) {
        $inspeccion = $resultado->fetch_assoc();

        // Consultar todos los inmuebles para el desplegable
        $sql_inmuebles = "SELECT cod_inm, dir_inm FROM inmuebles";
        $resultado_inmuebles = $conn->query($sql_inmuebles);
        $inmuebles = [];
        if ($resultado_inmuebles->num_rows > 0) {
            while ($fila = $resultado_inmuebles->fetch_assoc()) {
                $inmuebles[$fila['cod_inm']] = $fila['dir_inm'];
            }
        }

        // Consultar todos los empleados para el desplegable
        $sql_empleados = "SELECT cod_emp, nom_emp FROM empleados";
        $resultado_empleados = $conn->query($sql_empleados);
        $empleados = [];
        if ($resultado_empleados->num_rows > 0) {
            while ($fila = $resultado_empleados->fetch_assoc()) {
                $empleados[$fila['cod_emp']] = $fila['nom_emp'];
            }
        }

    } else {
        $_SESSION['mensaje'] = "Inspección no encontrada.";
        header("Location: consultar_inspecciones.php");
        exit();
    }

    $stmt->close();

} else {
    $_SESSION['mensaje'] = "ID de inspección no válido.";
    header("Location: consultar_inspecciones.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Inspección</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        h1 {
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
            gap: 15px;
        }

        form div {
            display: grid;
            grid-template-columns: auto 1fr;
            gap: 10px;
            align-items: center;
        }

        form label {
            color: #333;
            font-weight: bold;
            text-align: left;
        }

        form input[type="date"],
        form input[type="text"],
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

        form input[type="date"]:focus,
        form input[type="text"]:focus,
        form select:focus {
            outline: none;
            border-color: #2196f3;
            box-shadow: 0 0 5px rgba(33, 150, 243, 0.5);
        }

        form button[type="submit"],
        form a {
            display: inline-block;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease, color 0.3s ease;
            margin-top: 20px;
            font-size: 1em;
        }

        form button[type="submit"] {
            background-color: #4caf50;
            color: white;
            border: none;
            cursor: pointer;
            margin-right: 10px;
        }

        form button[type="submit"]:hover {
            background-color: #43a047;
        }

        form a {
            background-color: #f44336;
            color: white;
        }

        form a:hover {
            background-color: #d32f2f;
        }

        .menu-btn {
            display: block;
            margin: 20px auto 0 auto;
            text-align: center;
            color: white;
            background-color: #6c757d;
            padding: 10px 20px;
            border-radius: 4px;
            text-decoration: none;
            width: fit-content;
            transition: background-color 0.3s ease;
        }

        .menu-btn:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Editar Inspección</h1>
        <hr>

        <form action="actualizar_inspeccion.php" method="post">
            <input type="hidden" name="cod_ins" value="<?php echo $inspeccion['cod_ins']; ?>">

            <div>
                <label for="fecha_ins">Fecha de la Inspección:</label>
                <input type="date" id="fecha_ins" name="fecha_ins" value="<?php echo $inspeccion['fecha_ins']; ?>" required>
            </div>

            <div>
                <label for="cod_inm">Inmueble:</label>
                <select id="cod_inm" name="cod_inm" required>
                    <option value="">Seleccionar Inmueble</option>
                    <?php foreach ($inmuebles as $cod => $direccion): ?>
                        <option value="<?php echo $cod; ?>" <?php if ($inspeccion['cod_inm'] == $cod) echo 'selected'; ?>><?php echo $direccion; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label for="cod_emp">Empleado:</label>
                <select id="cod_emp" name="cod_emp" required>
                    <option value="">Seleccionar Empleado</option>
                    <?php foreach ($empleados as $cod => $nombre): ?>
                        <option value="<?php echo $cod; ?>" <?php if ($inspeccion['cod_emp'] == $cod) echo 'selected'; ?>><?php echo $nombre; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label for="comentario">Comentarios:</label>
                <input type="text" id="comentario" name="comentario" maxlength="255" value="<?php echo $inspeccion['comentario']; ?>">
            </div>

            <div style="grid-column: 1 / -1; display: flex; justify-content: center; gap: 10px; margin-top: 20px;">
                <button type="submit">Guardar Cambios</button>
                <a href="consultar_inspeccion.php">Cancelar</a>
            </div>
        </form>
        <?php
        if (isset($_SESSION['rol_usuario'])) {
            $rolUsuario = $_SESSION['rol_usuario'];
            $urlRedireccion = '';

            switch ($rolUsuario) {
                case 'admin':
                    $urlRedireccion = 'menu_admin.php';
                    break;
                case 'empleado':
                    $urlRedireccion = 'menu_empleado.php';
                    break;
                case 'cliente':
                    $urlRedireccion = 'menu_cliente.php';
                    break;
                default:
                    $urlRedireccion = 'login.php';
                    break;
            }
            echo '<a class="menu-btn" href="' . $urlRedireccion . '">Ir al Menú</a>';
        } else {
            echo '<a class="menu-btn" href="login.php">Ir al Menú</a>';
        }
        ?> 
    </div>
</body>
</html>