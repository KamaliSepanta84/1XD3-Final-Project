<?php
// DEBUGGING
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
include "./connect.php";

$filename = filter_input(INPUT_POST, "filename", FILTER_SANITIZE_SPECIAL_CHARS);
$response = ["rating" => 0];

if ($filename !== null && $filename !== ""){
    $command = "SELECT rating FROM mfiles WHERE `filename` = ?";
    $stmt = $dbh->prepare($command);
    $args = [$filename];
    $success = $stmt->execute($args);

    if ($success){
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row && isset($row["rating"])){
            $response["rating"] = $row["rating"];
        } else {
            die("Error: failed to get the average rating from database!");
        }
    } else {
        die("Error: failed to fetch rating data from the database");
    }
} else {
    die("ERROR: Invalid parameters!");
}

echo json_encode($response);
?>
