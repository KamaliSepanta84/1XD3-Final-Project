<?php
/**
 * This file deletes a given file from the database.
 * Author: Marko Kosoric
 */
header('Content-Type: application/json');
include "./connect.php";

// Only accept POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
    exit;
}

// Start a session
session_start();

//Check if is admin
if (!isset($_SESSION["is_admin"]) || $_SESSION["is_admin"] !== true) {
    echo json_encode(["success" => false, "message" => "Unauthorized"]);
    exit;
}

$filename = filter_input(INPUT_POST, "filename", FILTER_SANITIZE_SPECIAL_CHARS);

if ($filename !== null && $filename !== ""){
    $command = "DELETE FROM ratings WHERE filename = ?";
    $stmt = $dbh->prepare($command);
    $args = [$filename];
    $success = $stmt->execute($args);
    if ($success){
        echo json_encode(["success" => true, "message" => "$filename succesfully deleted from ratings"]);
    }else{
        echo json_encode(["success" => false, "message" => "Ratings delete query not successfuly"]);
    }

}else{
    echo json_encode(["success" => false, "message" => "File does not exist"]);
}

?>