<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inmobiliaria";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error){
    die("conexion fallida:" . $conn->connect_error);
}
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

$sql = "INSERT INTO propietarios (tipo_empresa, tipo_doc,num_doc,nombre_propietario, dir_propietario, tel_propietario, email_propietario, contacto_prop, tel_contacto_prop, email_contacto_prop ) VALUES (?,?,?,?,?,?,?,?,?,?) ";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssssss",$tipo_empresa,$tipo_doc, $num_doc, $nombre_propietario, $dir_propietario, $tel_propietario, $email_propietario, $contacto_prop, $tel_contacto_prop, $email_contacto_prop);

if ($stmt->execute()){
    echo"propietario registrado correctamente.";
}else{
    echo"eror al registrar el propietario:" . $conn->error;
}
$stmt->close();
$conn->close();
?>
