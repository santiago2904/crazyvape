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
     <meta charset="UTF-8">
    <link rel="icon" href="./iconos/icono.ico" type="image/x-icon">
    <link rel="icon" href="./iconos/icono.ico" type="image/x-icon">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Configuración</title>

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
            <h2>Configuración &raquo; Editar datos</h2>
            <hr />

            <?php
            $sql = mysqli_query($conn, "SELECT * FROM condiciones");
            $condiciones = mysqli_fetch_assoc($sql);

            if (isset($_POST['save'])) {
                $puntosCambiar = mysqli_real_escape_string($conn, $_POST['puntosCambiar']);
                $maxComprasDiarias = mysqli_real_escape_string($conn, $_POST['maxComprasDiarias']);

                $update = mysqli_query($conn, "UPDATE condiciones SET puntosCambiar = '$puntosCambiar', max_compras_diarias = '$maxComprasDiarias'");

                if ($update) {
                    echo '<script type="text/javascript">';
                    echo 'window.location.href = "configuracion.php?status=success";';
                    echo'</script>';
                    exit;
                } else {
                    echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error, no se pudo guardar los datos.</div>';
                }
            }

            if (isset($_GET['status']) && $_GET['status'] == 'success') {
                echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Los datos han sido guardados con éxito.</div>';
            }
            ?>

            <form class="form-horizontal" action="" method="post">
                <div class="form-group">
                    <label class="col-sm-3 control-label">Puntos a Cambiar</label>
                    <div class="col-sm-4 input-group">
                        <input type="text" name="puntosCambiar" value="<?php echo $condiciones['puntosCambiar']; ?>" class="form-control" required readonly>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-secondary" onclick="toggleReadOnly('puntosCambiar')">Editar</button>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Máx. Compras Diarias</label>
                    <div class="col-sm-4 input-group">
                        <input type="text" name="maxComprasDiarias" value="<?php echo $condiciones['max_compras_diarias']; ?>" class="form-control" required readonly>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-secondary" onclick="toggleReadOnly('maxComprasDiarias')">Editar</button>
                        </div>
                    </div>
                </div>
                            
                <div class="form-group">
                    <label class="col-sm-3 control-label">&nbsp;</label>
                    <div class="col-sm-6">
                        <button type="submit" name="save" class="btn btn-primary">Guardar</button>
                        <a href="configuracion.php" class="btn btn-danger">Cancelar</a>
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


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
