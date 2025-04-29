<?php
include 'conexion.php';

if (isset($_POST['actualizar'])) {
    $cod_propietario = intval($_POST['cod_propietario']);
    $tipo_empresa = $_POST['tipo_empresa'];
    $tipo_doc = $_POST['tipo_doc'];
    $num_doc = $_POST['num_doc'];
    $nombre_propietario = $_POST['nombre_propietario'];
    $dir_propietario = $_POST['dir_propietario'];
    $tel_propietario = $_POST['tel_propietario'];
    $email_propietario = $_POST['email_propietario'];
    $contacto_prop = $_POST['contacto_prop'];
    $tel_contacto_prop = $_POST['tel_contacto_prop'];
    $email_contacto_prop = $_POST['email_contacto_prop'];

    if (!$conn) {
        die("Error de conexión a la base de datos.");
    }

    $sql = "UPDATE propietarios 
            SET tipo_empresa = ?, tipo_doc = ?, num_doc = ?, nombre_propietario = ?, dir_propietario = ?, tel_propietario = ?, email_propietario = ?, contacto_prop = ?, tel_contacto_prop = ?, email_contacto_prop = ?
            WHERE cod_propietario = ?";

    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sssssssssss", $tipo_empresa, $tipo_doc, $num_doc, $nombre_propietario, $dir_propietario, $tel_propietario, $email_propietario, $contacto_prop, $tel_contacto_prop, $email_contacto_prop, $cod_propietario);

        if ($stmt->execute()) {
            echo "<p>Propietario actualizado correctamente.</p>";
            echo "<a href='consultar_propietario.php'>Volver a la lista</a>";
        } else {
            echo "Error al actualizar el propietario: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error en la preparación de la consulta: " . $conn->error;
    }

    $conn->close();
}
?>