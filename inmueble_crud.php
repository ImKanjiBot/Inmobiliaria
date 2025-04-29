<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Inmuebles</title>
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
    <h2>Registro de inmueble</h2>
    <form action="guardar_inmueble.php" method="post" enctype="multipart/form-data">
        <label for="nombre">Dirección del Inmueble:</label>
        <input type="text" id="direccion" name="direccion" required />

        <label for="direccion">Departamento:</label>
        <input type="text" id="departamento" name="departamento" required />

        <label for="direccion">Ciudad:</label>
        <input type="text" id="ciudad" name="ciudad" required />

        <label for="direccion">Barrio:</label>
        <input type="text" id="barrio" name="barrio" required />

        <label>Ubicación (Latitud y Longitud):</label>
        <input type="text" id="latitud" name="latitud" readonly />
        <input type="text" id="longitud" name="longitud" readonly />

        <div id="map"></div>

        <label for="foto">Foto del Inmueble:</label>
        <input type="file" id="foto" name="foto" accept="image/*" />

        <label for="direccion">web 1:</label>
        <input type="text" id="web_p1" name="web_p1" required />

        <label for="direccion">web 2:</label>
        <input type="text" id="web_p2" name="web_p2" required />

        <select name="id_categoria" required>
            <option value="">Seleccione un tipo de inmueble</option>
        <?php

        include 'conexion.php';

        //Obtener todos los productos
            $sql = "SELECT t.cod_tipoinm, t.nom_tipoinm
            FROM tipo_inmueble t
            JOIN inmuebles i ON t.cod_tipoinm = i.cod_tipoinm";
            $result = $conn->query($sql);

        $sqlCat = "SELECT cod_tipoinm, nom_tipoinm FROM tipo_inmueble";
        $resultCat = $conn->query($sqlCat);
        while ($rowCat = $resultCat->fetch_assoc()){
            echo "<option value='".$rowCat['cod_tipoinm']."'>".$rowCat['nom_tipoinm']."</option>";
        }
        ?>

        <button type="submit">Guardar Inmueble</button>

    </form>

    <button onclick="window.location.href='consultar_inmueble.php' ">Consultar Inmueble</button>

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