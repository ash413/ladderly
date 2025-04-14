<?php
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *"); //ANGULAR
    header("Access-Control-Allow-Headers: Content-Type");
    header("Access-Control-Allow-Methods: GET");

    session_start();
    include("database.php");

    $username = $_SESSION["username"] ?? null;

    if(!$username) {
        echo json_encode(["Error"=>"user not logged in"]);
        exit;
    }

    $sql = "SELECT * FROM applications WHERE username = '$username' ";
    $result = mysqli_query($conn, $sql);

    $applications = [];

    while($row = mysqli_fetch_assoc($result)){
        $applications[] = $row;
    }

    echo json_encode($applications);

    mysqli_close($conn);
?>