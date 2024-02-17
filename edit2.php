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
        <?php include("nav.php");?>
    </nav>
    <div class="container">
        <div class="content">
            <h2>Datos Empleado &raquo; Editar datos</h2>
            <hr />

            <?php
            // Escapando y eliminando posibles códigos (HTML/JavaScript) en el parámetro id
            $id = mysqli_real_escape_string($conn, (strip_tags($_GET["id"], ENT_QUOTES)));
            $sql = mysqli_query($conn, "SELECT * FROM empleados WHERE id='$id'");
            if (mysqli_num_rows($sql) == 0) {
                header("Location: index.php");
            } else {
                $row = mysqli_fetch_assoc($sql);
            }
            if (isset($_POST['save'])) {
                
                $cedula = mysqli_real_escape_string($conn, (strip_tags($_POST["cedula"], ENT_QUOTES)));
                $nombres = mysqli_real_escape_string($conn, (strip_tags($_POST["nombres"], ENT_QUOTES)));
                $celular = mysqli_real_escape_string($conn, (strip_tags($_POST["celular"], ENT_QUOTES)));
                $correo  = mysqli_real_escape_string($conn, (strip_tags($_POST["correo"], ENT_QUOTES)));
                $rol_id = mysqli_real_escape_string($conn, (strip_tags($_POST["rol_id"], ENT_QUOTES)));
              

                $update = mysqli_query($conn, "UPDATE empleados SET 
                cedula = $cedula, nombres='$nombres', celular=$celular, correo='$correo', rol_id=$rol_id  WHERE id=$id") 
                or die(mysqli_error());

                if ($update) {
                    header("Location: edit2.php?id=".$id."&cambio=true");
                } else {
                    echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error, no se pudo guardar los datos.</div>';
                }
            }

            if (isset($_GET['cambio']) == 'true') {
                echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Los datos han sido guardados con éxito.</div>';
            }
            ?>

            <form class="form-horizontal" action="" method="post" onsubmit="return validarCorreo();">
                <div class="form-group">
                    <label class="col-sm-3 control-label">Cédula</label>
                    <div class="col-sm-4 input-group">
                        <input type="text" name="cedula" id="cedula" value="<?php echo $row['cedula']; ?>" class="form-control"
                            placeholder="Cédula" required oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 11);">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-secondary"
                                onclick="toggleReadOnly('cedula')">Editar</button>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Nombre</label>
                    <div class="col-sm-4 input-group">
                        <input type="text" name="nombres" value="<?php echo $row['nombres']; ?>" class="form-control"
                            placeholder="Nombre" required readonly onkeypress="return soloLetras(event)">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-secondary"
                                onclick="toggleReadOnly('nombres')">Editar</button>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Celular</label>
                    <div class="col-sm-4 input-group">
                        <input type="number" name="celular" value="<?php echo $row['celular']; ?>" class="form-control"
                            placeholder="Número" required oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-secondary"
                                onclick="toggleReadOnly('celular')">Editar</button>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">Correo</label>
                    <div class="col-sm-4 input-group">
                        <input type="text" name="correo" value="<?php echo $row['correo']; ?>" class="form-control"
                            placeholder="Correo" required readonly>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-secondary"
                                onclick="toggleReadOnly('correo')">Editar</button>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">rol_id</label>
                    <div class="col-sm-4 input-group">
                        <select name="rol_id" id="rol_id" class="form-control" required>
                            <option value="">Seleccionar Rol</option>
                            <option value="1">Rol 1</option>
                            <option value="2">Rol 2</option>
                            <!-- Agrega más opciones según sea necesario -->
                        </select>
                    </div>
                </div>
                <div class="form-group">
                
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">&nbsp;</label>
                    <div class="col-sm-6">
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
                                        ¿Está seguro de que desea guardar los cambios?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Cancelar</button>
                                        <button type="submit" name="save" class="btn btn-primary">Guardar
                                            cambios</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Fin Modal de Confirmación -->

                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                            data-target="#confirmarModal">Guardar datos</button>
                        <a href="crudEmpleados.php" class="btn btn-sm btn-danger">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
    function toggleReadOnly(fieldName) {
        var inputField = document.getElementsByName(fieldName)[0];
        inputField.readOnly = !inputField.readOnly;
    }
    </script>

    <script>
    function soloLetras(event) {
        var key = event.keyCode;
        return ((key >= 65 && key <= 90) || (key >= 97 && key <= 122) || key == 32 || key == 225 || key == 193 || key == 233 || key == 201 || key == 237 || key == 205 || key == 243 || key == 211 || key == 250 || key == 218 || key == 241 || key == 209 || key == 252 || key == 220 || key == 252 || key == 220 || key == 32 || key == 46 || key == 8);
    }
    </script>
    
    
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
   
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    function validarFormulario() {
        var rolId = document.getElementById("rol_id").value;
        if (rolId === "") {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Por favor, ingrese un Rol.',
            });
            return f            return false; // Evita que el formulario se envíe
        }
        return true; // Permite que el formulario se envíe si se ha seleccionado un rol
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
