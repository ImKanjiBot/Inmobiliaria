<?php
include '../conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del formulario
    $cod_inm = $_POST['cod_inm']; // este debe venir oculto en tu formulario
    $direccion = $_POST['dir_inm'];
    $barrio = $_POST['barrio_inm'];
    $ciudad = $_POST['ciudad_inm'];
    $departamento = $_POST['departamento_inm'];
    $latitud = $_POST['latitud'];
    $longitud = $_POST['longitud'];
    $web_p1 = $_POST['web_p1'];
    $web_p2 = $_POST['web_p2'];
    $cod_tipoinm = $_POST['cod_tipoinm'];
    $num_hab = $_POST['num_hab'];
    $precio_alq = $_POST['precio_alq'];
    $cod_propietario = intval($_POST['cod_propietario']);
    $caracteristica_inm = $_POST['caracteristica_inm'];
    $notas_inm = $_POST['notas_inm'];
    $cod_emp = $_POST['cod_emp'];
    $cod_ofi = $_POST['cod_ofi'];

    // Manejo de la foto (si se sube una nueva)
    $foto = null;
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $foto = 'uploads/' . basename($_FILES['foto']['name']);
        move_uploaded_file($_FILES['foto']['tmp_name'], $foto);
    }

    // Construir consulta SQL
    $sql = "UPDATE inmuebles SET 
        dir_inm = ?, barrio_inm = ?, ciudad_inm = ?, departamento_inm = ?, 
        latitud = ?, longitud = ?, web_p1 = ?, web_p2 = ?, cod_tipoinm = ?, 
        num_hab = ?, precio_alq = ?, cod_propietario = ?, caracteristica_inm = ?, 
        notas_inm = ?, cod_emp = ?, cod_ofi = ?";

    // Solo actualizar la foto si se subió una nueva
    if ($foto) {
        $sql .= ", foto = ?";
    }

    $sql .= " WHERE cod_inm = ?";

    // Preparar la consulta
    $stmt = $conn->prepare($sql);

    if ($foto) {
        $stmt->bind_param(
            "ssssddsssiiisssssi", 
            $direccion, $barrio, $ciudad, $departamento,
            $latitud, $longitud, $web_p1, $web_p2, $cod_tipoinm,
            $num_hab, $precio_alq, $cod_propietario, $caracteristica_inm,
            $notas_inm, $cod_emp, $cod_ofi, $foto, $cod_inm
        );
        
    } else {
        $stmt->bind_param(
            "ssssddsssiiisssii", 
            $direccion,          // s
            $barrio,             // s
            $ciudad,             // s
            $departamento,       // s
            $latitud,            // d
            $longitud,           // d
            $web_p1,             // s
            $web_p2,             // s
            $cod_tipoinm,        // s (o i, según tipo en DB)
            $num_hab,            // i
            $precio_alq,         // i
            $cod_propietario,    // i
            $caracteristica_inm, // s
            $notas_inm,          // s
            $cod_emp,            // s (o i)
            $cod_ofi,            // i
            $cod_inm        // i (es el WHERE)
        );        
    }

    // Ejecutar y verificar
    if (!$stmt) {
        die("Error en prepare: " . $conn->error);
    }
    
    if (!$stmt->execute()) {
        die("Error en execute: " . $stmt->error);
    } else {
        echo "<script>alert('Inmueble actualizado correctamente.'); window.location.href='consultar_inmueble.php';</script>";
    }
    

    $stmt->close();
    $conn->close();
}
?>
