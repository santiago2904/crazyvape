<?php
include ("conexion.php");
$cedula = $_POST['cedula_buscar'];
$cedula = (int) $cedula;

$consulta= "SELECT * FROM clientes WHERE id='$cedula'";
$ejecutar=mysqli_query($conn,$consulta);
$verFilas =mysqli_num_rows($ejecutar);
$fila = mysqli_fetch_array($ejecutar);

$puntos =  $fila[5];
echo $puntos;
$resultado=mysqli_query($conn,$consulta);
if($resultado){
    
   
    echo '
    <h1 class="usuario" >USUARIO REGISTRADO</h1>
     <table>
           
           <th>puntos</th>
           <td>'.$fila[5].'</td>
         </tr>
         </table>
         ';
         
}else{
    echo "<script>alert('No se puedo ingresar la venta'); 
    </script>";
}


?>