<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["cod_emp"])) {
    $cod_emp = $_POST["cod_emp"];

    $sql = "DELETE FROM empleados WHERE cod_emp = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $cod_emp);

    if ($stmt->execute()) {
        echo "<script>alert('Empleado eliminado correctamente'); window.location.href='consultar_empleados.php';</script>";
    } else {
        echo "<script>alert('Error al eliminar el empleado'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<script>alert('Solicitud no válida'); window.history.back();</script>";
}
?>