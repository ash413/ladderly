<?php
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *"); //ANGULAR
    header("Access-Control-Allow-Headers: ");
    header("Access-Control-Allow-Methods: POST/ PUT");

    session_start();
    include("database.php");

    $username = $_SESSION["username"] ?? null;
    if(!$username){
        echo json_encode(["Error"=> "user not logged in"]);
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

    if(!$user_id){
        echo json_encode(["Error"=> "user not found"]);
    }

    $company_name = $data->$company_name ?? null;
    $role_title = $data->role_title ?? null;
    $status = $data->status ?? null;
    $notes = $data->notes ?? null;

    $updates = [];
    if ($company_name) $updates[] = "company_name = '$company_name' ";
    if($role_title) $updates[] = "role_title = '$role_title' ";
    if($status) $updates[] = "status = '$status' ";
    if ($notes) $updates[] = "notes = '$notes' ";

    if(empty($updates)){
        echo json_encode(["Error"=> "no changes"]);
        exit;
    }

    $set_clause = implode(", ", $updates);

    $sql = "UPDATE applications SET $set_clause WHERE id='$app_id' AND user_id='$user_id' ";

    if(mysqli_query($conn, $sql)){
        echo json_encode(["message"=> "application updated"]);
    } else {
        echo json_encode(["Error"=> "application update failed"]);
    }

    mysqli_close($conn);
?>