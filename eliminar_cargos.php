<?php
include('conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cod_cargo = $_POST['cod_cargo'];

    $stmt = $conn->prepare("DELETE FROM cargos WHERE cod_cargo = ?");
    $stmt->bind_param("i", $cod_cargo);
    $stmt->execute();
    $stmt->close();

    header("Location: consultar_cargos.php");
    exit;
}
?>
