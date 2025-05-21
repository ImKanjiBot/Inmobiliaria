<?php
include '../conexion.php';
session_start();
if (!isset($_SESSION['rol_usuario'])) {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Inmuebles</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
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

        #map {
            height: 300px;
            width: 100%;
            border-radius: 4px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.3);
            grid-column: 1 / -1;
        }

        button[type="submit"],
        button:not([type="submit"]),
        .menu-btn {
            display: block;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease, color 0.3s ease;
            margin-top: 20px;
            font-size: 1em;
            text-align: center;
            border: none;
            cursor: pointer;
            width: 100%;
        }

        button[type="submit"] {
            background-color: #4caf50;
            color: white;
            grid-column: 1 / -1;
        }

        button[type="submit"]:hover {
            background-color: #43a047;
        }

        button:not([type="submit"]) {
            background-color: #007bff;
            color: white;
        }

        button:not([type="submit"]):hover {
            background-color: #0056b3;
        }

        .menu-btn {
            background-color: #6c757d;
        }

        .menu-btn:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Registro de inmueble</h2>
        <hr>
        <form action="guardar_inmueble.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="cod_inmueble" value="<?php echo $cod_inmueble; ?>">

            <label for="dir_inm">Dirección del Inmueble:</label>
            <input type="text" id="dir_inm" name="dir_inm" required />

            <label for="barrio_inm">Barrio:</label>
            <input type="text" id="barrio_inm" name="barrio_inm" required />

            <label for="ciudad_inm">Ciudad:</label>
            <input type="text" id="ciudad_inm" name="ciudad_inm" required />

            <label for="departamento_inm">Departamento:</label>
            <input type="text" id="departamento_inm" name="departamento_inm" required />

            <label>Ubicación (Latitud y Longitud):</label>
            <input type="text" id="latitud" name="latitud" readonly />
            <input type="text" id="longitud" name="longitud" readonly />

            <div id="map"></div>

            <label for="foto">Foto del Inmueble:</label>
            <input type="file" id="foto" name="foto" />

            <label for="web_p1">web 1:</label>
            <input type="text" id="web_p1" name="web_p1" required />

            <label for="web_p2">web 2:</label>
            <input type="text" id="web_p2" name="web_p2" required />

            <label for="cod_tipoinm">Tipo de inmueble:</label>
            <select name="cod_tipoinm" id="cod_tipoinm" required>
                <option value="">Seleccione un tipo de inmueble</option>
                <?php
                // Obtener tipos de inmueble
                $sqlTipoInm = "SELECT cod_tipoinm, nom_tipoinm FROM tipo_inmueble";
                $resultTipoInm = $conn->query($sqlTipoInm);
                while ($rowTipoInm = $resultTipoInm->fetch_assoc()){
                    echo "<option value='".$rowTipoInm['cod_tipoinm']."'>".$rowTipoInm['nom_tipoinm']."</option>";
                }
                ?>
            </select>

            <label for="num_hab">Número de habitaciones:</label>
            <input type="text" id="num_hab" name="num_hab" required />

            <label for="precio_alq">Precio mensual del alquiler:</label>
            <input type="text" id="precio_alq" name="precio_alq" required />

            <label for="cod_propietario">Nombre del propietario:</label>
            <select name="cod_propietario" id="cod_propietario" required>
                <option value="">Seleccione el código del propietario</option>
                <?php
                //Obtener codigo del propietario
                $sqlPropietario = "SELECT cod_propietario, nombre_propietario FROM propietarios";
                $resultPropietario = $conn->query($sqlPropietario);
                while ($rowPropietario = $resultPropietario->fetch_assoc()){
                    echo "<option value='".$rowPropietario['cod_propietario']."'>".$rowPropietario['nombre_propietario']."</option>";
                }
                ?>
            </select>

            <label for="caracteristica_inm">Características del inmueble:</label>
            <select name="caracteristica_inm" id="caracteristica_inm" required>
                <option value="conjunto">Conjunto</option>
                <option value="urbanizacion">Urbanización</option>
            </select>

            <label for="notas_inm">Notas del Inmueble:</label>
            <textarea name="notas_inm" id="notas_inm"></textarea>

            <label for="cod_emp">Nombre del empleado:</label>
            <select name="cod_emp" id="cod_emp" required>
                <option value="">Seleccione el código del empleado</option>
                <?php
                //Obtener codigo del empleado
                $sqlEmpleado = "SELECT cod_emp, nom_emp FROM empleados";
                $resultEmpleado = $conn->query($sqlEmpleado);
                while ($rowEmpleado = $resultEmpleado->fetch_assoc()){
                    echo "<option value='".$rowEmpleado['cod_emp']."'>".$rowEmpleado['nom_emp']."</option>";
                }
                ?>
            </select>

            <label for="cod_ofi">Código de la Oficina:</label>
            <select name="cod_ofi" id="cod_ofi" required>
                <option value="">Seleccione el código de la oficina</option>
                <?php
                //Obtener codigo dela oficina
                $sqlOficina = "SELECT cod_ofi, nom_ofi FROM oficinas";
                $resultOficina = $conn->query($sqlOficina);
                while ($rowOficina = $resultOficina->fetch_assoc()){
                    echo "<option value='".$rowOficina['cod_ofi']."'>".$rowOficina['nom_ofi']."</option>";
                }
                ?>
            </select>

            <button type="submit">Guardar Inmueble</button>

        </form>

        <button onclick="window.location.href='consultar_inmueble.php'">Consultar Inmueble</button>

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

    <script>
        const map = L.map('map').setView([4.6097, -74.0817], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        const marker = L.marker([4.6097, -74.0817], { draggable: true }).addTo(map);

        function updateLatLng() {
            const position = marker.getLatLng();
            document.getElementById('latitud').value = position.lat.toFixed(6);
            document.getElementById('longitud').value = position.lng.toFixed(6);
        }
        updateLatLng();

        marker.on('dragend', updateLatLng);

        if (navigator.geolocation){
            navigator.geolocation.getCurrentPosition((position) => {
                const { latitude, longitude } = position.coords;
                marker.setLatLng([ latitude, longitude]);
                map.setView([latitude, longitude], 13);
                updateLatLng();
            });
        }
    </script>
</body>
</html>
