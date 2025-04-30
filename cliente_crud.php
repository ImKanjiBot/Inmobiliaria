<?php
// conexion.php
$conn = new mysqli('localhost', 'root', '', 'inmobiliaria');
if ($conn->connect_error) {
    die('Error de conexión: ' . $conn->connect_error);
}

// Crear tabla de clientes si no existe
$sql = "SELECT * FROM clientes";
$conn->query($sql);

// Procesar acciones CRUD
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre = trim($_POST['nom_cli']);
    $documento = trim($_POST['doc_cli']);
    $tipodedocumento = trim($_POST['tipo_doc_cli']);
    $direccion = trim($_POST['dir_cli']);
    $telefono = trim($_POST['tel_cli']);
    $email = trim($_POST['email_cli']);
    $codigotipoinm = trim($_POST['cod_tipoinm']);
    $valormaximo = trim($_POST['valor_maximo']);
    $fecha = trim($_POST['fecha_creacion']);
    $codigodeempresa = trim($_POST['cod_emp']);
    $notasclientes = trim($_POST['notas_clientes']);

    if (!empty($nombre) && !empty($email)) {
        if (isset($_POST['cod_cli']) && !empty($_POST['cod_cli'])) {
            // Actualizar
            $id_cliente = intval($_POST['cod_cli']);
            $stmt = $conn->prepare("UPDATE clientes SET nom_cli=?, doc_cli=?, tipo_doc_cli=?, dir_cli=?, tel_cli=?, email_cli=?, cod_tipoinm=?, valor_maximo=?, fecha_creacion=?, cod_emp=?, notas_cliente WHERE cod_cli=?");
            $stmt->bind_param('sississssis', $nombre, $documento,  $tipodedocumento, $direccion, $telefono, $email,  $codigotipoinm,  $valormaximo,  $fecha, $codigodeempresa, $notasclientes);
        } else {
            // Insertar
            $stmt = $conn->prepare("INSERT INTO clientes (nom_cli, doc_cli, tipo_doc_cli, dir_cli, tel_cli, email_clie, cod_tipoinm, valor_maximo, fecha_creacion, cod_emp, notas_cliente) VALUES (?, ?, ?)");
            $stmt->bind_param('sississssis', $nombre, $documento,  $tipodedocumento, $direccion, $telefono, $email,  $codigotipoinm,  $valormaximo,  $fecha, $codigodeempresa, $notasclientes );
        }
        if ($stmt->execute()) {
            echo 'Operación realizada con éxito';
        } else {
            echo 'Error: ' . $stmt->error;
        }
    } else {
        echo 'Por favor complete todos los campos obligatorios.';
    }
    header('Location: cliente.php');
    exit;
}

if (isset($_GET['eliminar'])) {
    $id_cliente = intval($_GET['eliminar']);
    $conn->query("DELETE FROM clientes WHERE id_cliente=$id_cliente");
    header('Location: clientes.php');
    exit;
}

// Obtener datos para mostrar
$result = $conn->query("SELECT * FROM clientes");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>CRUD de Clientes</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Formulario de Clientes</h2>
    <form action="clientes.php" method="POST">
        <input type="hidden" name="cod_cli" value="<?= isset($_GET['editar']) ? htmlspecialchars($_GET['editar']) : '' ?>">
        <label>Nombre: <input type="text" name="nom_cli" value="<?= isset($_GET['nom_cli']) ? htmlspecialchars($_GET['nom_cli']) : '' ?>" required></label><br>
        <label>Documento: <input type="text" name="doc_cli" value="<?= isset($_GET['doc_cli']) ? htmlspecialchars($_GET['doc_cli']) : '' ?>" required></label><br>
        <label>Tipo de documento: <input type="text" name="tipo_doc_cli" value="<?= isset($_GET['tipo_doc_cli']) ? htmlspecialchars($_GET['tipo_doc_cli']) : '' ?>"></label><br>
        <label>Direccion: <input type="text" name="dir_cli" value="<?= isset($_GET['dir_cli']) ? htmlspecialchars($_GET['dir_cli']) : '' ?>" required></label><br>
        <label>Telefono: <input type="text" name="tel_cli" value="<?= isset($_GET['tel_cli']) ? htmlspecialchars($_GET['tel_cli']) : '' ?>" required></label><br>
        <label>Email: <input type="text" name="email_cli" value="<?= isset($_GET['email_cli']) ? htmlspecialchars($_GET['email_cli']) : '' ?>" required></label><br>
        <label>Codigo inmobiliario: <input type="text" name="cod_tipoinm" value="<?= isset($_GET['cod_tipoinm']) ? htmlspecialchars($_GET['cod_tipoinm']) : '' ?>" required></label><br>
        <label>Valor maximo: <input type="text" name="valor_maximo" value="<?= isset($_GET['valor_maximo']) ? htmlspecialchars($_GET['valor_maximo']) : '' ?>" required></label><br>
        <label>fecha de creacion: <input type="text" name="fecha_creacion" value="<?= isset($_GET['fecha_creacion']) ? htmlspecialchars($_GET['fecha_creacion']) : '' ?>" required></label><br>
        <label>Codigo de empresa: <input type="text" name="cod_emp" value="<?= isset($_GET['cod_emp']) ? htmlspecialchars($_GET['cod_emp']) : '' ?>" required></label><br>
        <label>notas clientes: <input type="text" name="notas_clientes" value="<?= isset($_GET['notas_clientes']) ? htmlspecialchars($_GET['notas_clientes']) : '' ?>" required></label><br>
        <button type="submit">Guardar</button>
    </form>
    
</body>
</html>