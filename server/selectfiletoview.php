<?php

include "connect.php";

session_start();

$clicked = filter_input(INPUT_POST, "clicked", FILTER_SANITIZE_SPECIAL_CHARS);
$filetitle = filter_input(INPUT_POST, "filetitle", FILTER_SANITIZE_SPECIAL_CHARS);

$macID = "";
$response = ["success" => false, "message" => ""];

try {
    // Prepare the SQL command with proper LIKE syntax
    $stmt = $dbh->prepare("SELECT macID from users WHERE username = ?");
    // Bind the query with wildcard characters for pattern matching
    $success = $stmt->execute([$_SESSION["username"]]);

    if (!$success) {
        $response["message"] = "Error executing query.";
    } else {
        $results = $stmt->fetch();
        $macID = $results["macID"];

        foreach ($_SESSION["users"][$macID] as $key => $value) {
            if ($key === $filetitle) {
                $_SESSION["users"][$macID][$key]["is_currently_being_viewed"] = true;
            } else {
                $_SESSION["users"][$macID][$key]["is_currently_being_viewed"] = false;
            }
        }
        $response["success"] = true;  // Indicating success
        $response["message"] = $_SESSION["users"][$macID];  // Indicating success

    }
} catch (Exception $e) {
    $response["message"] = "Exception: " . $e->getMessage();
}

// Send JSON response back to the client
header('Content-Type: application/json');
echo json_encode($response);

