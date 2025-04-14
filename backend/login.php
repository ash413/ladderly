<?php 
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *"); //ANGULAR
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Headers: Content-Type");

    include("database.php");

    $data = json_decode(file_get_contents("php://input"));

    $username = isset($data->username) ? filter_var($data->username, FILTER_SANITIZE_SPECIAL_CHARS): null;
    $password = isset($data->password) ? filter_var($data->password, FILTER_SANITIZE_SPECIAL_CHARS): null;

    if (empty($username) || empty($password)){
        echo json_encode(["Error" => "please provide username and password"]);
        exit;
    }

    $sql = "SELECT * FROM users WHERE username = '$username' ";
    $result = mysqli_query($conn, $sql);

    if ($user = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $user["password"])) {
            
            session_start();
            $_SESSION["username"] = $username;
            
            echo json_encode(["success" => "user logged in"]);
        } else {
            echo json_encode(["error" => "incorrect password"]);
        }
    } else {
        json_encode(["Error" => "user not found"]);
    }

    mysqli_close($conn);
?>