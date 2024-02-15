<?php

session_start();

if(!isset($_SESSION['usuario'])){
    echo'
        <script>
            alert("Por favor iniciar sesión.");
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
    <!--
Project      : Datos de empleados con PHP, MySQLi y Bootstrap CRUD  (Create, read, Update, Delete) 
Author		 : Obed Alvarado
Website		 : http://www.obedalvarado.pw
Blog         : http://obedalvarado.pw/blog/
Email	 	 : info@obedalvarado.pw
-->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Latihan MySQLi</title>

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
            <h2>Datos del empleados &raquo; Agregar datos</h2>
            <hr />

            <?php
			if(isset($_POST['add'])){
				$codigo		     = mysqli_real_escape_string($con,(strip_tags($_POST["codigo"],ENT_QUOTES)));//Escanpando caracteres 
				$nombres		     = mysqli_real_escape_string($con,(strip_tags($_POST["nombres"],ENT_QUOTES)));//Escanpando caracteres 
				$lugar_nacimiento	 = mysqli_real_escape_string($con,(strip_tags($_POST["lugar_nacimiento"],ENT_QUOTES)));//Escanpando caracteres 
				$fecha_nacimiento	 = mysqli_real_escape_string($con,(strip_tags($_POST["fecha_nacimiento"],ENT_QUOTES)));//Escanpando caracteres 
				$direccion	     = mysqli_real_escape_string($con,(strip_tags($_POST["direccion"],ENT_QUOTES)));//Escanpando caracteres 
				$telefono		 = mysqli_real_escape_string($con,(strip_tags($_POST["telefono"],ENT_QUOTES)));//Escanpando caracteres 
				$puesto		 = mysqli_real_escape_string($con,(strip_tags($_POST["puesto"],ENT_QUOTES)));//Escanpando caracteres 
				$estado			 = mysqli_real_escape_string($con,(strip_tags($_POST["estado"],ENT_QUOTES)));//Escanpando caracteres 
				
			
 
				$cek = mysqli_query($con, "SELECT * FROM empleados WHERE codigo='$codigo'");
				if(mysqli_num_rows($cek) == 0){
						$insert = mysqli_query($con, "INSERT INTO empleados(codigo, nombres, lugar_nacimiento, fecha_nacimiento, direccion, telefono, puesto, estado)
															VALUES('$codigo','$nombres', '$lugar_nacimiento', '$fecha_nacimiento', '$direccion', '$telefono', '$puesto', '$estado')") or die(mysqli_error());
						if($insert){
							echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Bien hecho! Los datos han sido guardados con éxito.</div>';
						}else{
							echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error. No se pudo guardar los datos !</div>';
						}
					 
				}else{
					echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error. código exite!</div>';
				}
			}
			?>

            <form class="form-horizontal" action="" method="post">
                <div class="form-group">
                    <label class="col-sm-3 control-label">Código</label>
                    <div class="col-sm-2">
                        <input type="text" name="codigo" class="form-control" placeholder="Código" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Nombres</label>
                    <div class="col-sm-4">
                        <input type="text" name="nombres" class="form-control" placeholder="Nombres" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Lugar de nacimiento</label>
                    <div class="col-sm-4">
                        <input type="text" name="lugar_nacimiento" class="form-control"
                            placeholder="Lugar de nacimiento" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Fecha de nacimiento</label>
                    <div class="col-sm-4">
                        <input type="text" name="fecha_nacimiento" class="input-group date form-control" date=""
                            data-date-format="dd-mm-yyyy" placeholder="00-00-0000" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Dirección</label>
                    <div class="col-sm-3">
                        <textarea name="direccion" class="form-control" placeholder="Dirección"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Teléfono</label>
                    <div class="col-sm-3">
                        <input type="text" name="telefono" class="form-control" placeholder="Teléfono" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Puesto</label>
                    <div class="col-sm-3">
                        <input type="text" name="puesto" class="form-control" placeholder="Puesto" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Estado</label>
                    <div class="col-sm-3">
                        <select name="estado" class="form-control">
                            <option value=""> ----- </option>
                            <option value="1">Fijo</option>
                            <option value="2">Contratado</option>

                            <option value="3">Outsourcing</option>
                        </select>
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