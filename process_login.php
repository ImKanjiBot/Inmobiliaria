<?php
session_start();
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];

    // Verificar si el usuario existe en la base de datos
    $sql = "SELECT usuario_id FROM usuarios WHERE usuario = '$usuario' AND contraseña = '$contraseña'";
    $resultado = $conn->query($sql);

    // Verificar si la consulta fue exitosa
    if (!$resultado) {
        die("Error en la consulta: " . $conn->error);
    }

    if ($resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();
        $_SESSION['usuario'] = $usuario;
        $_SESSION['usuario_id'] = $fila['usuario_id']; 

        header("Location: menu.php");
        exit();
    } else {
        echo "Usuario o contraseña incorrectos.";
    }
}
?>