<?php
    $db_server = "localhost";
    $db_user = "root";
    $db_pass = "nyxyPIXy#47";
    $db_name = "fullstackproj";
    $conn = "";

    try{
        $conn = mysqli_connect($db_server, 
                           $db_user, 
                           $db_pass, 
                           $db_name);
        #echo "you are connected";
    } catch (mysqli_sql_exception){
        echo "could not connect";
    }

    
?>