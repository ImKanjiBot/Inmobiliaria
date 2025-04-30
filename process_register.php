<?php
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener y limpiar los datos del formulario
    $usuario = trim($_POST['usuario']);
    $contraseña = $_POST['contraseña'];
    $contraseña_2 = $_POST['contraseña_2'];
    $rol_usuario = $_POST['rol_usuario'];

    // Validaciones básicas
    if (empty($usuario) || empty($contraseña) || empty($contraseña_2) || empty($rol_usuario)) {
        die("Todos los campos son obligatorios.");
    }

    if ($contraseña !== $contraseña_2) {
        die("Las contraseñas no coinciden.");
    }

    // Verificar si el usuario ya existe
    $stmt = $conn->prepare("SELECT id_usuario FROM usuarios WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        die("El nombre de usuario ya está en uso.");
    }
    $stmt->close();

    // Hash de la contraseña (nunca almacenar contraseñas en texto plano)
    $contraseña_hash = password_hash($contraseña, PASSWORD_DEFAULT);

    // Insertar el nuevo usuario usando sentencias preparadas
    $stmt = $conn->prepare("INSERT INTO usuarios (usuario, contraseña, rol_usuario) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $usuario, $contraseña_hash, $rol_usuario);

    if ($stmt->execute()) {
        // Registro exitoso - redirigir al usuario
        header("Location: login.php");
        exit();
    } else {
        echo "Error al registrar el usuario: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>