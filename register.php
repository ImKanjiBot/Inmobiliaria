<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <form action="register.php" method="POST">
            <h2>Regístrate</h2>

            <label for="usuario">Usuario:</label>
            <input type="text" id="usuario" name="usuario" required><br>
            
            <label for="contraseña">Contraseña:</label>
            <input type="password" id="contraseña" name="contraseña" required><br>
            
            <label for="contraseña_2">Confirmar contraseña:</label>
            <input type="password" id="contraseña_2" name="contraseña_2" required>
            
            <label for="rol_usuario">Tipo de usuario:</label>
            <select id="rol_usuario" name="rol_usuario" required>
                <option value="">-- Seleccione un rol --</option>
                <?php include 'obtener_roles.php'; ?>
            </select>
        
            <hr>
            <button type="submit">Registrarse</button>
            <a href="index_users.php">¿Ya tienes cuenta? Inicia sesión</a>
        </form>
    </div>
</body>
</html>