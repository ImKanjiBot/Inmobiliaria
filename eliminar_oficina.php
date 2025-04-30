<?php
include 'conexion.php';

// Verificar si se recibió el ID de la oficina y si es un número válido
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cod_ofi']) && is_numeric($_POST['cod_ofi'])) {
    $cod_ofi = intval($_POST['cod_ofi']); // Convertir a entero para seguridad

    // Verificar si la oficina tiene empleados asociados (ejemplo de relación)
    $sql_check = "SELECT COUNT(*) as total FROM empleados WHERE cod_ofi = ?";
    $stmt_check = $conn->prepare($sql_check);

    if ($stmt_check) {
        $stmt_check->bind_param("i", $cod_ofi);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
        $row_check = $result_check->fetch_assoc();
        $stmt_check->close();

        if ($row_check['total'] > 0) {
            die("<script>alert('No se puede eliminar la oficina porque tiene empleados asociados.'); window.location.href='consultar_oficina.php';</script>");
        }
    } else {
        die("Error en la consulta de verificación: " . $conn->error);
    }

    // Eliminar la oficina
    $sql = "DELETE FROM oficinas WHERE cod_ofi = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $cod_ofi);
        if ($stmt->execute()) {
            echo "<script>alert('Oficina eliminada correctamente.'); window.location.href='consultar_oficina.php';</script>";
        } else {
            echo "Error al eliminar la oficina: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error en la consulta de eliminación: " . $conn->error;
    }
} else {
    echo "<script>alert('Error: No se proporcionó un ID de oficina válido.'); window.location.href='consultar_oficina.php';</script>";
}

$conn->close();
?>