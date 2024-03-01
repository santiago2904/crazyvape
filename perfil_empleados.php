<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if(!isset($_SESSION['usuario']) || $_SESSION['rol'] != "ADMIN"){
    echo'
        <script>
            alert("Por favor iniciar sesión como un administrador.");
            window.location = "login2.php";
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
    <title>Perfil del Empleado</title>
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
            // Verificar si se ha proporcionado un ID de empleado válido
            if(isset($_GET['id']) && is_numeric($_GET['id'])) {
                // Obtener el ID del empleado desde la URL
                $empleado_id = $_GET['id'];

                // Consultar la base de datos para obtener los detalles del empleado
                $query = "SELECT e.nombres as nombre,
                e.cedula as cedula,
                e.celular as celular,
                e.correo as correo,
                r.rol as rol
                FROM empleados e
                inner JOIN roles r on r.id = e.rol_id WHERE e.id = $empleado_id";
                $resultado = mysqli_query($conn, $query);

                // Verificar si se encontraron resultados
                if(mysqli_num_rows($resultado) > 0) {
                    $empleado = mysqli_fetch_assoc($resultado);
                    // Mostrar los detalles del empleado
                    echo '<h1>Perfil del Empleado</h1>';
                    echo '<p><b>Nombre:</b> ' . $empleado['nombre'] . '</p>';
                    echo '<p><b>Cédula:</b> ' . $empleado['cedula'] . '</p>';
                    echo '<p><b>Celular:</b> ' . $empleado['celular'] . '</p>';
                    echo '<p><b>Correo:</b> ' . $empleado['correo'] . '</p>';
                    echo '<p><b>Rol:</b> ' . $empleado['rol'] . '</p>';

                    // Continuar mostrando otros detalles del empleado según tu base de datos
                } else {
                    echo '<p>No se encontraron datos para este empleado.</p>';
                }
            } else {
                echo '<p>ID de empleado no válido.</p>';
            }
            ?>
            <a href="crudEmpleados.php" class="btn btn-danger">Volver</a>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>

</html>
