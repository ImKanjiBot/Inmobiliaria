<?php
include 'conexion.php';

// Obtener todos los productos
$sql = "SELECT nom_cli, doc_cli,tipo_doc_cli, dir_cli, tel_cli, email_cli, cod_tipoinm, valor_maximo, fecha_creacion, cod_emp, notas_cliente
        FROM clientes c
        JOIN categoria c ON p.id_categoria = c.id_categoria";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Productos</title>
</head>
<body>
    <h2>Gestión de Productos</h2>

    <!-- Formulario para Agregar un Producto -->
    <h3>Agregar cliente</h3>
    <form action="guardar_inmueble.php" method="POST">
        <label>nombre de cliente:</label>
        <input type="text" name="nom_cli" placeholder="Nombre del cliente" required>

        <input type="text" name="nombre_producto" placeholder="Nombre del Producto" required>
        <input type="number" name="cantidad_producto" placeholder="Cantidad" required>
        <input type="number" name="Valor_producto" placeholder="Precio" required>
        <select name="id_categoria" required>
            <option value="">Seleccione una categoría</option>
            <?php
            $sqlCat = "SELECT id_categoria, nombre_categoria FROM clientes";
            $resultCat = $conn->query($sqlCat);
            while ($rowCat = $resultCat->fetch_assoc()) {
                echo "<option value='" . $rowCat['id_categoria'] . "'>" . $rowCat['nombre_categoria'] . "</option>";
            }
            ?>
        </select>
        <button type="submit" name="insertar">Agregar</button>
    </form>

    <h3>Lista de clientes</h3>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Cantidad</th>
            <th>Categoría</th>
            <th>Precio</th>
            <th>Acciones</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id_productos'] ?></td>
            <td><?= $row['nombre_producto'] ?></td>
            <td><?= $row['cantidad_producto'] ?></td>
            <td><?= $row['nombre_categoria'] ?></td>
            <td><?= $row['Valor_producto'] ?></td>
            <td>
                <a href="update.php?id=<?= $row['id_productos'] ?>">Editar</a> |
                <a href="delete.php?id=<?= $row['id_productos'] ?>">Eliminar</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>