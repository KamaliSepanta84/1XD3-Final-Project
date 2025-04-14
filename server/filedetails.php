<?php

include "connect.php";

session_start();


$macID = "";
$response = ["success" => false, "message" => ""];
$filedetails = ["path" => "", "coursecode" => "", "title" => "", "description" => ""];

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
            if ($value["is_currently_being_viewed"]) {
                $filedetails["path"] = $value["path"];
                $filedetails["title"] = $key;
            }
        }
    }
} catch (Exception $e) {
    $response["message"] = "Exception: " . $e->getMessage();
}

try {
    // Prepare the SQL command with proper LIKE syntax
    $stmt = $dbh->prepare("SELECT * from mfiles WHERE filetitle = ?");
    // Bind the query with wildcard characters for pattern matching
    $success = $stmt->execute([$filedetails["title"]]);

    if (!$success) {
        $response["message"] = "Error executing query.";
    } else {
        $results = $stmt->fetch();

        $filedetails["description"] = $results["description"];
        $filedetails["coursecode"] = $results["coursecode"];

        $response["message"] = $filedetails;

    }
} catch (Exception $e) {
    $response["message"] = "Exception: " . $e->getMessage();
}



// Send JSON response back to the client
header('Content-Type: application/json');
echo json_encode($response);

