<?php

session_start();

include 'conexion.php';



if(isset($_SESSION['usuario'])){
    header("location: crudEmpleados.php");
}

$error = '';

// Obtenemos los valores del formulario
$usuario = $_POST['Usuario'];
$contrasena = $_POST['Clave'];

// Preparamos la consulta SQL con parámetros
$consulta = "SELECT * FROM empleados WHERE usuario=? AND contrasena=?";
$statement = mysqli_prepare($conn, $consulta);

// Vinculamos los parámetros a la consulta
mysqli_stmt_bind_param($statement, "ss", $usuario, $contrasena);

// Ejecutamos la consulta
mysqli_stmt_execute($statement);

// Obtenemos el resultado de la consulta
$resultado = mysqli_stmt_get_result($statement);



// Verificamos si se encontraron resultados
if(mysqli_num_rows($resultado) > 0){
    //$_SESSION ['usuario'] = $usuario;
    // El usuario está autenticado, redirigimos a la página de empleados
    header("location: crudEmpleados.php");
    exit;
} else {
    // El usuario no está autenticado, mostramos un mensaje de error y redirigimos al login
    echo '
    <script>
        alert("Usuario no existe, por favor verificar los datos ingresados.");
        window.location = "login2.php";
    </script>
    ';
    exit;
}

// Cerramos la conexión a la base de datos
mysqli_stmt_close($statement);
mysqli_close($conn);
?>