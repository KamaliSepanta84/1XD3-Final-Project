<?php

include "./connect.php";
header('Content-Type: application/json');

$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
$userEmail = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
$userPassword = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
$isParamOk = false;
$macID = "";

if ($username !== NULL && $username !== "" && $userEmail !== NULL && $userEmail !== false 
        && $userPassword !== NULL && $userPassword !== "") {
    $isParamOk = true;
    $macID = explode("@", $userEmail)[0];
}

if (!$isParamOk) {
    echo json_encode(["status" => "Fail", "message" => "Invalid input!"]);
    exit;
}

$response = ["status" => "Fail", "message" => ""];
$command = "SELECT * FROM users WHERE macID = ?"; // Fixed column name
$stmt = $dbh->prepare($command);
$args = [$macID];
$stmt->execute($args);

if ($stmt->rowCount() != 0) {
    $response["message"] = "This MacID already exists!";
} else {
    // Hash password
    $hashed_password = password_hash($userPassword, PASSWORD_DEFAULT);

    $command = "INSERT INTO users VALUES (?, ?, ?, ?)";
    $stmt = $dbh->prepare($command);
    $args = [$macID, $username, $userEmail, $hashed_password];
    $success = $stmt->execute($args);

    if ($success) {
        $response["status"] = "Success";
        $response["message"] = "User added successfully!";
    } else {
        $response["message"] = "Failed to add user!";
    }
}

echo json_encode($response);
?>
