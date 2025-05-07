<?php
include 'conexion.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Nuevo Cliente</title>
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
        form input[type="tel"]:focus,
        form input[type="email"]:focus,
        form select:focus,
        form textarea:focus {
            outline: none;
            border-color: #2196f3;
            box-shadow: 0 0 5px rgba(33, 150, 243, 0.5);
        }

        form button[type="submit"] {
            background-color: #2196f3;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s ease;
        }

        form button[type="submit"]:hover {
            background-color: #1976d2;
        }

        #nom_tipoinm_mostrar {
            width: calc(100% - 12px);
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 1em;
            background-color: #eee; /* Estilo para campo no editable */
            color: #777;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Crear Nuevo Cliente</h1>
        <form action="crear_clientes.php" method="post">

            <div>
                <label>Empleado de Gestión:</label>
                <select id="cod_emp" name="cod_emp" required>
                    <option value="">Seleccionar Empleado</option>
                    <?php    
                //Obtener codigo del empleado
                $sqlCat = "SELECT * FROM empleados";
                $resultCat = $conn->query($sqlCat);
                while ($rowCat = $resultCat->fetch_assoc()){
                    echo "<option value='".$rowCat['cod_emp']."'>".$rowCat['nom_emp']."</option>";
                }
                ?>
            </select><br>
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
                <label>Tipo de Inmueble Interés:</label>
                <div style="display: flex; align-items: center;">
                <select name="cod_tipoinm" required>
                <option value="">Seleccione un tipo de inmueble</option>
            <?php
                // Obtener tipos de inmueble
                $sqlCat = "SELECT cod_tipoinm, nom_tipoinm FROM tipo_inmueble";
                $resultCat = $conn->query($sqlCat);
                while ($rowCat = $resultCat->fetch_assoc()){
                    echo "<option value='".$rowCat['cod_tipoinm']."'>".$rowCat['nom_tipoinm']."</option>";
                }
            ?>
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
        <p><a href="consultar_clientes.php">Volver</a></p>
    </div>


</body>

</html>