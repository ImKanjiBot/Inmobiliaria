<?php
// db.php - Conexion a la base de datos
session_start();
include("conexion.php");

$tablas = [
    'cargos', 'clientes', 'contratos', 'empleados', 'inmuebles',
    'inspeccion', 'oficinas', 'propietarios', 'tipo_inmueble', 'visitas'
];

$totales = [];
foreach ($tablas as $tabla) {
    $res = $conn->query("SELECT COUNT(*) as total FROM $tabla");
    $fila = $res->fetch_assoc();
    $totales[$tabla] = $fila['total'];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard PHP</title>
    <script>
        // Opcional: Actualizar datos sin recargar la pagina
        async function recargarDatos() {
            const res = await fetch('totales.php');
            const datos = await res.json();
            for (let tabla in datos) {
                document.getElementById(tabla).innerText = datos[tabla];
            }
        }

        setInterval(recargarDatos, 30000); // cada 30 segundos
    </script>
</head>
<body>
    <h1>Dashboard de Tablas</h1>
    <div>
        <?php foreach ($totales as $tabla => $total): ?>
            <div>
                <strong><?= ucfirst($tabla) ?>:</strong>
                <span id="<?= $tabla ?>"><?= $total ?></span>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>