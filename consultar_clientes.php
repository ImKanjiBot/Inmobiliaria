<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Clientes</title>
    <style>
.clientes-container {
    display: grid; 
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); 
    gap: 10px;
    padding: 10px;
}


.cliente-recuadro-fila {
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    padding: 8px;
    border-radius: 4px;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(80px, 1fr)); 
    gap: 5px;
    align-items: center; 
}

.cliente-celda {
    font-size: 0.85em;
    color: #666;
    overflow: hidden; 
    text-overflow: ellipsis; 
    white-space: nowrap; 
}


.cliente-acciones {
    font-size: 0.8em;
}

.cliente-acciones a {
    text-decoration: none;
    margin-right: 5px;
    color: #007bff;
}

.cliente-acciones a:hover {
    color: #0056b3;
}
    </style>
   <link rel="stylesheet" href="styles.css"> 
</head>

 <body>
    <hr>
    <h1>Consultar Clientes</h1>

    <?php if (isset($_GET['mensaje'])): ?>
        <p style="color: green;"><?php echo $_GET['mensaje']; ?></p>
    <?php endif; ?>

    <div class="clientes-container">
        <?php
        require_once 'conexion.php';

        $sql = "SELECT
                        c.nom_cli,
                        c.doc_cli,
                        c.tipo_doc_cli,
                        c.dir_cli,
                        c.tel_cli,
                        c.email_cli,
                        ti.nom_tipoinm AS tipo_inmueble,
                        c.valor_maximo,
                        c.notas_cliente,
                        e.nom_emp AS empleado_gestion,
                        c.fecha_creacion,
                        c.cod_cli
                     FROM clientes c
                     INNER JOIN tipo_inmueble ti ON c.cod_tipoinm = ti.cod_tipoinm
                     INNER JOIN empleados e ON c.cod_emp = e.cod_emp";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='cliente-recuadro-fila'>";
                    echo "<div class='cliente-celda'>" . $row["nom_cli"] . "</div>";
                    echo "<div class='cliente-celda'>" . $row["tipo_doc_cli"] . " " . $row["doc_cli"] . "</div>";
                    echo "<div class='cliente-celda'>" . $row["dir_cli"] . "</div>";
                    echo "<div class='cliente-celda'>" . $row["tel_cli"] . "</div>";
                    echo "<div class='cliente-celda'>" . $row["email_cli"] . "</div>";
                    echo "<div class='cliente-celda'>" . $row["tipo_inmueble"] . "</div>";
                    echo "<div class='cliente-celda'>" . $row["valor_maximo"] . "</div>";
                    echo "<div class='cliente-celda'>" . $row["empleado_gestion"] . "</div>";
                    echo "<div class='cliente-acciones'>";
                        echo "<a href='editar_cliente.php?id=" . $row["cod_cli"] . "'>Editar</a> | ";
                        echo "<a href='eliminar_cliente.php?id=" . $row["cod_cli"] . "' onclick=\"return confirm('¿Está seguro que desea eliminar a " . $row["nom_cli"] . "?')\">Eliminar</a>";
                    echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<p>No se encontraron clientes.</p>";
        }

        $conn->close();
        ?>
    </div>

    <p><a href="cliente_crud.php">Crear Nuevo Cliente</a></p>
</body>
</html>