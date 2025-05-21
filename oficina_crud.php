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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Oficina</title>
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
            gap: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
            font-weight: bold;
            text-align: left;
        }

        input[type="text"],
        input[type="email"],
        input[type="file"] {
            width: calc(100% - 12px);
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 1em;
        }

        input[type="text"]:read-only {
            background-color: #eee;
            cursor: not-allowed;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="file"]:focus {
            outline: none;
            border-color: #2196f3;
            box-shadow: 0 0 5px rgba(33, 150, 243, 0.5);
        }

        #map {
            height: 300px; /* Reduje un poco la altura para el diseño */
            width: 100%;
            border-radius: 4px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.3);
        }

        button[type="submit"],
        button:not([type="submit"]) {
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
    </style>
</head>
<body>
    <div class="container">
        <h2>Registro de Oficina</h2>
        <hr>
        <form action="guardar_oficina.php" method="post" enctype="multipart/form-data">
            <label for="nom_ofi">Nombre de la Oficina:</label>
            <input type="text" id="nom_ofi" name="nom_ofi" required />

            <label for="dir_ofi">Dirección:</label>
            <input type="text" id="dir_ofi" name="dir_ofi" required />

            <label for="tel_ofi">Teléfono:</label>
            <input type="text" id="tel_ofi" name="tel_ofi" required>

            <label for="email_ofi">Email:</label>
            <input type="email" id="email_ofi" name="email_ofi" required>

            <label>Ubicación (Latitud y Longitud):</label>
            <input type="text" id="latitud" name="latitud" readonly />
            <input type="text" id="longitud" name="longitud" readonly />

            <div id="map"></div>

            <label for="foto_ofi">Foto de la Oficina:</label>
            <input type="file" id="foto_ofi" name="foto_ofi" accept="image/*" />

            <button type="submit">Guardar Oficina</button>

        </form>

        <button onclick="window.location.href='consultar_oficina.php' ">Consultar Oficina</button>
    </div>

    <script>
        //Inicializar el mapa
        const map = L.map('map').setView([4.6097, -74.0817], 13); //Coordenadas de Bogota, Colombia

        //Agregar capa de OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        //Agregar marcador
        const marker = L.marker([4.6097, -74.0817], { draggable: true }).addTo(map);

        //Actualizar campos de latitud y longitud
        function updateLatLng() {
            const position = marker.getLatLng();
            document.getElementById('latitud').value = position.lat.toFixed(6);
            document.getElementById('longitud').value = position.lng.toFixed(6);
        }
        updateLatLng();

        marker.on('dragend', updateLatLng);

        //Obtener ubicacion del usuario
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