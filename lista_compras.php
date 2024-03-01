<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    echo '
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
    <title>Compras</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style_nav.css" rel="stylesheet">

    <style>
        .content {
            margin-top: 80px;
        }

        .acciones-cell {
            width: 150px;
            /* Mismo ancho que la columna de encabezado */
        }

        .acciones-buttons {
            display: flex;
            justify-content: space-between;
        }
    </style>

</head>

<body>
    <nav class="navbar navbar-default navbar-fixed-top">
        <?php include('nav.php'); ?>
    </nav>
    <script>
        // Obtén el elemento por su ID
        var listaCompras = document.getElementById("comprasLista");
        var listaClientes = document.getElementById("listaClientes");
        var listaEmpleados = document.getElementById("listaEmpleados");

        listaCompras.classList.add("active");
        listaClientes.classList.remove("active");
        listaEmpleados.classList.remove("active");
    </script>
    <div class="container">
        <div class="content">
            <h2>Lista de Compras</h2>
            <hr />

            <?php
            if (isset($_GET['aksi']) == 'delete') {
                // escaping, additionally removing everything that could be (html/javascript-) code
                $id = mysqli_real_escape_string($conn, (strip_tags($_GET["id"], ENT_QUOTES)));

                $delete_compra = mysqli_query($conn, "DELETE FROM compras WHERE id='$id'");

                if ($delete_compra) {
                    echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>compra eliminada</div>';
                } else {
                    echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Error, no se pudo eliminar los datos.</div>';
                }
            }
            ?>

            <form class="form-inline" method="get">
                <div class="form-group">
                    <label for="cedula" style="margin-right: 10px;">Filtrar por Cédula:</label>
                    <input type="text" name="filter" id="cedula" class="form-control" placeholder="Ingrese la cédula">
                </div>
                <button type="submit" class="btn btn-primary" style="margin-left: 10px;">Buscar</button>
            </form>
            <br />
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <tr>
                        <th>No</th>
                        <th>Cédula</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Fecha</th>
                        <th>Valor</th>
                        <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] == "ADMIN") : ?>
                            <th class="acciones-cell">Acciones</th>
                        <?php endif; ?>
                    </tr>
                    <?php
                    if (isset($_GET['filter']) && !empty($_GET['filter']) && $_GET['filter'] != "") {

                        $filter_value = mysqli_real_escape_string($conn, $_GET['filter']);

                        $sql = mysqli_query($conn, "SELECT
        cl.id as clienteId,
        c.id as compraId,
        c.valor as valor,
        IFNULL(c.descripcion, 'sin descripción') AS descripcion,
        c.fecha as fecha,
        cl.cedula as cedula,
        cl.nombre as nombre
    FROM compras c
    INNER JOIN clientes cl on c.user_id = cl.id
    WHERE cl.cedula LIKE '$filter_value%'
    GROUP BY compraId, fecha
    ORDER BY fecha DESC LIMIT  10;");
                    } else {

                        $sql = mysqli_query($conn, "SET SESSION sql_mode = ''");

                        $sql = mysqli_query($conn, "SELECT
        cl.id as clienteId,
        c.id as compraId,
        c.valor as valor,
        IFNULL(c.descripcion, 'sin descripción') AS descripcion,
        c.fecha as fecha,
        cl.cedula as cedula,
        cl.nombre as nombre
    FROM compras c
    INNER JOIN clientes cl on c.user_id = cl.id
    GROUP BY compraId, fecha
    ORDER BY fecha DESC LIMIT  10;");
                    }
                    if (mysqli_num_rows($sql) == 0) {
                        echo '<tr><td colspan="8">No hay datos.</td></tr>';
                    } else {
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($sql)) {
                            echo '
        <tr>
                    <td>' . $no . '</td>
                    <td>' . $row['cedula'] . '</td>
                    <td><a href="perfil_cliente.php?id=' . $row['clienteId'] . '"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> ' . utf8_decode($row['nombre']) . '</a></td>
                    <td>' . $row['descripcion'] . '</td>
                    <td>' . $row['fecha'] . '</td>
                    <td>' . $row['valor'] . '</td>
                    <td>';
                            if (isset($_SESSION['rol']) && $_SESSION['rol'] == "ADMIN") {
                                echo '<div class="acciones-buttons">
                            <a href="lista_compras.php?aksi=delete&id=' . $row['compraId'] . '" title="Eliminar" onclick="return confirm(\'Esta seguro de borrar esta compra de ' . $row['nombre'] . '?\')" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                            </div>';
                            }
                            echo '
        </td>
        </tr>';

                            $no++;
                        }
                    }
                    ?>
                </table>
            </div>

        </div>
    </div>
    <center>
        <p>&copy; Desarrollado por santiago palacio <?php echo date("Y"); ?></p </center>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
</body>

</html>