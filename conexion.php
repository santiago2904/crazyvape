<?php

    define('DB_SERVER', '156.67.74.101');
    define('DB_USERNAME', 'u270512946_root');
    define('DB_PASSWORD','2283779.coM');
    define('DB_NAME', 'u270512946_paris');
    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD,DB_NAME);
    if($conn === false){
        die("ERROR EN LA CONEXION" . mysqli_connect_error());
    }

?>