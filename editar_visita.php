<?php
// Incluir el archivo de conexión a la base de datos
require_once 'conexion.php';

// Verificar si se recibió el ID de la visita a editar
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $cod_vis = $_GET['id'];

    // Consultar la visita específica y las tablas relacionadas
    $sql = "SELECT
        v.cod_vis,
        v.fecha_vis,
        v.cod_cli,
        c.nom_cli AS nombre_cliente,
        v.cod_emp,
        e.nom_emp AS nombre_empleado,
        v.cod_inm,
        i.dir_inm AS direccion_inmueble,
        v.comenta_vis
    FROM visitas v
    JOIN clientes c ON v.cod_cli = c.cod_cli
    JOIN empleados e ON v.cod_emp = e.cod_emp
    JOIN inmuebles i ON v.cod_inm = i.cod_inm
    WHERE v.cod_vis = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $cod_vis);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows == 1) {
        $visita = $resultado->fetch_assoc();

        // Consultar todas las clientes para el desplegable
        $sql_clientes = "SELECT cod_cli, nom_cli FROM clientes";
        $resultado_clientes = $conn->query($sql_clientes);
        $clientes = [];
        if ($resultado_clientes->num_rows > 0) {
            while ($fila = $resultado_clientes->fetch_assoc()) {
                $clientes[$fila['cod_cli']] = $fila['nom_cli'];
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

        // Consultar todos los inmuebles para el desplegable
        $sql_inmuebles = "SELECT cod_inm, dir_inm FROM inmuebles";
        $resultado_inmuebles = $conn->query($sql_inmuebles);
        $inmuebles = [];
        if ($resultado_inmuebles->num_rows > 0) {
            while ($fila = $resultado_inmuebles->fetch_assoc()) {
                $inmuebles[$fila['cod_inm']] = $fila['dir_inm'];
            }
        }

    } else {
        $_SESSION['mensaje'] = "Visita no encontrada.";
        header("Location: consultar_visitas.php");
        exit();
    }

    $stmt->close();

} else {
    $_SESSION['mensaje'] = "ID de visita no válido.";
    header("Location: consultar_visitas.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Visita</title>
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
        form select,
        form textarea {
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

        form textarea {
            resize: vertical; /* Permite al usuario redimensionar verticalmente */
            min-height: 100px;
        }

        form input[type="date"]:focus,
        form select:focus,
        form textarea:focus {
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
    </style>
</head>
<body>
    <div class="container">
        <h1>Editar Visita</h1>
        <hr>

        <form action="actualizar_visita.php" method="post">
            <input type="hidden" name="cod_vis" value="<?php echo $visita['cod_vis']; ?>">

            <div>
                <label for="fecha_vis">Fecha de la Visita:</label>
                <input type="date" id="fecha_vis" name="fecha_vis" value="<?php echo $visita['fecha_vis']; ?>" required>
            </div>

            <div>
                <label for="cod_cli">Cliente:</label>
                <select id="cod_cli" name="cod_cli" required>
                    <option value="">Seleccionar Cliente</option>
                    <?php foreach ($clientes as $cod => $nombre): ?>
                        <option value="<?php echo $cod; ?>" <?php if ($visita['cod_cli'] == $cod) echo 'selected'; ?>><?php echo $nombre; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label for="cod_emp">Empleado:</label>
                <select id="cod_emp" name="cod_emp" required>
                    <option value="">Seleccionar Empleado</option>
                    <?php foreach ($empleados as $cod => $nombre): ?>
                        <option value="<?php echo $cod; ?>" <?php if ($visita['cod_emp'] == $cod) echo 'selected'; ?>><?php echo $nombre; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label for="cod_inm">Inmueble:</label>
                <select id="cod_inm" name="cod_inm" required>
                    <option value="">Seleccionar Inmueble</option>
                    <?php foreach ($inmuebles as $cod => $direccion): ?>
                        <option value="<?php echo $cod; ?>" <?php if ($visita['cod_inm'] == $cod) echo 'selected'; ?>><?php echo $direccion; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label for="comenta_vis">Comentarios:</label>
                <textarea id="comenta_vis" name="comenta_vis" rows="4" cols="50"><?php echo $visita['comenta_vis']; ?></textarea>
            </div>

            <div style="grid-column: 1 / -1; display: flex; justify-content: center; gap: 10px; margin-top: 20px;">
                <button type="submit">Guardar Cambios</button>
                <a href="consultar_visitas.php">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>