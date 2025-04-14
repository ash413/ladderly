<?php
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *"); //ANGULAR
    header("Access-Control-Allow-Headers: Content-Type");
    header("Access-Control-Allow-Methods: POST");

    session_start();
    include("database.php");

    $username = $_SESSION["username"] ?? null;

    $user_query = "SELECT id FROM users WHERE username = '$username' ";
    $userResult = mysqli_query($conn, $user_query);
    $userRow = mysqli_fetch_assoc($userResult);
    $user_id = $userRow["id"] ?? null;

    if (!$user_id) {
        echo json_encode(["error" => "User ID not found"]);
        exit;
    }

    $data = json_decode(file_get_contents("php://input"));

    $company_name = $data->company_name ?? null;
    $role_title = $data->role_title ?? null;
    $status = $data->status ?? "Applied";

    $sql = "INSERT INTO applications (user_id, company_name, role_title, status)
            VALUES ('$user_id', '$company_name', '$role_title', '$status')";

    mysqli_query($conn, $sql);

    echo json_encode(["message" => "Application added"]);

    mysqli_close($conn);
?>