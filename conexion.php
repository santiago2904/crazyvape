<?php

    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD','1234');
    define('DB_NAME', 'crazy_vape');
    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD,DB_NAME);
    if($conn === false){
        die("ERROR EN LA CONEXION" . mysqli_connect_error());
    }

?>