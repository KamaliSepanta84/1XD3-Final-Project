<?php
// Start a session
session_start();

header('Content-Type: application/json');
include "connect.php";

$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
$macID;
$response = ["status" => "fail", "message" => ""];

$isParamOk = false;

if ($username !== null && $username !== "" && $email !== null && $email !== false
    && $password !== null && $password !== ""){
    $isParamOk = true;
}

// Password validation function
function validatePassword($password) {
    $result = "";

    $isIncludeUpper = false;
    $isIncludeLower = false;
    $isIncludeSpecial = false;
    $isIncludeDigit = false;
    $isLongEnough = strlen($password) >= 6;

    for ($i = 0; $i < strlen($password); $i++) {
        if (ctype_lower($password[$i])) $isIncludeLower = true;
        if (ctype_upper($password[$i])) $isIncludeUpper = true;
        if (!ctype_alnum($password[$i])) $isIncludeSpecial = true;
        if (ctype_digit($password[$i])) $isIncludeDigit = true;
    }

    if (!$isLongEnough) {
        $result .= "Password must be at least 6 characters long.\n";
    }
    if (!$isIncludeLower) {
        $result .= "There must be at least one lowercase letter.\n";
    }
    if (!$isIncludeUpper) {
        $result .= "There must be at least one uppercase letter.\n";
    }
    if (!$isIncludeDigit) {
        $result .= "There must be at least one digit.\n";
    }
    if (!$isIncludeSpecial) {
        $result .= "There must be at least one special character.\n";
    }

    return $result; // If empty, it's valid
}

if ($isParamOk) {
    $macID = explode("@", $email)[0];

    // Validate password
    $validationMsg = validatePassword($password);
    if (!empty($validationMsg)) {
        $response["status"] = "InvPass"; // change the status to Invalide Password
        $response["message"] = $validationMsg;
        echo json_encode($response);
        exit();
    }

    $command = "SELECT * FROM users WHERE macID = ?";
    $stmt = $dbh->prepare($command);
    $args = [$macID];
    $success = $stmt->execute($args);

    if ($success) {
        if ($stmt->rowCount() != 0){
            $response["message"] = "This MacID already exists! Please log in!";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $command = "INSERT INTO users (macID, username, email, password) VALUES (?, ?, ?, ?)";
            $stmt = $dbh->prepare($command);
            $args = [$macID, $username, $email, $hashed_password];
            $success = $stmt->execute($args);

            if ($success){
                $response["status"] = "success";
                $response["message"] = "User added successfully!";
                $_SESSION["username"] = $username;
            } else {
                $response["message"] = "Failed to add user!";
            }
        }
    } else {
        $response["message"] = "Failed to get user data from database.";
    }
} else {
    $response["message"] = "Invalid parameters!";
}

echo json_encode($response);
?>
