<?php
echo '<link href="css/table.css" type="text/css" rel="stylesheet">';
include ("conexion.php");
?>
<div class="padre">
    
    <div class="hijo">
   <form action="cambiarPuntos.php" method="POST">
       
   <label for="">Ingrese valor por puntos:</label><br>
   
   <input name="puntos_cambiar" class="shadwon" type="number" value="0" size="30" /><br />
             
  <input class="volver" value="enviar" name="" type="submit" placeholder="Cambiar">
 <?php
 $puntos_cambiar;

 ?>

</form>
<input value="volver" onclick="volver()" class="volverTabla" name="" type="submit" placeholder="Cambiar">
<?php


  echo "<script>
  function volver() {
     window.location='/Diego/index.php';
   }
   </script>";
?>
 
   </form>
   </div>
   <div class="page-container">
   
   <h1 class="listado" >LISTA DE CLIENTES</h1>
   <div class="table-container">
   <table class="table-cebra">
		<thead>
			<tr>
				<th class="sticky">Cedula</th>
				<th>Nombre</th>
				<th>Telefono</th>
				<th>Correo</th>
				<th>cantidad de compras</th>
        <th>puntos</th>
				<th>valor total de compras</th>
			</tr>
      </thead>
      
		
		   <tbody>
			<tr>
   <?php
  
  
    $consulta= "SELECT * FROM clientes";
    $ejecutar=mysqli_query($conn,$consulta);
    $verFilas =mysqli_num_rows($ejecutar);
    $fila = mysqli_fetch_array($ejecutar);
    for($i=0; $i<=$fila; $i++){
      echo '
      
				<td class="sticky">'.$fila[0].'</td>
				<td>'.$fila[1].'</td>
				<td>'.$fila[2].'</td>
				<td>'.$fila[3].'</td>
				<td>'.$fila[4].'</td>
        <td>'.$fila[5].'</td>
        <td>'.$fila[6].'</td>
			</tr>
	
     
      
      ';
      
     $fila = mysqli_fetch_array($ejecutar);
    }

    ?>
    	</tbody>
	</table>
    
    </div>
    
   </div>
  
    </section>