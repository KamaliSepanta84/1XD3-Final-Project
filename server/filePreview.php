<?php
/**
 * This file updates the number of downloads of a file when 
 * they are downloaded from the file preview
 * Author: Sepanta Kamali
 */

// Set the response content type to JSON
header("Content-Type: application/json");
// Connect to database
include "./connect.php";

// Get the filename from post and sanitize it.
$filename = filter_input(INPUT_POST, "filename", FILTER_SANITIZE_SPECIAL_CHARS);

$response = ["download_count" => 0]; // default value is 0

// Check if filename exists
if ($filename !== null && $filename !== "") {
    // SQL command to select download number based on filename
    $command = "SELECT `download-number` FROM mfiles WHERE `filename` = ?";
    $stmt = $dbh->prepare($command);
    $args = [$filename];
    $success = $stmt->execute($args);

    // Check if query was executed successfully
    if ($success) {
        // Fetch the rows recieved from the SQL query
        $row = $stmt->fetch();
        // Uodate response with download number
        if ($row) {
            $response["download_count"] = $row["download-number"];
        }
    }

    // If query fails, throw error and quit
    else{
        die("ERROR: failed to fetch to number of downloads from database");
        exit();
    }
}
// If filename is missing or invalid, return error and quit
else{
    die("ERROR: Invalid parameters!");
    exit();
}

// Output the response as JSON
echo json_encode($response);
?>
