<?php
include('conexion.php');

if (isset($_GET['cod_cargo'])) {
    $cod_cargo = $_GET['cod_cargo'];
    $sql = "DELETE FROM cargos WHERE cod_cargo = $cod_cargo";
    mysqli_query($conexion, $sql);
}

header("Location: consultar_cargos.php");
exit;
