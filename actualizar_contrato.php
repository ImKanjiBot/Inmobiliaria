<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'conexion.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cod_con = $_POST['cod_con'];
    $cod_cli = $_POST['cod_cli'];
    $fecha_con = $_POST['fecha_con'];
    $fecha_ini = $_POST['fecha_ini'];
    $fecha_fin = $_POST['fecha_fin'];
    $meses = $_POST['meses'];
    $valor_con = $_POST['valor_con'];
    $deposito_con = $_POST['deposito_con'];
    $metodo_pago_con = $_POST['metodo_pago_con'];
    $dato_pago = $_POST['dato_pago'];
    $archivo_con_nombre = $_FILES['archivo_con']['name'];
    $archivo_con_actual = $_POST['archivo_con_actual']; 
    
    $sql = "UPDATE contratos SET
            cod_cli = ?,
            fecha_con = ?,
            fecha_ini = ?,
            fecha_fin = ?,
            meses = ?,
            valor_con = ?,
            deposito_con = ?,
            metodo_pago_con = ?,
            dato_pago = ?";

    
    if (!empty($archivo_con_nombre)) {
        $sql .= ", archivo_con = ?";
    }

    $sql .= " WHERE cod_con = ?";

    $stmt = $conn->prepare($sql);

    
    if (!empty($archivo_con_nombre)) {
        $stmt->bind_param("ssssiiisssi", $cod_cli, $fecha_con, $fecha_ini, $fecha_fin, $meses, $valor_con, $deposito_con, $metodo_pago_con, $dato_pago, $archivo_con_nombre, $cod_con);
        
    } else {
        $stmt->bind_param("ssssiiissi", $cod_cli, $fecha_con, $fecha_ini, $fecha_fin, $meses, $valor_con, $deposito_con, $metodo_pago_con, $dato_pago, $cod_con);
    }

    if ($stmt->execute()) {
        $_SESSION['mensaje'] = "Contrato actualizado éxitosamente.";
        header("Location: consultar_contratos.php");
        exit();
    } else {
        echo "Error no se pudo actualizar el contrato: " . $stmt->error;
    }

    $stmt->close();

} else {
    echo "Acceso Denegado.";
}

$conn->close();
?>