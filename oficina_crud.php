<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Oficina</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <style>
        #map { height: 400px; width: 100%; }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        label { display: block; margin-top: 10px;}
        input, select, button { width: 100%; padding: 10px; margin-top: 5px; }
    </style>
</head>
<body>
    <h2>Registro de Oficina</h2>
    <form action="guardar_oficina.php" method="post" enctype="multipart/form-data">
        <label for="nombre">Nombre de la Oficina:</label>
        <input type="text" id="nom_ofi" name="nom_ofi" required />

        <label for="direccion">Dirección:</label>
        <input type="text" id="dir_ofi" name="dir_ofi" required />

        <label for="telefono">Teléfono:</label>
        <input type="text" id="tel_ofi" name="tel_ofi" required>

        <label for="email">Email:</label>
        <input type="email" id="email_ofi" name="email_ofi" required>

        <label>Ubicación (Latitud y Longitud):</label>
        <input type="text" id="latitud" name="latitud" readonly />
        <input type="text" id="longitud" name="longitud" readonly />

        <div id="map"></div>

        <label for="foto">Foto de la Oficina:</label>
        <input type="file" id="foto_ofi" name="foto_ofi" accept="image/*" />

        <button type="submit">Guardar Oficina</button>

    </form>

    <button onclick="window.location.href='consultar_oficina.php' ">Consultar Oficina</button>

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