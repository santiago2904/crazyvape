<?php
session_start();

if(!isset($_SESSION['usuario'])){
    echo'
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
    <!--
Project      : Datos de empleados con PHP, MySQLi y Bootstrap CRUD  (Create, read, Update, Delete) 
Author		 : Obed Alvarado
Website		 : http://www.obedalvarado.pw
Blog         : http://obedalvarado.pw/blog/
Email	 	 : info@obedalvarado.pw
-->
     <meta charset="UTF-8">
    <link rel="icon" href="./iconos/icono.ico" type="image/x-icon">
    <link rel="icon" href="./iconos/icono.ico" type="image/x-icon">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Agregar cliente</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-datepicker.css" rel="stylesheet">
    <link href="css/style_nav.css" rel="stylesheet">
    <style>
    .content {
        margin-top: 80px;
    }
    </style>

    <!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>

<body>
    <nav class="navbar navbar-default navbar-fixed-top">
        <?php include("nav.php");?>
    </nav>
    <div class="container">
        <div class="content">
            <h2>Agregar cliente</h2>
            <hr />

            <?php
            if(isset($_POST['add'])){
                $nombres = mysqli_real_escape_string($conn, strip_tags($_POST["nombres"]));
                $numero = mysqli_real_escape_string($conn, strip_tags($_POST["numero"]));
                $correo = mysqli_real_escape_string($conn, strip_tags($_POST["correo"]));
                $cedula = mysqli_real_escape_string($conn, strip_tags($_POST["cedula"]));

                // Verificar si el cliente ya existe por cédula
                $stmt = mysqli_prepare($conn, "SELECT * FROM clientes WHERE cedula = ?");
                mysqli_stmt_bind_param($stmt, "s", $cedula);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 0){
                    // El cliente no existe, realizar la inserción
                    $stmt_insert = mysqli_prepare($conn, "INSERT INTO clientes(nombre, numero, correo, cedula) VALUES (?, ?, ?, ?)");
                    mysqli_stmt_bind_param($stmt_insert, "siss", $nombres, $numero, $correo, $cedula);
                    $insert = mysqli_stmt_execute($stmt_insert);    

                    if($insert){
                        echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Bien hecho! Los datos han sido guardados con éxito.</div>';
                    } else {
                        echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error. No se pudo guardar los datos !</div>';
                        echo mysqli_error($conn); // Imprime el error de MySQL para depuración
                    }

                    mysqli_stmt_close($stmt_insert);
                } else {
                    // El cliente ya existe
                    echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error. El cliente ya existe!</div>';
                }

                mysqli_stmt_close($stmt);
            }
            ?>

            <form class="form-horizontal" action="" method="post">
                <div class="form-group">
                    <label class="col-sm-3 control-label">Nombres</label>
                    <div class="col-sm-4">
                        <input type="text" name="nombres" class="form-control" placeholder="Nombres" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Número</label>
                    <div class="col-sm-4">
                        <input type="text" name="numero" class="form-control" placeholder="Número" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Correo</label>
                    <div class="col-sm-4">
                        <input type="text" name="correo" class="form-control" placeholder="Correo" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Cédula</label>
                    <div class="col-sm-4">
                        <input type="text" name="cedula" class="form-control" placeholder="Cédula" required>
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-sm-3 control-label">&nbsp;</label>
                    <div class="col-sm-6">
                        <input type="submit" name="add" class="btn btn-sm btn-primary" value="Guardar datos">
                        <a href="index.php" class="btn btn-sm btn-danger">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap-datepicker.js"></script>
    <script>
    $('.date').datepicker({
        format: 'dd-mm-yyyy',
    })
    </script>
</body>

</html>