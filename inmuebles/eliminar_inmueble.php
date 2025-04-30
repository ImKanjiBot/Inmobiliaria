<?php
include '../conexion.php';

// Verificar si se recibio el ID del proveedor y si es un numero valido
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cod_inm']) && is_numeric($_POST['cod_inm'])) {
    $cod_inm = intval($_POST['cod_inm']); //Convertir a entero para seguridad

    //Eliminar el proveedor
    $sql = "DELETE FROM inmuebles WHERE cod_inm = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $cod_inm);
        if ($stmt->execute()) {
            echo "<script>alert('Inmueble eliminado correctamente. '); window.location.href='../eliminar_inmueble.php';</script>";
        } else {
            echo "Error al eliminar el inmueble: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error en la consulta de eliminacion: " . $conn->error;
    }
} else {
    echo "<script>alert('Error: No se proporciono un ID de inmueble valido. '); window.location.href='../eliminar_inmueble.php';</script>";
}

$conn->close();
?>