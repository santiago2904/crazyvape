<?php
    include 'conexion.php';
    $usuario = $_POST['Usuario'];
    $contrasena = $_POST['Clave'];

    $validar_login = mysqli_query($conexion, "SELECT * FROM empleados WHERE usuario='$usuario' and contrasena='$contrasena'");

    if(mysqli_num_rows($validar_login) > 0){
        header("location: ../crudEmpleados.php");
        exit;
    }else{
        echo'
        <script>
            alert("Usuario no existe, por favor verificar los datos ingresados. ");
            window.location = "../login2.php";
        </script>
        ';
        exit;
    }



?>