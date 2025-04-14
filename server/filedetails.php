<?php

include "connect.php";

session_start();
$macID = "";
$files = [];
$response = ["success" => false, "message" => ""];

try {
    // Prepare the SQL command with proper LIKE syntax
    $stmt = $dbh->prepare("SELECT macID from users WHERE username = ?");
    // Bind the query with wildcard characters for pattern matching
    $success = $stmt->execute([$_SESSION["username"]]);
    if (!$success) {
        $response["message"] = "Random error bro i couldnt even tell you";
    } else {
        $results = $stmt->fetch();
        $macID = $results["macID"];
        $files = $_SESSION["users"][$macID];
        $response["message"] = $files["Vector Space Aximos"];
    }
} catch (Exception $e) {
    $response["message"] = $e->getMessage();
}

echo json_encode($response);

