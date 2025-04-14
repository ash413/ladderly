<?php
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *"); //ANGULAR
    header("Access-Control-Allow-Headers: *");
    header("Access-Control-Allow-Methods: DELETE");

    session_start();
    include("database.php");

    $username = $_SESSION["username"] ?? null;
    if (!$username) {
        echo json_encode(["Error" => "user not logged in"]);
        exit;
    }

    $data = json_decode(file_get_contents("php://input"));
    $app_id = $data->id ?? null;
    
    if (!$app_id) {
        echo json_encode(["Error" => "no application id provided"]);
        exit;
    }

    $user_query = "SELECT id FROM users WHERE username = '$username' ";
    $userResult = mysqli_query($conn, $user_query);
    $userRow = mysqli_fetch_assoc($userResult);
    $user_id = $userRow["id"] ?? null;

    if (!$user_id) {
        echo json_encode(["Error" => "user not found"]);
        exit;
    }

    $sql = "DELETE FROM applications WHERE id = '$app_id' AND user_id = '$user_id' ";
    if (mysqli_query($conn, $sql)) {
        echo json_encode(["message" => "application deleted"]);
    } else {
        echo json_encode(["Error" => "failed to delete applications"]);
    }

    mysqli_close($conn);
?>