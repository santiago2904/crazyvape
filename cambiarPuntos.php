<?php
include ("conexion.php");
$puntos_cambiar;
$bandera =0;
if (isset($_POST['puntos_cambiar'])) {
    $puntos_cambiar = $_POST['puntos_cambiar'];
    echo $puntos_cambiar;
    $constate ="SELECT puntosCambiar FROM puntoscambiar;";
    $consulta1=mysqli_query($conn,$constate);
    $verFilas =mysqli_num_rows($consulta1);
$fila = mysqli_fetch_array($consulta1);
$bandera=1;
echo $fila[0];
  }
 
  
  
 if($bandera==1){
    $consulta = "UPDATE puntoscambiar SET puntosCambiar = '$puntos_cambiar' where puntosCambiar= '$fila[0]'";
    $consulta2=mysqli_query($conn,$consulta);
    echo"<script> window.location='/Diego/index.php#first';</script>";
   
 }  
  


?>
