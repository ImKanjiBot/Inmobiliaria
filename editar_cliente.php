<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'conexion.php';

$cliente = null; // Inicializar $cliente fuera del if

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $cliente_id = $_GET['id'];

    $sql = "SELECT * FROM clientes WHERE cod_cli = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $cliente_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $cliente = $result->fetch_assoc();
    } else {
        echo "<div class='container'>Cliente no encontrado. <a href='consultar_clientes.php'>Volver</a></div>";
        exit();
    }

    $stmt->close();
} else {
    echo "<div class='container'>ID de cliente inválido. <a href='consultar_clientes.php'>Volver</a></div>";
    exit();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente</title>
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
            margin-bottom: 20px;
        }

        form div {
            margin-bottom: 15px;
        }

        form label {
            display: block;
            margin-bottom: 5px;
            color: #333;
            font-weight: bold;
        }

        form input[type="text"],
        form input[type="number"],
        form input[type="tel"],
        form input[type="email"],
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

        form input[type="text"]:focus,
        form input[type="number"]:focus,
        form input[type="tel"]:focus,
        form input[type="email"]:focus,
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
            margin-top: 10px;
        }

        form button[type="submit"] {
            background-color: #2196f3;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 1em;
            margin-right: 10px;
        }

        form button[type="submit"]:hover {
            background-color: #1976d2;
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
        <h1>Editar Cliente</h1>
        <hr>

        <?php if ($cliente): ?>
            <form action="actualizar_cliente.php" method="post">
                <input type="hidden" name="cod_cli" value="<?php echo $cliente['cod_cli']; ?>">

                <div>
                    <label for="nom_cli">Nombre Completo:</label>
                    <input type="text" id="nom_cli" name="nom_cli" value="<?php echo $cliente['nom_cli']; ?>" required>
                </div>

                <div>
                    <label for="doc_cli">Documento:</label>
                    <input type="number" id="doc_cli" name="doc_cli" value="<?php echo $cliente['doc_cli']; ?>">
                </div>

                <div>
                    <label for="tipo_doc_cli">Tipo de Documento:</label>
                    <select id="tipo_doc_cli" name="tipo_doc_cli" required>
                        <option value="">Seleccionar Tipo</option>
                        <option value="TI" <?php if ($cliente['tipo_doc_cli'] == 'TI') echo 'selected'; ?>>Tarjeta de identidad</option>
                        <option value="CC" <?php if ($cliente['tipo_doc_cli'] == 'CC') echo 'selected'; ?>>Cédula de Ciudadanía</option>
                        <option value="CE" <?php if ($cliente['tipo_doc_cli'] == 'CE') echo 'selected'; ?>>Cédula de Extranjería</option>
                    </select>
                </div>

                <div>
                    <label for="dir_cli">Dirección:</label>
                    <input type="text" id="dir_cli" name="dir_cli" value="<?php echo $cliente['dir_cli']; ?>">
                </div>

                <div>
                    <label for="tel_cli">Teléfono:</label>
                    <input type="tel" id="tel_cli" name="tel_cli" value="<?php echo $cliente['tel_cli']; ?>">
                </div>

                <div>
                    <label for="email_cli">Email:</label>
                    <input type="email" id="email_cli" name="email_cli" value="<?php echo $cliente['email_cli']; ?>">
                </div>

                <div>
                    <label for="cod_tipoinm">Tipo de Inmueble (Código):</label>
                    <input type="number" id="cod_tipoinm" name="cod_tipoinm" value="<?php echo $cliente['cod_tipoinm']; ?>">
                </div>

                <div>
                    <label for="valor_maximo">Valor Máximo a Pagar:</label>
                    <input type="number" id="valor_maximo" name="valor_maximo" value="<?php echo $cliente['valor_maximo']; ?>">
                </div>

                <div>
                    <label for="notas_cliente">Notas:</label>
                    <textarea id="notas_cliente" name="notas_cliente"><?php echo $cliente['notas_cliente']; ?></textarea>
                </div>

                <div>
                    <label for="cod_emp">Empleado de Gestión:</label>
                    <select id="cod_emp" name="cod_emp" required>
                        <option value="">Seleccionar Empleado</option>
                        <?php
                        $sql_empleados = "SELECT cod_emp, nom_emp FROM empleados";
                        $result_empleados = $conn->query($sql_empleados);

                        if ($result_empleados && $result_empleados->num_rows > 0) {
                            while ($row_empleado = $result_empleados->fetch_assoc()) {
                                $selected = ($cliente['cod_emp'] == $row_empleado['cod_emp']) ? 'selected' : '';
                                echo '<option value="' . $row_empleado["cod_emp"] . '" ' . $selected . '>' . $row_empleado["nom_emp"] . '</option>';
                            }
                            $result_empleados->free();
                        }
                        ?>
                    </select>
                </div>

                <div>
                    <button type="submit">Guardar Cambios</button>
                    <a href="consultar_clientes.php">Cancelar</a>
                </div>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>