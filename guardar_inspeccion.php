<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'conexion.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recibir los datos del formulario
    $fecha_ins = $_POST['fecha_ins'];
    $cod_inm = $_POST['cod_inm'];
    $cod_emp = $_POST['cod_emp'];
    $comentario = $_POST['comentario'];

    // Preparar la consulta SQL para la inserción
    $sql = "INSERT INTO inspeccion (fecha_ins, cod_inm, cod_emp, comentario)
            VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siis", $fecha_ins, $cod_inm, $cod_emp, $comentario);

    if ($stmt->execute()) {
        $_SESSION['mensaje'] = "Inspección registrada con éxito.";
        header("Location: consultar_inspecciones.php");
        exit();
    } else {
        echo "Error al guardar la inspección: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Acceso no permitido.";
}

$conn->close();
?>