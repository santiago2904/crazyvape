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
    <title>Datos de clientes</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style_nav.css" rel="stylesheet">

    <style>
    .content {
        margin-top: 80px;
    }
    </style>

</head>

<body>
    <nav class="navbar navbar-default navbar-fixed-top">
        <?php include('nav.php');?>
    </nav>
    
    <div class="container">
        <div class="content">
            <h2>Lista de Empleados</h2>

            <hr />

            <?php
    if(isset($_GET['aksi']) == 'delete'){
    // escaping, additionally removing everything that could be (html/javascript-) code
    $id = mysqli_real_escape_string($con,(strip_tags($_GET["id"],ENT_QUOTES)));
    $result = mysqli_query($conn, "SELECT * FROM empleados WHERE cedula='$id'");
    if(mysqli_num_rows($result) == 0){
        echo '<div class="alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> No se encontraron datos.</div>';
    }else{
            $delete = mysqli_query($conn, "DELETE FROM empleados WHERE cedula='$id'");
        if($delete){
            echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Datos eliminado correctamente.</div>';
        }else{
            echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Error, no se pudo eliminar los datos.</div>';
        }
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
                        <th>cedula</th>
                        <th>Nombre</th>
                        <th>Celular</th>
                        <th>Correo</th>
                        <th>Rol</th>
                       
                    </tr>
                    <?php
if(isset($_GET['filter']) && !empty($_GET['filter']) && $_GET['filter'] != ""){

    $filter_value = mysqli_real_escape_string($conn, $_GET['filter']);
    
    $sql = mysqli_query($conn, "SELECT * FROM empleados WHERE cedula LIKE '$filter_value%'");

}else{
    $sql = mysqli_query($conn, "SELECT * FROM empleados ORDER BY nombres ASC LIMIT  10");
}
if(mysqli_num_rows($sql) == 0){
    echo '<tr><td colspan="8">No hay datos.</td></tr>';
}else{
    $no = 1;
    while($row = mysqli_fetch_assoc($sql)){
        echo '
        <tr>
                    <td>'.$no.'</td>
                    <td>'.$row['cedula'].'</td>
                    <td><a href="profile.php?id='.$row['id'].'"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> '.$row['nombres'].'</a></td>
                    <td>'.$row['celular'].'</td>
                    <td>'.$row['correo'].'</td>
                    <td>';  if(isset($_SESSION['rol']) && $_SESSION['rol'] == "ADMIN"){
                        echo '</td>
                        <td>
                            <a href="edit.php?id='.$row['id'].'" title="Editar datos" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
                            
                            <a href="index.php?aksi=delete&id='.$row['id'].'" title="Eliminar" onclick="return confirm(\'Esta seguro de borrar los datos '.$row['nombres'].'?\')" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                            </td>
                        </tr>';
                    } echo '
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
        <p>&copy; Desarrollado por santiago palacio <?php echo date("Y");?></p </center>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
</body>

</html>