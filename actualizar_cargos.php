<?php
include('conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cod_cargo = $_POST['cod_cargo'];
    $nom_cargo = $_POST['nom_cargo'];

    $stmt = $conn->prepare("UPDATE cargos SET nom_cargo = ? WHERE cod_cargo = ?");
    $stmt->bind_param("si", $nom_cargo, $cod_cargo);
    $stmt->execute();
    $stmt->close();

    header("Location: consultar_cargos.php");
    exit;
}
?>
