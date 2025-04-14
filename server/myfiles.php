<?php
include "connect.php";

// start the session
session_start();
$response = ["success" => false, "message" => ""];

header('Content-Type: application/json');

$username = ($_SESSION["username"]);
$macID = "";

try {
    // Prepare the SQL command with proper LIKE syntax
    $stmt = $dbh->prepare("SELECT macID from users WHERE username = ?");
    // Bind the query with wildcard characters for pattern matching
    $success = $stmt->execute([$username]);
    if (!$success) {
        $response["message"] = "Random error bro i couldnt even tell you styll";
    } else {
        $results = $stmt->fetch();
        $macID = $results["macID"];
        try {
            // Prepare the SQL command with proper LIKE syntax
            $stmt = $dbh->prepare("SELECT * from mfiles WHERE macID = ?");
            // Bind the query with wildcard characters for pattern matching
            $success = $stmt->execute([$macID]);
            if (!$success) {
                $response["message"] = "Random error 2 bro i couldnt even tell you styll";
            } else {
                $useruploads = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $response["message"] = [$useruploads, $macID];
            }
        } catch (Exception $e) {
            $response["message"] = $e->getMessage();
        }
    }
} catch (Exception $e) {
    $response["message"] = $e->getMessage();
}


echo json_encode($response);
?>


