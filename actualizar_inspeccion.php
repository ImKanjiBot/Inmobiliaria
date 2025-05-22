<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'conexion.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $cod_ins = $_POST['cod_ins'];
    $fecha_ins = $_POST['fecha_ins'];
    $cod_inm = $_POST['cod_inm'];
    $cod_emp = $_POST['cod_emp'];
    $comentario = $_POST['comentario'];

    $sql = "UPDATE inspeccion SET
            fecha_ins = ?,
            cod_inm = ?,
            cod_emp = ?,
            comentario = ?
            WHERE cod_ins = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siisi", $fecha_ins, $cod_inm, $cod_emp, $comentario, $cod_ins);

    if ($stmt->execute()) {
        $_SESSION['mensaje'] = "Inspección actualizada éxitosamente.";
        header("Location: consultar_inspeccion.php");
        exit();
    } else {
        echo "Error no se pudo actualizar la inspección: " . $stmt->error;
    }

    $stmt->close();

} else {
    echo "Acceso Denegado.";
}

$conn->close();
?>