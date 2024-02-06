<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
  <link rel="stylesheet" href="css/main.css">
</head>

<body>

  <nav>
    <a href="#first"><img class="icons" src="./iconos/usuario-hombre.png" alt=""></a>
    <a href="#second"><img class="icons" src="./iconos/img3.png" alt=""></a>
    <a href="table-puntos.php"><img class="icons" src="./iconos/img2.png" alt=""></a>
    <a href="#fourth"></a>
  </nav>

  <div class='container'>

    <section id='first'>

      <div class="row">
        <form id="contact_form" action="buscar.php" method="POST" enctype="multipart/form-data">
          <label class="required" for="name">N° de cedula:</label><br />
          <input id="cedula_buscar" class="input" value="<?php
                                                          if (isset($cedula)) echo $cedula ?>" name="cedula_buscar" type="number" value="456789" size="30" /><br />

          <input id="submit_button" type="submit" value="Buscar cliente" />
      </div>

      </form>
      <div id="after_submit"></div>
      <form id="contact_form" action="registro.php" method="POST" enctype="multipart/form-data">
        <div class="row">
          <label class="required" for="name">N° de cedula:</label><br />
          <input id="name" class="input" value="<?php
                                                if (isset($cedula)) echo $cedula ?>" name="cedula" required type="number" value="" size="30" /><br />
          <span id="name_validation" class="error_message"></span>
        </div>
        <div class="row">
          <label class="required" for="name">Nombre completo:</label><br />
          <input id="name" class="input" value="<?php
                                                if (isset($nombre)) echo $nombre ?>" required name="nombre" type="text" value="" size="30" /><br />
          <span id="name_validation" class="error_message"></span>
        </div>
        <div class="row">
          <label class="required" for="email">email:</label><br />
          <input id="email" class="input" value="<?php
                                                  if (isset($email)) echo $email ?>" name="email" required type="text" value="" size="30" /><br />
          <span id="email_validation" class="error_message"></span>
        </div>
        <div class="row">
          <label class="required" for="email">Numero:</label><br />
          <input id="numero" class="input" value="<?php
                                                  if (isset($nombre)) echo $nombre ?>" name="numero" required type="text" value="" size="" /><br />
          <span id="email_validation" class="error_message"></span>
        </div>


        <div class="row">
          <label class="required" for="email">Puntos:</label><br />
          <input id="email" class="input" name="puntos" type="text" value="0" readonly="readonly" size="30" /><br />
          <span id="email_validation" class="error_message"></span>
        </div>
        <input id="submit_button" type="submit" value="Agregar cliente" />
      </form>

    </section>

    <section id='second'>
 
      <div class="row">
        <div class="contenedor-2">

          <form method="post" class="puntos">
            <label class="required" for="name">N° de cedula:</label><br />
            <input id="cedula_buscar" class="input" value="<?php
                                                            if (isset($cedula_buscar)) echo $cedula_buscar ?>" name="cedula_buscar" type="number" value="<?php if (isset($_montofinal)) echo $_montofinal; ?>" size="30" /><br />


            <?php
            include("conexion.php");
            $cedula = 0;

            if (empty($_POST['cedula_buscar'])) {
              $cedula = 0;
            }
            if (!empty($_POST['cedula_buscar'])) {
              $cedula = $_POST['cedula_buscar'];
              $cedula = (int) $cedula;


              $cedula = $_POST['cedula_buscar'];
              $cedula = (int) $cedula;

              $consulta = "SELECT * FROM clientes WHERE id='$cedula'";
              $ejecutar = mysqli_query($conn, $consulta);
              $verFilas = mysqli_num_rows($ejecutar);
              $fila = mysqli_fetch_array($ejecutar);

              $puntos =  $fila[5];

              $resultado = mysqli_query($conn, $consulta);
              if ($resultado) {
                echo '
<table class="tabla-puntos">
<th>N° Cédula</th>
<td>' . $fila[0] . '</td>     
<th>Puntos</th>
<td>' . $fila[5] . '</td>

</tr>
</table>
';
              } else {
                echo "NO HAY ";
              }
            }

            ?>
            <input id="submit_button" type="submit" value="Ver puntos del cliente" />
          </form>
        </div>
        <div class="contenedor">

          <form id="contact_form-2" action="compras.php" method="POST" enctype="multipart/form-data">
            <div class="row">
              <label class="required" for="name">N° de cedula:</label><br />
              <input id="name" class="input" value="<?php
                                                    if (isset($cedula)) echo $cedula ?>" name="cedula_buscar" required type="number" value="" size="30" /><br />
              <span id="name_validation" class="error_message"></span>
            </div>
            <div class="row">
              <label class="required" for="name">Monto:</label><br />
              <input id="name" class="input" value="" required name="monto" type="number" value="0" size="30" /><br />
              <span id="name_validation" class="error_message"></span>
            </div>



            <div class="row">
              <label class="required" for="email">Puntos a usar:</label><br />
              <input id="email" class="input" required name="puntos_usar" type="number" value="0" size="30" /><br />
              <span id="email_validation" class="error_message"></span>
            </div>


            <input id="submit_button-agregar" type="submit" name="Agregar" value="Agregar compra" />
           

            
          </form>
        </div>

    </section>

    <section id='third'>
    

    <section id='fourth'>
   

  </div>

  </section>
  </div>
  <script src='main.js'></script>
</body>

</html>