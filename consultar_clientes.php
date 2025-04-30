<table>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Teléfono</th>
            <th>Acciones</th> 
        </tr>
        <?php while ($row = $result->fetch_assoc()) : ?>
        <tr>
            <td><?= $row['cod_cli'] ?></td>
            <td><?= htmlspecialchars($row['nom_cli']) ?></td>
            <td><?= htmlspecialchars($row['email_cli']) ?></td>
            <td><?= htmlspecialchars($row['tel_cli']) ?></td>
            <td>
                <a href="clientes.php?editar=<?= $row['cod_cli'] ?>&nombre=<?= urlencode($row['nom_cli']) ?>&email=<?= urlencode($row['email_cli']) ?>&telefono=<?= urlencode($row['tel_cli']) ?>">Editar</a>

                <a href="clientes.php?eliminar=<?= $row['cod_cli'] ?>" onclick="return confirm('¿Seguro que deseas eliminar este cliente?')">Eliminar</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>