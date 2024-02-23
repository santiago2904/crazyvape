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
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Agregar Empleado</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-datepicker.css" rel="stylesheet">
    <link href="css/style_nav.css" rel="stylesheet">
    <style>
    .content {
        margin-top: 80px;
    }
    </style>
</head>

<body>
    <nav class="navbar navbar-default navbar-fixed-top">
        <?php include("nav.php");?>
    </nav>
    <div class="container">
        <div class="content">
            <h2>Agregar Nuevo Empleado</h2>
            <hr />

            <?php
            if (isset($_POST['save'])) {
                $cedula = mysqli_real_escape_string($conn, (strip_tags($_POST["cedula"], ENT_QUOTES)));
                $nombres = mysqli_real_escape_string($conn, (strip_tags($_POST["nombres"], ENT_QUOTES)));
                $celular = mysqli_real_escape_string($conn, (strip_tags($_POST["celular"], ENT_QUOTES)));
                $correo = mysqli_real_escape_string($conn, (strip_tags($_POST["correo"], ENT_QUOTES)));
                $rol_id = mysqli_real_escape_string($conn, (strip_tags($_POST["rol_id"], ENT_QUOTES)));
                $usuario = mysqli_real_escape_string($conn, (strip_tags($_POST["usuario"], ENT_QUOTES)));
                $contrasena = mysqli_real_escape_string($conn, (strip_tags($_POST["contrasena"], ENT_QUOTES)));
                $insert = mysqli_query($conn, "INSERT INTO empleados (cedula, nombres, celular, correo, rol_id, usuario, contrasena) VALUES ('$cedula', '$nombres', '$celular', '$correo', '$rol_id', '$usuario', '$contrasena')")
                or die(mysqli_error($conn));

                if ($insert) {
                    echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Empleado agregado correctamente.</div>';
                } else {
                    echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error, no se pudo agregar el empleado.</div>';
                }
            }
            ?>

            <form class="form-horizontal" action="" method="post" onsubmit="return validarCorreo();">
                <div class="form-group">
                    <label class="col-sm-3 control-label">Cédula</label>
                    <div class="col-sm-4">
                        <input type="text" name="cedula" class="form-control"
                            placeholder="Cédula" required oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 11);">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Nombre</label>
                    <div class="col-sm-4">
                        <input type="text" name="nombres" class="form-control"
                            placeholder="Nombre" required onkeypress="return soloLetras(event)">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Celular</label>
                    <div class="col-sm-4">
                        <input type="number" name="celular" class="form-control"
                            placeholder="Número" required oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Correo</label>
                    <div class="col-sm-4">
                        <input type="text" name="correo" class="form-control"
                            placeholder="Correo" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Rol</label>
                    <div class="col-sm-4">
                        <select name="rol_id" class="form-control" required>
                            <option value="">Seleccionar Rol</option>
                            <option value="1">ADMIN</option>
                            <option value="2">Vendedor</option>
                            <!-- Agrega más opciones según sea necesario -->
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Usuario</label>
                    <div class="col-sm-4 input-group">
                        <input type="text" name="usuario"  class="form-control" placeholder="Usuario" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Contraseña</label>
                    <div class="col-sm-4 input-group">
                        <input type="password" name="contrasena"  class="form-control" placeholder="Contraseña" required>
                    </div>
                </div>






                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-6">
                        <!-- Modal de Confirmación -->
                        <div class="modal fade" id="confirmarModal" tabindex="-1" role="dialog"
                            aria-labelledby="confirmarModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="confirmarModalLabel">Confirmación</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        ¿Está seguro de que desea agregar este empleado?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Cancelar</button>
                                        <button type="submit" name="save" class="btn btn-primary">Agregar
                                            empleado</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Fin Modal de Confirmación -->

                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                            data-target="#confirmarModal">Guardar</button>
                        <a href="crudEmpleados.php" class="btn btn-sm btn-danger">Cancelar</a>
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

    <script>
    function soloLetras(event) {
        var key = event.keyCode;
        return ((key >= 65 && key <= 90) || (key >= 97 && key <= 122) || key == 32 || key == 225 || key == 193 || key == 233 || key == 201 || key == 237 || key == 205 || key == 243 || key == 211 || key == 250 || key == 218 || key == 241 || key == 209 || key == 252 || key == 220 || key == 252 || key == 220 || key == 32 || key == 46 || key == 8);
    }
    </script>

    <script>
    function validarCorreo() {
        var correo = document.getElementsByName("correo")[0].value;
        if (correo.indexOf("@") === -1) {
            alert("Por favor, ingrese un correo válido.");
            return false;
        }
        return true;
    }
    </script>

</body>

</html>