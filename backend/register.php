<?php
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *"); //ANGULAR
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Headers: Content-Type");

    include("database.php");

    //JSON BODY frontend
    $data = json_decode(file_get_contents("php://input"));

    $username = isset($data->username) ? filter_var($data->username, FILTER_SANITIZE_SPECIAL_CHARS) : null;
    $password = isset($data->password) ? filter_var($data->password, FILTER_SANITIZE_SPECIAL_CHARS) : null;

    if(empty($username) || empty($password)){
        echo json_encode(["error" => "Please provide username and password"]);
        exit;
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$hash')";

        
    try{
        mysqli_query($conn, $sql);
        
        session_start();
        $_SESSION["username"] = $username;
        
        echo json_encode(["error" => "user registered"]);
    } catch(mysqli_sql_exception){
        echo json_encode(["Error" => "username already taken"]);
    }



    mysqli_close($conn);
?>