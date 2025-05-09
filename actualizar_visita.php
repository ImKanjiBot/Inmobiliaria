<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'conexion.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $cod_vis = $_POST['cod_vis'];
    $fecha_vis = $_POST['fecha_vis'];
    $cod_cli = $_POST['cod_cli'];
    $cod_emp = $_POST['cod_emp'];
    $cod_inm = $_POST['cod_inm'];
    $comenta_vis = $_POST['comenta_vis'];

    $sql = "UPDATE visitas SET
            fecha_vis = ?,
            cod_cli = ?,
            cod_emp = ?,
            cod_inm = ?,
            comenta_vis = ?
            WHERE cod_vis = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siissi", $fecha_vis, $cod_cli, $cod_emp, $cod_inm, $comenta_vis, $cod_vis);

    if ($stmt->execute()) {
        $_SESSION['mensaje'] = "Visita actualizada éxitosamente.";
        header("Location: consultar_visitas.php");
        exit();
    } else {
        echo "Error no se puede actualizar la visita: " . $stmt->error;
    }

    $stmt->close();

} else {
    echo "Acceso Denegado.";
}

$conn->close();
?>