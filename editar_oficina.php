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
    <style>
        h2 {
            text-align: center;
            color: #1e88e5;
            margin-bottom: 20px;
        }

        form {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: 20px auto;
            display: grid;
            gap: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
            font-weight: bold;
            text-align: left;
        }

        input[type="text"],
        input[type="email"] {
            width: calc(100% - 12px);
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 1em;
        }

        input[type="text"]:focus,
        input[type="email"]:focus {
            outline: none;
            border-color: #2196f3;
            box-shadow: 0 0 5px rgba(33, 150, 243, 0.5);
        }

        input[type="submit"],
        a {
            display: inline-block;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease, color 0.3s ease;
            margin-top: 10px;
            font-size: 1em;
            text-align: center;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: white;
            border: none;
            cursor: pointer;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #43a047;
        }

        a {
            background-color: #f44336;
            color: white;
            width: 100%;
        }

        a:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Editar Oficina</h2>
        <hr>
        <form action="actualizar_oficina.php" method="post">
            <input type="hidden" name="cod_ofi" value="<?php echo $oficina['cod_ofi']; ?>">

            <div>
                <label for="nom_ofi">Nombre de la Oficina:</label>
                <input type="text" id="nom_ofi" name="nom_ofi" value="<?php echo $oficina['nom_ofi']; ?>" required>
            </div>

            <div>
                <label for="dir_ofi">Dirección:</label>
                <input type="text" id="dir_ofi" name="dir_ofi" value="<?php echo $oficina['dir_ofi']; ?>">
            </div>

            <div>
                <label for="tel_ofi">Teléfono:</label>
                <input type="text" id="tel_ofi" name="tel_ofi" value="<?php echo $oficina['tel_ofi']; ?>">
            </div>

            <div>
                <label for="email_ofi">Email:</label>
                <input type="email" id="email_ofi" name="email_ofi" value="<?php echo $oficina['email_ofi']; ?>">
            </div>

            <div>
                <label for="foto_ofi">Foto (nombre de archivo):</label>
                <input type="text" id="foto_ofi" name="foto_ofi" value="<?php echo $oficina['foto_ofi']; ?>">
            </div>

            <div>
                <input type="submit" value="Actualizar Oficina">
            </div>
            <div>
                <a href="consultar_oficinas.php">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>