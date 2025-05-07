<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $cod_cli = $_POST['cod_cli'];
    $nom_cli = $_POST['nom_cli'];
    $doc_cli = $_POST['doc_cli'];
    $tipo_doc_cli = $_POST['tipo_doc_cli'];
    $dir_cli = $_POST['dir_cli'];
    $tel_cli = $_POST['tel_cli'];
    $email_cli = $_POST['email_cli'];
    $cod_tipoinm = $_POST['cod_tipoinm'];
    $valor_maximo = $_POST['valor_maximo'];
    $notas_cliente = $_POST['notas_cliente'];
    $cod_emp = $_POST['cod_emp'];

    
    $sql = "UPDATE clientes SET
                nom_cli = ?,
                doc_cli = ?,
                tipo_doc_cli = ?,
                dir_cli = ?,
                tel_cli = ?,
                email_cli = ?,
                cod_tipoinm = ?,
                valor_maximo = ?,
                notas_cliente = ?,
                cod_emp = ?
            WHERE cod_cli = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssisssi", $nom_cli, $doc_cli, $tipo_doc_cli, $dir_cli, $tel_cli, $email_cli, $cod_tipoinm, $valor_maximo, $notas_cliente, $cod_emp, $cod_cli);

    if ($stmt->execute()) {
        
        header("Location: consultar_clientes.php?mensaje=cliente_actualizado");
        exit();
    } else {
        
        echo "Error al actualizar el cliente: " . $stmt->error;
    }

    $stmt->close();
} else {
    
    echo "Acceso no permitido.";
}

$conn->close();
?>