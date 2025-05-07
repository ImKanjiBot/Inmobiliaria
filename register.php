<?php
include("conexion.php");

$registro_exitoso = false;
$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nuevo_usuario = $_POST['usuario'];
    $nueva_contrasena = $_POST['contrasena'];
    $confirmar_contrasena = $_POST['confirmar_contrasena'];

    // Validaciones básicas
    if (empty($nuevo_usuario)) {
        $errores[] = "El nombre de usuario es requerido.";
    }
    if (empty($nueva_contrasena)) {
        $errores[] = "La contraseña es requerida.";
    }
    if ($nueva_contrasena !== $confirmar_contrasena) {
        $errores[] = "Las contraseñas no coinciden.";
    }

    // Verificar si el usuario ya existe
    $sql_check = "SELECT usuario FROM usuarios WHERE usuario = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $nuevo_usuario);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        $errores[] = "El nombre de usuario ya existe. Por favor, elige otro.";
    }

    $stmt_check->close();

    // Si no hay errores, proceder con el registro
    if (empty($errores)) {
        // ¡Importante! En producción, debes usar password_hash para almacenar contraseñas de forma segura
        $hashed_password = password_hash($nueva_contrasena, PASSWORD_DEFAULT); // ¡Seguro para producción!
        $sql_insert = "INSERT INTO usuarios (usuario, contraseña, rol_usuario) VALUES (?, ?, 'cliente')";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("ss", $nuevo_usuario, $hashed_password); // ¡Usando la contraseña hasheada!

        if ($stmt_insert->execute()) {
            $registro_exitoso = true;
        } else {
            $errores[] = "Error al registrar el usuario: " . $conn->error;
        }

        $stmt_insert->close();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registro de Cliente</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Estilos específicos para la página de registro */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f4f4f4;
        }

        .register-container {
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

        .error-container {
            background-color: #ffebee;
            color: #d32f2f;
            border: 1px solid #d32f2f;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            text-align: left;
        }

        .success-message {
            background-color: #e6ffe6;
            color: green;
            border: 1px solid green;
            padding: 10px;
            border-radius: 5px;
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
            background-color: #4caf50;
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
            background-color: #43a047;
        }

        .login-link {
            margin-top: 20px;
            font-size: 0.9em;
            color: #555;
        }

        .login-link a {
            color: #1e88e5;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .login-link a:hover {
            color: #1565c0;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h2>Registro de Nuevo Cliente</h2>

        <?php if (!empty($errores)): ?>
            <div class="error-container">
                <ul>
                    <?php foreach ($errores as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if ($registro_exitoso): ?>
            <div class="success-message">
                <p>Registro exitoso. ¡Bienvenido!</p>
                <p><a href="login.php">Ir a la página de inicio de sesión</a></p>
            </div>
        <?php else: ?>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="usuario">Nombre de Usuario:</label>
                    <input type="text" id="usuario" name="usuario" required>
                </div>
                <div class="form-group">
                    <label for="contrasena">Contraseña:</label>
                    <input type="password" id="contrasena" name="contrasena" required>
                </div>
                <div class="form-group">
                    <label for="confirmar_contrasena">Confirmar Contraseña:</label>
                    <input type="password" id="confirmar_contrasena" name="confirmar_contrasena" required>
                </div>
                <button type="submit">Registrarse</button>
            </form>
            <p class="login-link">¿Ya tienes una cuenta? <a href="login.php">Iniciar Sesión</a></p>
        <?php endif; ?>
    </div>
</body>
</html>