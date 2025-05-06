<?php
session_start();
include("conexion.php");

// Mostrar errores de sesión si existen
if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
    unset($_SESSION['error']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    // Consulta para buscar el usuario por nombre
    $sql = "SELECT id_usuario, usuario, contraseña, rol_usuario FROM usuarios WHERE usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $usuario); // "s" indica que $usuario es un string
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $resultado = $result->fetch_assoc();
        // Verificamos la contraseña (¡Importante usar password_verify si has hasheado las contraseñas!)
        if ($contrasena === $resultado['contraseña']) { // ¡En producción, usa password_verify!
            $_SESSION['id_usuario'] = $resultado['id_usuario'];
            $_SESSION['usuario'] = $resultado['usuario'];
            $_SESSION['rol_usuario'] = $resultado['rol_usuario'];

            // Redireccionamos según el rol
            switch ($resultado['rol_usuario']) {
                case 'admin':
                    header("Location: menu_admin.php");
                    exit();
                case 'empleado':
                    header("Location: menu_empleado.php");
                    exit();
                case 'cliente':
                    header("Location: menu_cliente.php");
                    exit();
                default:
                    // Rol desconocido, podrías redirigir a una página de error
                    header("Location: error_rol.php");
                    exit();
            }
        } else {
            $error_login = "Contraseña incorrecta.";
        }
    } else {
        $error_login = "El usuario no existe.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login de Usuarios</title>
</head>
<body>
    <h2>Iniciar Sesión</h2>
    <?php if (isset($error_login)): ?>
        <p style="color: red;"><?php echo $error_login; ?></p>
    <?php endif; ?>
    <form method="POST" action="">
        <div>
            <label for="usuario">Usuario:</label>
            <input type="text" id="usuario" name="usuario" required>
        </div>
        <br>
        <div>
            <label for="contrasena">Contraseña:</label>
            <input type="password" id="contrasena" name="contrasena" required>
        </div>
        <br>
        <button type="submit">Iniciar Sesión</button>
    </form>
    <p>¿No tienes una cuenta? <a href="register.php">Registrarse</a></p>
</body>
</html>