<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once 'conexion.php';


if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $cliente_id = $_GET['id'];

    
    $sql = "SELECT * FROM clientes WHERE cod_cli = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $cliente_id);
    $stmt->execute();
    $result = $stmt->get_result();

    
    if ($result->num_rows == 1) {
        $cliente = $result->fetch_assoc();
        echo "";
        echo "<br>";
    } else {
        
        echo "Cliente no encontrado.";
        
    }

    $stmt->close();
} else {
    
    echo "ID de cliente inválido.";
    ;
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente</title>
    <link rel="stylesheet" href="estilos.css"> </head>
<body>
    
    <hr>
    <h1>Editar Cliente</h1>

    <?php if (isset($cliente)): ?>
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
                    echo "";
                    $sql_empleados = "SELECT cod_emp, nom_emp FROM empleados";
                    $result_empleados = $conn->query($sql_empleados);
                    echo "";

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

</body>
</html> 