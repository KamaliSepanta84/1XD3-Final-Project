<?php
/**
 * This file deletes a given file from the uploads folder.
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

$filePath = __DIR__ . "/../uploads/" . basename($filename);

if (file_exists($filePath)) {
    if (unlink($filePath)) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Could not delete file from uploads folder"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "File does not exist"]);
}
?>
