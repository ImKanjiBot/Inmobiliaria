<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Nuevo Cliente</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <h1>Crear Nuevo Cliente</h1>
    <form action="crear_clientes.php" method="post">

        <div>
        <div>
    <label for="cod_emp">Empleado de Gestión:</label>
    <select id="cod_emp" name="cod_emp" required>
        <option value="">Seleccionar Empleado</option>
        <?php
        require_once 'conexion.php'; 
        $sql_empleados = "SELECT cod_emp, nom_emp FROM empleados";
        $result_empleados = $conn->query($sql_empleados);

        if ($result_empleados->num_rows > 0) {
            while ($row_empleado = $result_empleados->fetch_assoc()) {
                echo '<option value="' . $row_empleado["cod_emp"] . '">' . $row_empleado["nom_emp"] . '</option>';
            }
        }
        ?>
    </select>
</div>


        
        
        <div>
            <label for="nom_cli">Nombre Completo:</label>
            <input type="text" id="nom_cli" name="nom_cli" required>
        </div>
        <div>
            <label for="doc_cli">Documento:</label>
            <input type="text" id="doc_cli" name="doc_cli">
        </div>
        <div>
            <label for="tipo_doc_cli">Tipo de Documento:</label>
            <select id="tipo_doc_cli" name="tipo_doc_cli">
                <option value="TI">Tarjeta de Identidad</option>
                <option value="CC">Cédula de Ciudadanía</option>
                <option value="CE">Cédula de Extranjería</option>
            </select>
        </div>
        <div>
            <label for="dir_cli">Dirección:</label>
            <input type="text" id="dir_cli" name="dir_cli">
        </div>
        <div>
            <label for="tel_cli">Teléfono:</label>
            <input type="tel" id="tel_cli" name="tel_cli">
        </div>
        <div>
            <label for="email_cli">Email:</label>
            <input type="email" id="email_cli" name="email_cli">
        </div>
        <div>
            <label for="nom_tipoinm">Tipo de Inmueble Interés:</label>
            <div style="display: flex; align-items: center;">
                <select name="nom_tipoinm" id="nom_tipoinm">
                    <option value="Urbano">Urbano</option>
                    <option value="Rural">Rural</option>
                </select>
                
            </div>
        </div>
        <div>
            <label for="valor_maximo">Valor Máximo a Pagar:</label>
            <input type="text" id="valor_maximo" name="valor_maximo" min="0">
        </div>
        <div>
            <label for="notas_cliente">Notas Adicionales:</label>
            <textarea id="notas_cliente" name="notas_cliente"></textarea>
        </div>
        <button type="submit">Guardar Cliente</button>
    </form>

    <script>
        document.getElementById('cod_tipoinm').addEventListener('input', function() {
            const codTipoInm = this.value;
            const nombreTipoInmInput = document.getElementById('nom_tipoinm_mostrar');

            if (codTipoInm) {
                fetch(`obtener_tipo_inmueble.php?cod_tipoinm=${codTipoInm}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.nom_tipoinm) {
                            nombreTipoInmInput.value = data.nom_tipoinm;
                        } else {
                            nombreTipoInmInput.value = 'Tipo de inmueble no encontrado';
                        }
                    })
                    .catch(error => {
                        console.error('Error al obtener el tipo de inmueble:', error);
                        nombreTipoInmInput.value = 'Error al buscar';
                    });
            } else {
                nombreTipoInmInput.value = '';
            }
        });
    </script>
</body>

</html>