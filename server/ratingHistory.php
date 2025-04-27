<?php
/**
 * This file checks if a user ha already rated a file or not
 * Author: Sepanta Kamali
 */

// Set response type to JSON
header('Content-Type: application/json');
// Start session
session_start();
// Connect to database
include "./connect.php";

// Get and sanitize filename from POST request
$filename = filter_input(INPUT_POST, "filename", FILTER_SANITIZE_SPECIAL_CHARS);

//If filename does not exist or is invalid
if ($filename === null || $filename === "") {
    die("ERROR: Invalid parameters!");
    exit();
}

// Check if user session exists, if not throw error
if (!isset($_SESSION["username"])) {
    die("ERROR: No active session for user!");
    exit();
}

//set username to session username
$username = $_SESSION["username"];
//Set default response
$response = ["rated" => false];

// get macID from username
$command = "SELECT macID FROM users WHERE username = ?";
$stmt = $dbh->prepare($command);
$success = $stmt->execute([$username]);

if ($success) {
    //Fetch response
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    //If macID is found
    if ($row && isset($row["macID"])) {
        $macID = $row["macID"];

        // Check if user already rated this file
        $command2 = "SELECT COUNT(*) FROM ratings WHERE `macID` = ? AND `filename` = ?";
        $stmt2 = $dbh->prepare($command2);
        $success2 = $stmt2->execute([$macID, $filename]);

        if ($success2) {
             //Set rated to true if a rating exists
            $isRated = $stmt2->fetchColumn() > 0;
            $response["rated"] = $isRated;
        } else {
            // Throw error if rating query fails
            die("ERROR: Failed to get the rating history from database!");
            exit();
        }
    } else {
        // If macID not found, throw error
        die("ERROR: macID not found for user!");
        exit();
    }
} else {
    // If macID query fails, throw error
    die("ERROR: Failed to get the macID from database!");
    exit();
}

// Outpt response as JSON
echo json_encode($response);
?>
