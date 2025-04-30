<?php
include 'conexion.php';

// Obtener el ID de la oficina a editar
if (!isset($_GET['id'])) {
    die("ID de oficina no proporcionado.");
}

$cod_ofi = $_GET['id'];

// Consultar los datos de la oficina
$sql = "SELECT * FROM oficinas WHERE cod_ofi = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $cod_ofi);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Oficina no encontrada.");
}

$oficina = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Oficina</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Editar Oficina</h2>
    <form action="actualizar_oficina.php" method="post">
        <input type="hidden" name="cod_ofi" value="<?php echo $oficina['cod_ofi']; ?>">

        <label>Nombre de la Oficina:</label>
        <input type="text" name="nom_ofi" value="<?php echo $oficina['nom_ofi']; ?>" required>

        <label>Dirección:</label>
        <input type="text" name="dir_ofi" value="<?php echo $oficina['dir_ofi']; ?>">

        <label>Teléfono:</label>
        <input type="text" name="tel_ofi" value="<?php echo $oficina['tel_ofi']; ?>">

        <label>Email:</label>
        <input type="email" name="email_ofi" value="<?php echo $oficina['email_ofi']; ?>">

        <label>Foto (nombre de archivo):</label>
        <input type="text" name="foto_ofi" value="<?php echo $oficina['foto_ofi']; ?>">

        <input type="submit" value="Actualizar Oficina">
        <a href="actualizar_oficina.php">Cancelar</a>
    </form>
</body>
</html>

<?php
$conn->close();
?>