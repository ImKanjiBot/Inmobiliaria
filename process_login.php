<?php
ini_set('display_errors', 0);
error_reporting(0);
session_start();
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Limpieza de datos
    $usuario = trim($_POST['usuario']);
    $contraseña = $_POST['contraseña'];
    $rol = $_POST['rol'];

    // Validación
    if (empty($usuario) || empty($contraseña) || empty($rol)) {
        $_SESSION['error'] = "Todos los campos son obligatorios";
        header('Location: login.php');
        exit();
    }

    // Consulta segura con PDO
    $sql = "SELECT id_usuario, usuario, contraseña, rol_usuario FROM usuarios 
            WHERE usuario = :usuario AND rol_usuario = :rol LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
    $stmt->bindParam(':rol', $rol, PDO::PARAM_STR);
    $stmt->execute();

    if ($usuario_db = $stmt->fetch()) {
        // Verificar contraseña
        if (password_verify($contraseña, $usuario_db['contraseña'])) {
            // Regenerar ID de sesión para prevenir fixation
            session_regenerate_id(true);
            
            // Limpiar y establecer datos de sesión
            $_SESSION = [];
            $_SESSION['id_usuario'] = $usuario_db['id_usuario'];
            $_SESSION['usuario'] = $usuario_db['usuario'];
            $_SESSION['rol'] = $usuario_db['rol_usuario'];
            $_SESSION['ultimo_acceso'] = time();

            // Redirección según rol
            switch ($_SESSION['rol']) {
                case 'admin':
                    header('Location: menu_admin.php');
                    break;
                case 'empleado':
                    header('Location: menu_empleado.php');
                    break;
                case 'cliente':
                    header('Location: menu_cliente.php');
                    break;
                default:
                    header('Location: index.php');
            }
            exit();
        }
    }

    // Credenciales incorrectas
    sleep(2); // Retraso para prevenir ataques de fuerza bruta
    $_SESSION['error'] = "Credenciales incorrectas o rol no válido";
    header('Location: login.php');
    exit();
}
?>