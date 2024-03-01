<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if(!isset($_SESSION['usuario'])){
    echo '
        <script>
            alert("Por favor iniciar sesión.");
            window.location = "index.php";
        </script>
    ';
    session_destroy();
    die();
}

include("conexion.php");
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Perfil del Cliente</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style_nav.css" rel="stylesheet">
    <style>
        .content {
            margin-top: 80px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-default navbar-fixed-top">
        <?php include('nav.php');?>
    </nav>
    <div class="container">
        <div class="content">
            <?php
            // Verificar si se ha proporcionado un ID de cliente válido
            if(isset($_GET['id']) && is_numeric($_GET['id'])) {
                // Obtener el ID del cliente desde la URL
                $cliente_id = $_GET['id'];

                // Consultar la base de datos para obtener los detalles del cliente
                $query = "SELECT 
                    cl.nombre as nombre,
                    cl.cedula as cedula,
                    cl.numero as celular,
                    cl.correo as correo,
                    COUNT(c.id) AS cantidadCompras,
                    (cl.puntos) AS puntos,
                    IFNULL(SUM(c.valor), 0) AS total
                FROM clientes cl
                left JOIN compras c on c.user_id = cl.id WHERE cl.id = $cliente_id";
                $resultado = mysqli_query($conn, $query);

                // Verificar si se encontraron resultados
                if(mysqli_num_rows($resultado) > 0) {
                    $cliente = mysqli_fetch_assoc($resultado);
                    // Mostrar los detalles del cliente
                    echo '<h1>Perfil del Cliente</h1>';
                    echo '<p><b>Nombre:</b> ' . $cliente['nombre'] . '</p>';
                    echo '<p><b>Cédula:</b> ' . $cliente['cedula'] . '</p>';
                    echo '<p><b>Celular:</b> ' . $cliente['celular'] . '</p>';
                    echo '<p><b>Correo:</b> ' . $cliente['correo'] . '</p>';
                    echo '<p><b>Cantidad de Compras:</b> ' . $cliente['cantidadCompras'] . '</p>';
                    echo '<p><b>Puntos Acumulados:</b> ' . $cliente['puntos'] . '</p>';
                    echo '<p><b>Total:</b> ' . $cliente['total'] . '</p>';

                    // Continuar mostrando otros detalles del cliente según tu base de datos

                    // Botón para volver al CRUD
                    echo '<a href="crud.php" class="btn btn-danger">Volver</a>';
                } else {
                    echo '<p>No se encontraron datos para este cliente.</p>';
                }
            } else {
                echo '<p>ID de cliente no válido.</p>';
            }
            ?>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>

</html>
