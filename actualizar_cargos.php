<?php
include('conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cod_cargo = $_POST['cod_cargo'];
    $nom_cargo = $_POST['nom_cargo'];

    $sql = "UPDATE cargos SET nom_cargo = '$nom_cargo' WHERE cod_cargo = ?";
    mysqli_query($conexion, $sql);

    header("Location: consultar_cargos.php");
    exit;
}
?>