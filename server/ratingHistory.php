<?php

header('Content-Type: application/json');
session_start();
include "./connect.php";

$filename = filter_input(INPUT_POST, "filename", FILTER_SANITIZE_SPECIAL_CHARS);

if ($filename === null || $filename === "") {
    die("ERROR: Invalid parameters!");
    exit();
}

if (!isset($_SESSION["username"])) {
    die("ERROR: No active session for user!");
    exit();
}

$username = $_SESSION["username"];
$response = ["rated" => false];

// get macID from username
$command = "SELECT macID FROM users WHERE username = ?";
$stmt = $dbh->prepare($command);
$success = $stmt->execute([$username]);

if ($success) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row && isset($row["macID"])) {
        $macID = $row["macID"];

        // Check if user already rated this file
        $command2 = "SELECT COUNT(*) FROM ratings WHERE `macID` = ? AND `filename` = ?";
        $stmt2 = $dbh->prepare($command2);
        $success2 = $stmt2->execute([$macID, $filename]);

        if ($success2) {
            $isRated = $stmt2->fetchColumn() > 0;
            $response["rated"] = $isRated;
        } else {
            die("ERROR: Failed to get the rating history from database!");
            exit();
        }
    } else {
        die("ERROR: macID not found for user!");
        exit();
    }
} else {
    die("ERROR: Failed to get the macID from database!");
    exit();
}

echo json_encode($response);
?>
