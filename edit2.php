<?php
session_start();

if (!isset($_SESSION['usuario'])) {
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
    <meta charset="UTF-8">
    <link rel="icon" href="./iconos/icono.ico" type="image/x-icon">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Datos de empleados</title>

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
        <?php include("nav.php"); ?>
    </nav>
    <div class="container">
        <div class="content">
            <h2>Datos Empleado &raquo; Editar datos</h2>
            <hr />

            <?php
            $id = mysqli_real_escape_string($conn, (strip_tags($_GET["id"], ENT_QUOTES)));
            $sql = mysqli_query($conn, "SELECT * FROM empleados WHERE id='$id'");
            if (mysqli_num_rows($sql) == 0) {
                header("Location: index.php");
            } else {
                $row = mysqli_fetch_assoc($sql);
            }
            if (isset($_POST['save'])) {


                $usuario = mysqli_real_escape_string($conn, (strip_tags($_POST["usuario"], ENT_QUOTES)));
                $cedula = mysqli_real_escape_string($conn, (strip_tags($_POST["cedula"], ENT_QUOTES)));
                $nombres = mysqli_real_escape_string($conn, (strip_tags($_POST["nombres"], ENT_QUOTES)));
                $celular = mysqli_real_escape_string($conn, (strip_tags($_POST["celular"], ENT_QUOTES)));
                $correo  = mysqli_real_escape_string($conn, (strip_tags($_POST["correo"], ENT_QUOTES)));
                $rol_id = mysqli_real_escape_string($conn, (strip_tags($_POST["rol_id"], ENT_QUOTES)));

                $Contrasena = mysqli_real_escape_string($conn, (strip_tags($_POST["Contrasena"], ENT_QUOTES)));

                $confirmContrasena = mysqli_real_escape_string($conn, (strip_tags($_POST["confirmContrasena"], ENT_QUOTES)));

                $verificar = mysqli_query($conn, "SELECT * FROM empleados WHERE  cedula = '$cedula' AND usuario = '$usuario'");

                if ((mysqli_num_rows($verificar) > 0) && ($cedula != $row['cedula'] || $usuario != $row['usuario'])) {
                    // Ya existe un empleado con la misma cédula y usuario
                    echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error, ya existe alguien con la misma cedula o usuario</div>';
                } else {
                    if ($Contrasena != $confirmContrasena) {
                        echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error, las contraseñas no coinciden.</div>';
                    } else {
                        try {
                            $update = mysqli_query($conn, "UPDATE empleados SET 
                        cedula = '$cedula', nombres='$nombres', celular='$celular', correo='$correo', rol_id='$rol_id', contrasena= '$confirmContrasena' WHERE id='$id'");
                            if ($update) {
                                echo '<script type="text/javascript">';
                                echo 'window.location.href = "edit2.php?id=' . $id . '&cambio=true";';
                                echo '</script>';
                                exit;
                            } else {
                                echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error, no se pudo guardar los datos.</div>';
                            }
                        } catch (\Throwable $th) {
                            echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error, no se pudo guardar los datos.</div>';
                        }
                    }
                }
            }

            ?>

            <form class="form-horizontal" id="editarForm" action="" method="post" onsubmit="return validarCorreo();">
                <div class="form-group">
                    <label class="col-sm-3 control-label">Cédula</label>
                    <div class="col-sm-4 input-group">
                        <input type="text" name="cedula" value="<?php echo $row['cedula']; ?>" class="form-control" placeholder="Cédula" required oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 11);">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Nombre</label>
                    <div class="col-sm-4 input-group">
                        <input type="text" name="nombres" value="<?php echo $row['nombres']; ?>" class="form-control" placeholder="Nombre" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Celular</label>
                    <div class="col-sm-4 input-group">
                        <input type="number" name="celular" value="<?php echo $row['celular']; ?>" class="form-control" placeholder="Número" required oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Contraseña</label>
                    <div class="col-sm-4 input-group">
                        <input type="password" name="Contrasena" value="<?php echo $row['contrasena']; ?>" class="form-control" placeholder="contraseña" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">confirmar Contraseña</label>
                    <div class="col-sm-4 input-group">
                        <input type="password" name="confirmContrasena" value="<?php echo $row['contrasena']; ?>" class="form-control" placeholder="contraseña" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">usuario</label>
                    <div class="col-sm-4 input-group">
                        <input type="text" name="usuario" value="<?php echo $row['usuario']; ?>" class="form-control" placeholder="contraseña" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Correo</label>
                    <div class="col-sm-4 input-group">
                        <input type="text" name="correo" value="<?php echo $row['correo']; ?>" class="form-control" placeholder="Correo" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Rol</label>
                    <div class="col-sm-4 input-group">
                        <select name="rol_id" class="form-control" required>
                            <option value="">Seleccionar Rol</option>
                            <option value="1" <?php if ($row['rol_id'] == 1) echo 'selected'; ?>>ADMIN</option>
                            <option value="2" <?php if ($row['rol_id'] == 2) echo 'selected'; ?>>Vendedor</option>
                            <!-- Agrega más opciones según sea necesario -->
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">&nbsp;</label>
                    <div class="col-sm-6">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#confirmarModal">Guardar</button>
                        <a href="crudEmpleados.php" class="btn btn-danger">Cancelar</a>
                    </div>
                </div>
            </form>

            <!-- Modal de Confirmación -->
            <div class="modal fade" id="confirmarModal" tabindex="-1" role="dialog" aria-labelledby="confirmarModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmarModalLabel">Confirmación</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            ¿Está seguro de que desea guardar los cambios?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" name="save" form="editarForm" class="btn btn-primary">Guardar cambios</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Fin Modal de Confirmación -->

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function validarCorreo() {
            var correo = document.getElementsByName("correo")[0].value;
            if (correo.indexOf("@") === -1) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Por favor, ingrese un correo válido.',
                });
                return false;
            }
            return true;
        }
    </script>
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