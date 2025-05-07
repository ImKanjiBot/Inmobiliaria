<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'conexion.php';
session_start();

if (isset($_POST['cod_vis']) && is_numeric($_POST['cod_vis'])) {
    $cod_ins = $_POST['cod_vis'];

    // Preparar la consulta SQL para la eliminación
    $sql = "DELETE FROM visitas WHERE cod_vis = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $cod_ins);

    if ($stmt->execute()) {
        $_SESSION['mensaje'] = "Visita eliminada con éxito.";
        header("Location: consultar_visitas.php");
        exit();
    } else {
        echo "Error al eliminar la inspección: " . $stmt->error;
    }

    $stmt->close();

} else {
    $_SESSION['mensaje'] = "ID de inspección no válido.";
    header("Location: consultar_visitas.php");
    exit();
}

$conn->close();
?>