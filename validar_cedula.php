<?php
include("conexion.php");

if (isset($_GET['cedula'])) {
    $cedula = mysqli_real_escape_string($conn, $_GET['cedula']);
    
    // Consulta para verificar si la cédula existe en la base de datos
    $result = mysqli_query($conn, "SELECT id, nombre, puntos FROM clientes WHERE cedula = '$cedula'");

    if (mysqli_num_rows($result) > 0) {
        // La cédula existe, obtener datos del cliente
        $cliente = mysqli_fetch_assoc($result);
        $nombre = $cliente['nombre'];
        $puntos = $cliente['puntos'];
        
        // Devuelve la información del cliente en formato JSON
        $response = array('message' => 'Cédula válida', 'nombre' => $nombre, 'puntos' => $puntos);
    } else {
        // La cédula no existe
        $response = array('message' => 'Cédula no registrada. Puede proceder a registar cliente.');
    }

    // Devuelve la respuesta en formato JSON
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // No se proporcionó la cédula en la solicitud
    $response = array('message' => 'Error: No se proporcionó la cédula.');
    header('Content-Type: application/json');
    echo json_encode($response);
}

mysqli_close($conn);
?>