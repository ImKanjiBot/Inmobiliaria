<?php


require_once 'conexion.php';

var_dump($conn);


if ($_SERVER["REQUEST_METHOD"] == "POST") {

 $nom_cli = $_POST["nom_cli"];

 $doc_cli = $_POST["doc_cli"];

 $tipo_doc_cli = $_POST["tipo_doc_cli"];

 $dir_cli = $_POST["dir_cli"];

 $tel_cli = $_POST["tel_cli"];

 $email_cli = $_POST["email_cli"];

 $cod_tipoinm = $_POST["cod_tipoinm"];

 $valor_maximo = $_POST["valor_maximo"];

 $notas_cliente = $_POST["notas_cliente"];

 $fk_cod_emp_gestion = $_POST["cod_emp"];


$sql = "INSERT INTO clientes (nom_cli, doc_cli, tipo_doc_cli, dir_cli, tel_cli, email_cli, cod_tipoinm, valor_maximo, notas_cliente, cod_emp)

 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";


 $stmt = $conn->prepare($sql);

 $stmt->bind_param("sisssssisi", $nom_cli, $doc_cli, $tipo_doc_cli, $dir_cli, $tel_cli, $email_cli, $cod_tipoinm, $valor_maximo, $notas_cliente, $cod_emp);

 if ($stmt->execute()) {

 header("Location: cliente_creado.html");

 exit();

 } else {

 echo "Error al crear el cliente: " . $stmt->error;

 }


 $stmt->close();

}


$conn->close();

?>
