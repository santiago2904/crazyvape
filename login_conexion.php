<?php
session_start();

include 'conexion.php';

// Verificar si el usuario ya ha iniciado sesión
if(isset($_SESSION['usuario'])){
    header("location: crud.php");
    exit; // Salir del script para evitar que se siga ejecutando
}

$error = '';

// Verificar si se ha enviado el formulario
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    // Validar y limpiar los datos de entrada del formulario
    $usuario = htmlspecialchars($_POST['Usuario']);
    $contrasena = htmlspecialchars($_POST['Clave']);
    
    // Preparar la consulta SQL con parámetros
    $consulta = "SELECT e.nombres as nombres, e.usuario as usuario, e.cedula as cedula, r.rol as rol, e.correo as correo FROM empleados as e JOIN roles r on e.rol_id = r.id WHERE e.contrasena = ? AND e.usuario = ?";
    $statement = mysqli_prepare($conn, $consulta);

    // Verificar si la preparación de la consulta fue exitosa
    if($statement){

        mysqli_stmt_bind_param($statement, "ss", $contrasena, $usuario);

        // Ejecutar la consulta
        if(mysqli_stmt_execute($statement)){
            // Obtener el resultado de la consulta
            $resultado = mysqli_stmt_get_result($statement);
            
            // Verificar si se encontraron resultados
            if(mysqli_num_rows($resultado) > 0){
                // Establecer la sesión de usuario
                $row = mysqli_fetch_assoc($resultado);
                $_SESSION['usuario'] = $row['usuario'];
                $_SESSION['rol'] = $row['rol']; // Guardar el rol del usuario en la sesión
                $_SESSION['nombres'] = $row['nombres']; // Guardar el nombre del usuario en la sesión
                $_SESSION['correo'] = $row['correo'];
                
                // Redirigir a la página de empleados
                header("location: crud.php");
                exit; // Salir del script para evitar que se siga ejecutando
            } else {
                // Mostrar un mensaje de error en la página de inicio de sesión
                $error = "Usuario o contraseña incorrectos. Por favor, verifique los datos ingresados.";
            }
        } else {
            // Manejar errores de ejecución de la consulta
            $error = "Error al ejecutar la consulta. Por favor, inténtalo de nuevo más tarde.";
        }
        
        // Cerrar la consulta preparada
        mysqli_stmt_close($statement);
    } else {
        // Manejar errores de preparación de la consulta
        $error = "Error al preparar la consulta. Por favor, inténtalo de nuevo más tarde.";
    }
}

// Cerrar la conexión a la base de datos
mysqli_close($conn);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="Styleindex.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Inicio de sesión</title>
</head>
<body>
    <form action="login_conexion.php" method="POST">
        <h1>INICIAR SESIÓN</h1>
        <hr>
        <?php 
            if (!empty($error)) {
        ?>
            <p class="error">
                <?php echo $error; ?>
            </p>
        <?php    
            }
        ?>
        <hr>
        <i class="fa-solid fa-user"></i>
        <label>Usuario</label>
        <input type="text" name="Usuario" placeholder="Nombre de usuario">
        <i class="fa-solid fa-unlock"></i>
        <label>Clave</label>
        <input type="password" name="Clave" placeholder="Clave">
        <hr>
        <button type="submit">Iniciar Sesión</button>
    </form>
</body>
</html>
