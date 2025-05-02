<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'conexion.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $cliente_id = $_GET['id'];

    
    $sql = "DELETE FROM clientes WHERE cod_cli = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $cliente_id);

    if ($stmt->execute()) {
        
        header("Location: consultar_clientes.php?mensaje=cliente_eliminado");
        exit();
    } else {
        
        echo "Error al eliminar el cliente: " . $stmt->error;
    }

    $stmt->close();
} else {
    
    echo "ID de cliente inválido.";
}

$conn->close();
?>