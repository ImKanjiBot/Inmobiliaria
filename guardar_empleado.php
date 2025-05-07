<?php
include 'conexion.php';

//Recibir Datos
$ced_emp = $_POST['ced_emp'];
$tipo_doc = $_POST['tipo_doc'];
$nom_emp = $_POST['nom_emp'];
$dir_emp = $_POST['dir_emp'];
$tel_emp = $_POST['tel_emp'];
$emaill_emp = $_POST['email_emp'];
$rh_emp = $_POST['rh_emp'];
$fecha_nac = $_POST['fehca_nac'];
$cod_cargo = $_POST['cod_cargo'];
$salario = $_POST['salario'];
$gastos = $_POST['gastos'];
$comision = $_POST['comision'];
$fecha_ing = $_POST['fecha_ing'];
$fecha_ret = $_POST['fecha_ret'];
$nom_contacto = $_POST['nom_contacto'];
$dir_contacto = $_POST['dir_contacto'];

//Manejo de foto
$foto = null;
if (!empty($_FILES['foto']['name'])) {
    $foto = "uploads/" . basename($_FILES['foto']['name']);
    move_uploaded_file($_FILES['foto']['tmp_name'], $foto);
}

//Insertar en la base de datos
$sql = "INSERT INTO inmuebles (dir_inm, barrio_inm, ciudad_inm, departamento_inm,  latitud, longitud, foto, web_p1, web_p2, cod_tipoinm, num_hab, precio_alq, cod_propietario, caracteristica_inm, notas_inm, cod_emp, cod_ofi) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn -> prepare($sql);
$stmt -> bind_param("ssssddsssiiiissii", $direccion, $barrio, $ciudad, $departamento, $latitud, $longitud, $foto, $web_p1, $web_p2, $cod_tipoinm, $num_hab, $precio_alq, $cod_propietario, $caracteristica_inm, $notas_inm, $cod_emp, $cod_ofi);

if ($stmt -> execute()) {
    echo "Inmueble registrado exitosamente";
} else {
    echo "Error: " .$stmt -> error;
}

$stmt -> close();
$conn -> close();
?>