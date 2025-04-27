<?php
/**
 * This file stores the username in a session when the user signs up
 * Author: Sepanta Kamali
 */

// Start a session
session_start();

// Set response type to JSON
header('Content-Type: application/json');
// Connect to database 
include "connect.php";

// Get and sanitize username, validate email, sanitize password
$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
//Initialize macID and response
$macID;
$response = ["status" => "fail", "message" => ""];
//Initialize and set default value
$isParamOk = false;

// Check if all required parameters are provided and valid
if ($username !== null && $username !== "" && $email !== null && $email !== false
    && $password !== null && $password !== ""){
    $isParamOk = true;
}

/**
 * Password validation function
 * @param string $password | Hashed password
 * @return string Validation error messages (empty string if valid)
 */
function validatePassword($password) {
    $result = "";

    $isIncludeUpper = false;
    $isIncludeLower = false;
    $isIncludeSpecial = false;
    $isIncludeDigit = false;
    $isLongEnough = strlen($password) >= 6;

    // Check each character in the password
    for ($i = 0; $i < strlen($password); $i++) {
        if (ctype_lower($password[$i])) $isIncludeLower = true;
        if (ctype_upper($password[$i])) $isIncludeUpper = true;
        if (!ctype_alnum($password[$i])) $isIncludeSpecial = true;
        if (ctype_digit($password[$i])) $isIncludeDigit = true;
    }

    // Error messages if password rules are not met
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

// If parameters are good, proceed
if ($isParamOk) {
    // Extract macID from email (everything before "@")
    $macID = explode("@", $email)[0];

    // Validate password
    $validationMsg = validatePassword($password);
    if (!empty($validationMsg)) {
        $response["status"] = "InvPass"; // change the status to Invalide Password
        $response["message"] = $validationMsg;
        echo json_encode($response);
        exit();
    }

    // Check if macID already exists in the database
    $command = "SELECT * FROM users WHERE macID = ?";
    $stmt = $dbh->prepare($command);
    $args = [$macID];
    $success = $stmt->execute($args);

    if ($success) {
        // If user already exists, suggest logging in
        if ($stmt->rowCount() != 0){
            $response["message"] = "This MacID already exists! Please log in!";
        } else {
            // If user doesn't exist, insert new user
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
                 // If insert fails, return error
                $response["message"] = "Failed to add user!";
            }
        }
    } else {
        // If SELECT query fails, return errror
        $response["message"] = "Failed to get user data from database.";
    }
} else {
    // If parameters are invalid, return error
    $response["message"] = "Invalid parameters!";
}

// Output response as JSON
echo json_encode($response);
?>
