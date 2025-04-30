<?php
include 'conexion.php';

// Obtener datos del formulario
$cod_ofi = $_POST['cod_ofi'];
$nom_ofi = $_POST['nom_ofi'];
$dir_ofi = $_POST['dir_ofi'];
$tel_ofi = $_POST['tel_ofi'];
$email_ofi = $_POST['email_ofi'];
$foto_ofi = $_POST['foto_ofi'];

// Actualizar los datos de la oficina en la base de datos
$sql = "UPDATE oficinas SET 
    nom_ofi = ?, 
    dir_ofi = ?, 
    tel_ofi = ?, 
    email_ofi = ?, 
    foto_ofi = ? 
    WHERE cod_ofi = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssi", $nom_ofi, $dir_ofi, $tel_ofi, $email_ofi, $foto_ofi, $cod_ofi);

if ($stmt->execute()) {
    echo "<script>alert('Oficina actualizada correctamente.'); window.location.href='oficina_crud.php';</script>";
} else {
    echo "Error al actualizar la oficina: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
