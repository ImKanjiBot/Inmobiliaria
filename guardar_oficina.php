<?php

include 'conexion.php';

//Obtener datos
$nombre = $_POST['nom_ofi'];
$direccion = $_POST['dir_ofi'];
$telefono = $_POST['tel_ofi'];
$email = $_POST['email_ofi'];
$latitud = $_POST['latitud'];
$longitud = $_POST['longitud'];

//Manejo de foto
$foto = null;
if (!empty($_FILES['foto_ofi']['name'])) {
    $foto = "uploads/" . basename($_FILES['foto_ofi']['name']);
    move_uploaded_file($_FILES['foto_ofi']['tmp_name'], $foto);
}

// Insertar en la base de datos
$sql = "INSERT INTO oficinas (nom_ofi, dir_ofi, tel_ofi, email_ofi, latitud, longitud, foto_ofi) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssdds", $nombre, $direccion, $telefono, $email, $latitud, $longitud, $foto);

if ($stmt->execute()) {
    echo "Oficina registrada con éxito. ";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>