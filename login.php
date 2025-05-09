<?php

session_start();
require 'conexion.php';

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
    <meta charset="UTF-8">
    <title>Login de Usuarios</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Estilos específicos para la página de login */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f4f4f4;
        }

        .login-container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            max-width: 90%;
            text-align: center;
        }

        h2 {
            color: #1e88e5;
            margin-bottom: 20px;
        }

        .error-message {
            color: red;
            margin-bottom: 15px;
        }

        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #333;
            font-weight: bold;
        }

        .form-group input[type="text"],
        .form-group input[type="password"] {
            width: calc(100% - 12px);
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 1em;
        }

        button[type="submit"] {
            background-color: #2196f3;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #1976d2;
        }

        .register-link {
            margin-top: 20px;
            font-size: 0.9em;
            color: #555;
        }

        .register-link a {
            color: #1e88e5;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .register-link a:hover {
            color: #1565c0;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        <?php if (isset($error_login)): ?>
            <p class="error-message"><?php echo $error_login; ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="usuario">Usuario:</label>
                <input type="text" id="usuario" name="usuario" required>
            </div>
            <div class="form-group">
                <label for="contrasena">Contraseña:</label>
                <input type="password" id="contrasena" name="contrasena" required>
            </div>
            <button type="submit">Iniciar Sesión</button>
        </form>
        <p class="register-link">¿No tienes una cuenta? <a href="register.php">Registrarse</a></p>
    </div>
</body>
</html>