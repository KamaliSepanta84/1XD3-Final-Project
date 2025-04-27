<?php
/**
 * This is the php script to upload files 
 * Author: Sepanta Kamali
 */

// Start a session
session_start();

// Set response content type to JSON
header('Content-Type: application/json');
// Connect to database
include './connect.php';

// Initialize default responses
$response = ["success" => false, "message" => ""];
$macID = "";

// Handle only POST requests
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if a file is uploaded with no error
    if (isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($_FILES["file"]["name"]);
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Allowed file types
        $allowed_types = ["jpg", "jpeg", "png", "gif", "pdf", "pptx", "zip", "mp3", "docx", "txt"];
        if (!in_array($file_type, $allowed_types)) {
            $response["message"] = "Sorry, only specific file types are allowed.";
        } else {
            // Try to move uploaded file to target directory
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                // Collect file details
                $filename = $_FILES["file"]["name"];
                $filesize = $_FILES["file"]["size"];
                $filetype = $_FILES["file"]["type"];
                $filetitle = $_POST["filetitle"] ?? "";
                $coursecode = $_POST["coursecode"] ?? "";
                $description = $_POST["description"] ?? "";
                $upload_time = date("Y-m-d H:i:s");

                try {
                    // Get macID of the currently logged-in user
                    // Prepare the SQL command with proper LIKE syntax
                    $stmt = $dbh->prepare("SELECT macID from users WHERE username = ?");
                    // Bind the query with wildcard characters for pattern matching
                    $success = $stmt->execute([$_SESSION["username"]]);
                    if (!$success) {
                        $response["message"] = "Random error bro i couldnt even tell you";
                    } else {
                        $results = $stmt->fetch();
                        $macID = $results["macID"];
                    }
                } catch (Exception $e) {
                    $response["message"] = $e->getMessage();
                }

                // Insert file details into the mfiles table
                try {
                    $command = "INSERT INTO mfiles (macID, filename, filetitle, coursecode, filesize, filetype, description, upload_time) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                    $stmt = $dbh->prepare($command);
                    $args = [$macID, $filename, $filetitle, $coursecode, $filesize, $filetype, $description, $upload_time];
                    $success = $stmt->execute($args);

                    if ($success) {
                        $response["success"] = true;
                        $response["message"] = "The file " . htmlspecialchars($filename) . " has been uploaded and stored.";

                        // SQL query to update user's number of uploads
                        $updateDatabaseCommand = "UPDATE users SET `number_uploads` = `number_uploads` + 1 WHERE macID = ?";
                        $updateDatabaseStmt = $dbh -> prepare($updateDatabaseCommand);
                        $updateDatabaseArgs = [$macID];
                        $updateDatabaseSuccess = $updateDatabaseStmt->execute($updateDatabaseArgs);

                        if (!isset($_SESSION["users"])) {
                            $_SESSION["users"] = [];
                        }
                        if (!isset($_SESSION["users"][$macID])) {
                            $_SESSION["users"][$macID] = [];
                        }
                        // Initialize fileInfo array with file info
                        $fileInfo = [
                            "name" => $filename,
                            "size" => $_FILES["file"]["size"],
                            "type" => $_FILES["file"]["type"],
                            "path" => "../uploads/" . basename($filename),
                            "upload_time" => date("Y-m-d H:i:s"),
                            "is_currently_being_viewed" => false
                        ];
                        // Add fileInfo to users session
                        $_SESSION["users"][$macID][$filetitle] = $fileInfo;

                    } else {
                        // If uploading file to server unsuccesful, throw error
                        $response["message"] = "Database error while storing file information! Please try again later.";
                    }
                } catch (Exception $e) {
                    // If database error, throw error
                    $response["message"] = "Database error: " . $e->getMessage();
                }
            } else {
                // If uploading file is unsuccesful, throw error
                $response["message"] = "Error uploading your file.";
            }
        }
    } else {
        // If no file is uploaded, throw error
        $response["message"] = "No file was uploaded.";
    }
}

// Output final JSON response
echo json_encode($response);
?>