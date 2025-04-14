<?php
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *"); //ANGULAR
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Headers: Content-Type");

    include("database.php");

    session_start();
    session_destroy();

    mysqli_close($conn);

    echo json_encode(["message" => "logged out"]);

?>