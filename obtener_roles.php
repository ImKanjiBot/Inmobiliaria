<?php
// Configuración de la conexión a la base de datos
$conexion = new mysqli('localhost', 'tu_usuario', 'tu_contraseña', 'nombre_bd');

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Consulta para obtener los valores del ENUM
$consulta = "SHOW COLUMNS FROM usuarios LIKE 'rol_usuario'";
$resultado = $conexion->query($consulta);

if ($resultado->num_rows > 0) {
    $fila = $resultado->fetch_assoc();
    // Extraer los valores del ENUM
    preg_match("/^enum\(\'(.*)\'\)$/", $fila['Type'], $matches);
    $valores_enum = explode("','", $matches[1]);
    
    // Generar las opciones del select
    foreach ($valores_enum as $valor) {
        echo "<option value='$valor'>" . ucfirst($valor) . "</option>";
    }
}

$conexion->close();
?>