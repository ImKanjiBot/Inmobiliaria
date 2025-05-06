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
        $sql_insert = "INSERT INTO usuarios (usuario, contraseña, rol_usuario) VALUES (?, ?, 'cliente')";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("ss", $nuevo_usuario, $nueva_contrasena); // ¡No seguro en producción!

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
    <style>
        .error {
            color: red;
        }
        .success {
            color: green;
        }
    </style>
</head>
<body>
    <h2>Registro de Nuevo Cliente</h2>

    <?php if (!empty($errores)): ?>
        <div class="error">
            <ul>
                <?php foreach ($errores as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if ($registro_exitoso): ?>
        <div class="success">
            <p>Registro exitoso. ¡Bienvenido!</p>
            <p><a href="login.php">Ir a la página de inicio de sesión</a></p>
        </div>
    <?php else: ?>
        <form method="POST" action="">
            <div>
                <label for="usuario">Nombre de Usuario:</label>
                <input type="text" id="usuario" name="usuario" required>
            </div>
            <br>
            <div>
                <label for="contrasena">Contraseña:</label>
                <input type="password" id="contrasena" name="contrasena" required>
            </div>
            <br>
            <div>
                <label for="confirmar_contrasena">Confirmar Contraseña:</label>
                <input type="password" id="confirmar_contrasena" name="confirmar_contrasena" required>
            </div>
            <br>
            <button type="submit">Registrarse</button>
        </form>
        <p>¿Ya tienes una cuenta? <a href="login.php">Iniciar Sesión</a></p>
    <?php endif; ?>

</body>
</html>