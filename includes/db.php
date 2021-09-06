<?php

    const DB_SERVER = "localhost";
    const DB_USER = "root";
    const DB_PW = "";
    const DB_NAME = "cms";

    $connection = mysqli_connect(DB_SERVER, DB_USER, DB_PW, DB_NAME);
    if(!$connection) {
        echo "Sin conexion con la BD";
    } 
?>

