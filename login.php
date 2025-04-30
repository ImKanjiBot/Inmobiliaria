<?php
session_start();
include("conexion.php");

// Mostrar errores de sesión si existen
if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
    unset($_SESSION['error']);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div class="container">
        <h2>Iniciar Sesión</h2>
        
        <?php if (!empty($error)): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <form action="process_login.php" method="POST" autocomplete="off">
            <div class="form-group">
                <label for="usuario">Usuario:</label>
                <input type="text" id="usuario" name="usuario" required>
            </div>
            
            <div class="form-group">
                <label for="contraseña">Contraseña:</label>
                <input type="password" id="contraseña" name="contraseña" required>
            </div>
            
            <div class="form-group">
                <label for="rol">Tipo de usuario:</label>
                <select id="rol" name="rol" required>
                    <option value="">-- Seleccione su rol --</option>
                    <?php
                    // Obtener roles disponibles desde la base de datos
                    $stmt = $pdo->query("SHOW COLUMNS FROM usuarios LIKE 'rol_usuario'");
                    $row = $stmt->fetch();
                    preg_match("/^enum\(\'(.*)\'\)$/", $row['Type'], $matches);
                    $roles = explode("','", $matches[1]);
                    
                    foreach ($roles as $rol) {
                        echo "<option value='$rol'>" . ucfirst($rol) . "</option>";
                    }
                    ?>
                </select>
            </div>
            
            <button type="submit" class="btn-login">Ingresar</button>
        </form>
    </div>
</body>
</html>
