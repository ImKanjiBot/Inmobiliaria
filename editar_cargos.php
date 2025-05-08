<?php
include('conexion.php');

if (isset($_GET['cod_cargo'])) {
    $cod_cargo = $_GET['cod_cargo'];
    $sql = "SELECT * FROM cargos WHERE cod_cargo = $cod_cargo";
    $resultado = mysqli_query($conexion, $sql);
    $cargo = mysqli_fetch_assoc($resultado);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Cargo</title>
</head>
<body>
    <h1>Editar Cargo</h1>
    <form action="actualizar_cargo.php" method="POST">
        <input type="hidden" name="cod_cargo" value="<?php echo $cargo['cod_cargo']; ?>">
        <label for="nom_cargo">Nombre del Cargo:</label>
        <input type="text" name="nom_cargo" id="nom_cargo" value="<?php echo $cargo['nom_cargo']; ?>">
        <button type="submit">Actualizar</button>
        <button type="submit">Actualiz</button>
        
    </form>
</body>
</html>
