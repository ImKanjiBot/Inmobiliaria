<?php
include 'conexion.php';

// Verifica si se recibió el número de documento
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cod_propietario']) && is_numeric($_POST['cod_propietario'])) {
    $cod_propietario = intval($_POST['cod_propietario']); 

    // Preparar la consulta para eliminar
    $sql = "DELETE FROM propietarios WHERE cod_propietario = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $cod_propietario);

        if ($stmt->execute()) {
            // Redirige de vuelta al listado si la eliminación fue exitosa
            header("Location: consultar_propietario.php");
            exit();
        } else {
            echo "Error al eliminar el propietario: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error al preparar la consulta: " . $conn->error;
    }
} else {
    echo "No se recibió el número de documento.";
}

$conn->close();
?>
