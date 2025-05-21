<?php
include '../conexion.php';
session_start();
if (!isset($_SESSION['rol_usuario'])) {
    // Si no ha iniciado sesión, redirige a login.php
    header("Location: ../login.php");
    exit();
    }

// Verificar si se recibió el ID del inmueble y si es un número válido
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cod_inm']) && is_numeric($_POST['cod_inm'])) {
    $cod_inm = intval($_POST['cod_inm']); // Convertir a entero para seguridad


    // Eliminar el inmueble
    $sql = "DELETE FROM inmuebles WHERE cod_inm = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $cod_inm);
        if ($stmt->execute()) {
            echo "<script>alert('Inmueble eliminado correctamente.'); window.location.href='inmueble_crud.php';</script>";
        } else {
            echo "Error al eliminar el inmueble: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error en la consulta de eliminación: " . $conn->error;
    }
} else {
    echo "<script>alert('Error: No se proporcionó un ID de inmueble válido.'); window.location.href='consultar_inmueble.php';</script>";
}

$conn->close();
?>