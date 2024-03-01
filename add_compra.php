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

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>agregar compra</title>

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
            <h2>Agregar compra</h2>
            <hr />

            <?php
            date_default_timezone_set('America/Bogota');
            if (isset($_POST['add'])) {
                $cedula = mysqli_real_escape_string($conn, strip_tags($_POST["cedula"]));
                $valor = str_replace('.', '', mysqli_real_escape_string($conn, strip_tags($_POST["valor"])));
                $descripcion = mysqli_real_escape_string($conn, strip_tags($_POST["descripcion"]));
                $puntos = mysqli_real_escape_string($conn, strip_tags($_POST["puntos"]));
                $fecha = date("Y-m-d H:i:s");

                // Verificar si el cliente ya existe por cédula
                $consulta_existencia = mysqli_query($conn, "SELECT * FROM clientes WHERE cedula = '$cedula'");

                if (mysqli_num_rows($consulta_existencia) == 0) {
                    // La cédula ya está en uso, mostrar mensaje de error
                    echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>No hay un cliente registrado con esa cédula</div>';
                } else {
                    // hacerla insercion en la tabla compras y actualizar los puntos del cliente

                    $consulta_cliente = mysqli_fetch_array($consulta_existencia);
                    $id_cliente = $consulta_cliente['id'];
                    $puntos_cliente = $consulta_cliente['puntos'];

                    $consulta_puntos = mysqli_query($conn, "SELECT puntosCambiar, max_compras_diarias FROM condiciones");
                    $puntos_cambiar = mysqli_fetch_array($consulta_puntos);

                    $fechaDate = date("Y-m-d");
                    $consultaComprasDiarias = mysqli_query($conn, 'SELECT
                    COUNT(*) as cantidadCompras
                    FROM clientes cl
                    inner JOIN compras c on c.user_id = cl.id
                    WHERE cl.id = ' . $id_cliente . ' AND DATE(c.fecha) = "' . $fechaDate . '";');
                    $comprasDiariasCliente = mysqli_fetch_array($consultaComprasDiarias)[0];

                    if ($comprasDiariasCliente >= $puntos_cambiar[1]) {
                        echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>El cliente ya ha alcanzado el límite de compras diarias</div>';
                    } elseif (($puntos == 0) || !isset($puntos)) {

                        $insert = mysqli_query($conn, "INSERT INTO compras (user_id, valor, descripcion, fecha, punto_venta_id) VALUES ('$id_cliente', '$valor', '$descripcion', '$fecha', '1')");

                        // de la tabla condiciones obtener la columna puntosCambiar para saber el valor que equivale a un punto

                        $puntos_generados = $valor / $puntos_cambiar[0];


                        if ($insert) {
                            // Actualizar los puntos del cliente
                            $puntos_finales = $puntos_generados + $puntos_cliente;
                            $update = mysqli_query($conn, "UPDATE clientes SET puntos = '$puntos_finales' WHERE id = '$id_cliente'");
                            if ($update) {
                                echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Compra registrada con éxito</div>';
                                //terminar la ejecucion del script

                            } else {
                                echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error al actualizar los puntos del cliente</div>';
                            }
                        } else {
                            echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error al registrar la compra</div>';
                        }
                    } else {
                        if ($puntos_cliente < $puntos) {
                            echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>No tiene suficientes puntos para redimir</div>';
                        } else {
                            if ($puntos == 15 && $puntos_cliente >= 15) {

                                $bono = 10000;
                                $valor = $valor - $bono;
                                $insert = mysqli_query($conn, "INSERT INTO compras (user_id, valor, descripcion, fecha, punto_venta_id) VALUES ('$id_cliente', '$valor', '$descripcion', '$fecha', '1')");

                                $puntos_generados = $valor / $puntos_cambiar[0];

                                if ($insert) {
                                    // Actualizar los puntos del cliente
                                    $puntos_finales = $puntos_generados + $puntos_cliente - $puntos;
                                    $update = mysqli_query($conn, "UPDATE clientes SET puntos = '$puntos_finales' WHERE id = '$id_cliente'");
                                    if ($update) {
                                        echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Compra registrada con éxito: total a pagado ' . $valor . '</div>';
                                        //terminar la ejecucion del script

                                    } else {
                                        echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error al actualizar los puntos del cliente</div>';
                                    }
                                } else {
                                    echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error al registrar la compra</div>';
                                }
                            } elseif ($puntos == 25 && $puntos_cliente >= 25) {

                                $bono = 20000;
                                $valor = $valor - $bono;
                                $insert = mysqli_query($conn, "INSERT INTO compras (user_id, valor, descripcion, fecha, punto_venta_id) VALUES ('$id_cliente', '$valor', '$descripcion', '$fecha', '1')");

                                $puntos_generados = $valor / $puntos_cambiar[0];

                                if ($insert) {
                                    // Actualizar los puntos del cliente
                                    $puntos_finales = $puntos_generados + $puntos_cliente - $puntos;
                                    $update = mysqli_query($conn, "UPDATE clientes SET puntos = '$puntos_finales' WHERE id = '$id_cliente'");
                                    if ($update) {
                                        echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Compra registrada con éxito: total a pagar ' . $valor . '</div>';
                                        //terminar la ejecucion del script

                                    } else {
                                        echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error al actualizar los puntos del cliente</div>';
                                    }
                                } else {
                                    echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error al registrar la compra</div>';
                                }
                            } elseif ($puntos == 35 && $puntos_cliente >= 35) {
                                $bono = 30000;
                                $valor = $valor - $bono;
                                $insert = mysqli_query($conn, "INSERT INTO compras (user_id, valor, descripcion, fecha, punto_venta_id) VALUES ('$id_cliente', '$valor', '$descripcion', '$fecha', '1')");

                                $puntos_generados = $valor / $puntos_cambiar[0];

                                if ($insert) {
                                    // Actualizar los puntos del cliente
                                    $puntos_finales = $puntos_generados + $puntos_cliente - $puntos;
                                    $update = mysqli_query($conn, "UPDATE clientes SET puntos = '$puntos_finales' WHERE id = '$id_cliente'");
                                    if ($update) {
                                        echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Compra registrada con éxito: total a pagar ' . $valor . '</div>';
                                        //terminar la ejecucion del script

                                    } else {
                                        echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error al actualizar los puntos del cliente</div>';
                                    }
                                } else {
                                    echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error al registrar la compra</div>';
                                }
                            } else {
                                echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>No estás canjeando correctamente los puntos</div>';
                            }
                        }
                    }
                }
                unset($_POST["cedula"]);
                unset($_POST["valor"]);
                unset($_POST["descripcion"]);
                unset($_POST["puntos"]);

                $_POST["cedula"] = null;
                $_POST["valor"] = null;
                $_POST["descripcion"] = null;
                $_POST["puntos"] = null;

                mysqli_close($conn);
            }
            ?>

            <form class="form-horizontal" action="" method="post">
                <div class="form-group">
                    <label class="col-sm-3 control-label">Cedula</label>
                    <div class="col-sm-4">
                        <input type="text" name="cedula" class="form-control" placeholder="cedula" required oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 11);">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Valor</label>
                    <div class="col-sm-4">
                        <input type="text" name="valor" class="form-control" placeholder="valor" required id="valorInput" class="form-control" placeholder="valor" required oninput="formatoNumerico(this)">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">puntos a redimir</label>
                    <div class="col-sm-4">
                        <select name="puntos" class="form-control">
                            <option value="0" selected>0</option>
                            <option value="15">15 bono: 10.000</option>
                            <option value="25">25 bono: 20.000</option>
                            <option value="35">35 bono: 30.000</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Descripción</label>
                    <div class="col-sm-4">
                        <textarea class="form-control" name="descripcion" rows="3" style="max-height: 200px; max-width: 100%;min-width: 100%; min-height: 100px"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">&nbsp;</label>
                    <div class="col-sm-6">
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
                                        <p>¿Está seguro de que desea guardar los cambios?</p>
                                        <!-- Agregar un div para mostrar los detalles de la compra -->
                                        <div id="detallesCompra"></div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                        <button type="submit" name="add" class="btn btn-primary">Registrar compra</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">&nbsp;</label>
                            <div class="col-sm-6">
                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#confirmarModal">Registrar compra</button>
                                <a href="lista_compras.php" class="btn btn-sm btn-danger">Cancelar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <script src="js/bootstrap.min.js"></script>
    <script>
        function eliminarPuntos(input) {
            // Elimina cualquier punto del valor
            input.value = input.value.replace(/\./g, '');
        }

        function formatoNumerico(input) {
            // Elimina cualquier carácter que no sea un número
            let valor = input.value.replace(/[^0-9]/g, '');

            if (valor !== '') {
                // Convierte el valor a un número entero
                valor = parseInt(valor, 10);
                // Aplica el formato con puntos para separar los miles
                input.value = valor.toLocaleString();
            } else {
                // Si el valor no es válido, establece el valor como una cadena vacía
                input.value = '';
            }
        }
    </script>
    <script src="js/bootstrap-datepicker.js"></script>
    <script>
        $('.date').datepicker({
            format: 'dd-mm-yyyy',
        })
    </script>

    <script>
        $(document).ready(function() {
            $('#confirmarModal').on('show.bs.modal', function(event) {
                var modal = $(this);
                var cedula = $('input[name="cedula"]').val();
                var valor = $('input[name="valor"]').val();
                var puntos = $('input[name="puntos"]').val() || 0;
                var descripcion = $('textarea[name="descripcion"]').val();

                // Actualizar el contenido del div con los detalles de la compra
                modal.find('#detallesCompra').html('<p><strong>Cédula:</strong> ' + cedula + '</p><p><strong>Valor:</strong> ' + valor + '</p><p><strong>Puntos:</strong> ' + puntos + '</p><p><strong>Descripción:</strong> ' + descripcion + '</p>');
            });
        });
    </script>

</body>

</html>