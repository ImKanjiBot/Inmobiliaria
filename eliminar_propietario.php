<?php
include 'conexion.php';

// Verifica si se recibió el número de documento
if (isset($_POST['num_doc'])) {
    $num_doc = $_POST['num_doc'];

    // Preparar la consulta para eliminar
    $sql = "DELETE FROM propietarios WHERE num_doc = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $num_doc);

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
