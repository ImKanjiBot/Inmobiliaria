<?php
require_once 'conexion.php';
session_start();
if (!isset($_SESSION['rol_usuario'])) {
    // Si no ha iniciado sesión, redirige a login.php
    header("Location: login.php");
    exit();
    }

// Consultar la tabla de clientes para el desplegable
$sql_clientes = "SELECT cod_cli, nom_cli FROM clientes";
$resultado_clientes = $conn->query($sql_clientes);
$clientes = [];
if ($resultado_clientes->num_rows > 0) {
    while ($fila = $resultado_clientes->fetch_assoc()) {
        $clientes[$fila['cod_cli']] = $fila['nom_cli'];
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Nuevo Contrato</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Estilos específicos para el formulario de registro de contratos */
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
            margin-bottom: 20px;
            display: grid;
            grid-template-columns: auto;
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
        form input[type="number"],
        form input[type="decimal"], /* Aunque no existe el type="decimal", lo dejamos por claridad */
        form input[type="text"],
        form input[type="file"],
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
        form input[type="number"]:focus,
        form input[type="decimal"]:focus,
        form input[type="text"]:focus,
        form input[type="file"]:focus,
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
    </style>
</head>
<body>
    <div class="container">
        <h1>Registrar Nuevo Contrato</h1>
        <hr>

        <form action="guardar_contrato.php" method="post" enctype="multipart/form-data">
            <div>
                <label for="cod_cli">Cliente:</label>
                <select id="cod_cli" name="cod_cli" required>
                    <option value="">Seleccionar Cliente</option>
                    <?php foreach ($clientes as $cod => $nombre): ?>
                        <option value="<?php echo $cod; ?>"><?php echo $nombre; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label for="fecha_con">Fecha del Contrato:</label>
                <input type="date" id="fecha_con" name="fecha_con" required>
            </div>

            <div>
                <label for="fecha_ini">Fecha de Inicio:</label>
                <input type="date" id="fecha_ini" name="fecha_ini" required>
            </div>

            <div>
                <label for="fecha_fin">Fecha de Finalización:</label>
                <input type="date" id="fecha_fin" name="fecha_fin">
            </div>

            <div>
                <label for="meses">Duración (Meses):</label>
                <input type="number" id="meses" name="meses" min="1">
            </div>

            <div>
                <label for="valor_con">Valor del Contrato:</label>
                <input type="text" id="valor_con" name="valor_con" min="0" required>
            </div>

            <div>
                <label for="deposito_con">Depósito:</label>
                <input type="text" id="deposito_con" name="deposito_con" min="0">
            </div>

            <div>
                <label for="metodo_pago_con">Método de Pago:</label>
                <select id="metodo_pago_con" name="metodo_pago_con">
                    <option value="">Seleccionar Método</option>
                    <option value="transferencia">Transferencia</option>
                    <option value="efectivo">Efectivo</option>
                </select>
            </div>

            <div>
                <label for="dato_pago">Dato de Pago (Ref.):</label>
                <input type="text" id="dato_pago" name="dato_pago" maxlength="20">
            </div>

            <div>
                <label for="archivo_con">Archivo del Contrato:</label>
                <input type="file" id="archivo_con" name="archivo_con">
            </div>

            <div style="grid-column: 1 / -1; display: flex; justify-content: center; gap: 10px; margin-top: 20px;">
                <button type="submit">Guardar Contrato</button>
                <a href="consultar_contratos.php">Consultar Datos</a>
            </div>
        </form>

        <?php

        // Verificar si la variable de sesión 'rol_usuario' existe
        if (isset($_SESSION['rol_usuario'])) {
            $rolUsuario = $_SESSION['rol_usuario'];
            $urlRedireccion = '';

            // Determinar la URL de redirección según el rol
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
                    // Si el rol no coincide con ninguno conocido, podrías redirigir a una página por defecto o mostrar un mensaje de error.
                    $urlRedireccion = 'login.php'; // Ejemplo de página por defecto
                    break;
            }

            // Generar el enlace "Volver" dinámicamente
            echo '<a href="' . $urlRedireccion . '">Menu</a>';

        } else {
            // Si la variable de sesión 'rol_usuario' no está definida (por alguna razón),
            // podrías redirigir a una página de inicio de sesión o a una página por defecto.
            echo '<a href="login.php">Menu</a>'; // Ejemplo: Volver a la página de inicio de sesión
        }
        ?>
    </div>
</body>
</html>