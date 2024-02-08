<?php
include ("conexion.php");
echo '<link href="css/main.css" type="text/css" rel="stylesheet">';

  
$cedula = $_POST['cedula_buscar'];
$cedula = (int) $cedula;
$consulta= "SELECT * FROM clientes WHERE cedula='$cedula'";
$ejecutar=mysqli_query($conn,$consulta);
$verFilas =mysqli_num_rows($ejecutar);
$fila = mysqli_fetch_array($ejecutar);

if(!$ejecutar){
 echo "error";
}else
{
 if($verFilas==0){
    echo "<script>alert('El usuario no existe');
    window.location='/Diego/index.php#first'</script>";

 }else{
   for($i=0; $i<=$fila; $i++){
     echo '
     <h1 class="usuario" >USUARIO REGISTRADO</h1>
     <table>
           <th>ID</th>
           <td>'.$fila[0].'</td>
           <th>nombre</th>
           <td>'.$fila[1].'</td>
           <th>numero</th>
           <td>'.$fila[2].'</td>
           <th>correo</th>
           <td>'.$fila[3].'</td>
           <th>compras</th>
           <td>'.$fila[4].'</td>
           <th>puntos</th>
           <td>'.$fila[5].'</td>
           <th>Total</th>
           <td>'.$fila[6].'</td>
         </tr>
         </table>
      <tr>
      
      <input id="submit_button" class="volver" type="submit" onclick="volver()" value="volver" />
    
     ';
     echo "<script>
     function volver() {
        window.location='/Diego/index.php#second'
      }
      </script>";
     
    $fila = mysqli_fetch_array($ejecutar);
   }
 }

}
?>