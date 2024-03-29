<?php

session_start();

if(!isset($_SESSION['usuario']) || $_SESSION['rol'] != "ADMIN" ){
    echo'
        <script>
            alert("Por favor iniciar sesión como un administrador.");
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
            <h2>Datos Cliente &raquo; Editar datos</h2>
            <hr />

            <?php
            // Escapando y eliminando posibles códigos (HTML/JavaScript) en el parámetro id
            $id = mysqli_real_escape_string($conn, (strip_tags($_GET["id"], ENT_QUOTES)));
            $sql = mysqli_query($conn, "SELECT * FROM clientes WHERE id='$id'");
            if (mysqli_num_rows($sql) == 0) {
                header("Location: index.php");
            } else {
                $row = mysqli_fetch_assoc($sql);
            }
            if (isset($_POST['save'])) {
                
                $cedula = mysqli_real_escape_string($conn, (strip_tags($_POST["cedula"], ENT_QUOTES)));
                $nombre = mysqli_real_escape_string($conn, (strip_tags($_POST["nombre"], ENT_QUOTES)));
                $numero = mysqli_real_escape_string($conn, (strip_tags($_POST["numero"], ENT_QUOTES)));
                $correo  = mysqli_real_escape_string($conn, (strip_tags($_POST["correo"], ENT_QUOTES)));

                $puntos  = mysqli_real_escape_string($conn, (strip_tags($_POST["puntos"], ENT_QUOTES)));

                $update = mysqli_query($conn, "UPDATE clientes SET 
                cedula = $cedula, nombre='$nombre', numero=$numero, correo='$correo', puntos = '$puntos' WHERE id=$id") 
                or die(mysqli_error($conn));

                if ($update) {
                    header("Location: edit.php?id=".$id."&cambio=true");
                } else {
                    echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error, no se pudo guardar los datos.</div>';
                }
            }

            if (isset($_GET['cambio']) == 'true') {
                echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Los datos han sido guardados con éxito.</div>';
            }
            ?>

            <form class="form-horizontal" action="" method="post">
                <div class="form-group">
                    <label class="col-sm-3 control-label">Cédula</label>
                    <div class="col-sm-4 input-group">
                        <input type="number" name="cedula" value="<?php echo $row['cedula']; ?>" class="form-control"
                            placeholder="Cédula" required readonly oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 11);">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-secondary"
                                onclick="toggleReadOnly('cedula')">Editar</button>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Nombre</label>
                    <div class="col-sm-4 input-group">
                        <input type="text" name="nombre" value="<?php echo $row['nombre']; ?>" class="form-control"
                            placeholder="Nombre" required readonly onkeypress="return soloLetras(event)">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-secondary"
                                onclick="toggleReadOnly('nombre')">Editar</button>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Número</label>
                    <div class="col-sm-4 input-group">
                        <input type="number" name="numero" value="<?php echo $row['numero']; ?>" class="form-control"
                            placeholder="Número" required readonly oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-secondary"
                                onclick="toggleReadOnly('numero')">Editar</button>
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
                    <label class="col-sm-3 control-label">Puntos</label>
                    <div class="col-sm-4 input-group">
                        <input type="text" name="puntos" value="<?php echo $row['puntos']; ?>" class="form-control"
                            placeholder="puntos" required readonly>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-secondary"
                                onclick="toggleReadOnly('puntos')">Editar</button>
                        </div>
                    </div>
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
                        <a href="crud.php" class="btn btn-sm btn-danger">Cancelar</a>
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