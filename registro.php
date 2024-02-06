<?php
include ("conexion.php");

$nombre =$_POST["nombre"];
$id =$_POST["cedula"];
$email =$_POST["email"];
$numero =$_POST["numero"];
$cantidadCompras =0;
$total=0;
$puntos=0;
$insertar = "INSERT INTO clientes (id,nombre,numero,correo,cantidadCompras,puntos,total)
VALUES ('$id','$nombre','$numero','$email','$cantidadCompras','$puntos','$total')";



$resultado=mysqli_query($conn,$insertar);


if($resultado){
    echo "<script>alert('Se ha registrado el usuario con éxito');
    
    window.location='/Diego/index.php#second'</script>";

}else{
    echo "<script>alert('No se puede registrar'); window.history.go(-1);
    </script>";
}
?>