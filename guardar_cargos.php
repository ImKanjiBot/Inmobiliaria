<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'conexion.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recibir y limpiar los datos del formulario
    $nom_cargo = trim($_POST['nom_cargo']);

    if (!empty($nom_cargo)) {
        // Preparar la consulta SQL segura
        $sql = "INSERT INTO cargos (nom_cargo) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $nom_cargo);

        if ($stmt->execute()) {
            $_SESSION['mensaje'] = "Cargo registrado con éxito.";
            header("Location: consultar_cargos.php");
            exit();
        } else {
            echo "Error al guardar el cargo: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "El campo 'Nombre del cargo' no puede estar vacío.";
    }
} else {
    echo "Acceso no permitido.";
}

$conn->close();
?>
