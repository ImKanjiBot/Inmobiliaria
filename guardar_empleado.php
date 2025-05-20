<?php
include 'conexion.php';

//Recibir Datos
$ced_emp = $_POST['ced_emp'];
$tipo_doc = $_POST['tipo_doc'];
$nom_emp = $_POST['nom_emp'];
$dir_emp = $_POST['dir_emp'];
$tel_emp = $_POST['tel_emp'];
$email_emp = $_POST['email_emp'];
$rh_emp = $_POST['rh_emp'];
$fecha_nac = $_POST['fecha_nac'];
$cod_cargo = $_POST['cod_cargo'];
$salario = $_POST['salario'];
$gastos = $_POST['gastos'];
$comision = $_POST['comision'];
$fecha_ing = $_POST['fecha_ing'];
$fecha_ret = $_POST['fecha_ret'];
$nom_contacto = $_POST['nom_contacto'];
$dir_contacto = $_POST['dir_contacto'];
$tel_contacto = $_POST['tel_contacto'];
$email_contacto = $_POST['email_contacto'];
$relacion_contacto = $_POST['relacion_contacto'];
$cod_ofi = $_POST['cod_ofi'];

//Insertar en la base de datos
$sql = "INSERT INTO empleados (ced_emp, tipo_doc, nom_emp, dir_emp, tel_emp, email_emp, rh_emp, fecha_nac, cod_cargo, salario, gastos, comision, fecha_ing, fecha_ret, nom_contacto, dir_contacto, tel_contacto, email_contacto, relacion_contacto, cod_ofi) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$stmt = $conn -> prepare($sql);
$stmt -> bind_param("isssisssiiiissssissi", $ced_emp, $tipo_doc, $nom_emp, $dir_emp, $tel_emp, $email_emp, $rh_emp, $fecha_nac, $cod_cargo, $salario, $gastos, $comision, $fecha_ing, $fecha_ret, $nom_contacto, $dir_contacto, $tel_contacto, $email_contacto, $relacion_contacto, $cod_ofi );

if ($stmt -> execute()) {
    echo "Empleado registrado exitosamente";
} else {
    echo "Error: " .$stmt -> error;
}

$stmt -> close();
$conn -> close();
?>