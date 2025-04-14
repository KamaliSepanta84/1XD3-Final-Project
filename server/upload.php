<?php

session_start();

header('Content-Type: application/json');
include './connect.php';

$response = ["success" => false, "message" => ""];
$macID = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($_FILES["file"]["name"]);
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $allowed_types = ["jpg", "jpeg", "png", "gif", "pdf", "pptx", "zip", "mp3", "docx", "txt"];
        if (!in_array($file_type, $allowed_types)) {
            $response["message"] = "Sorry, only specific file types are allowed.";
        } else {
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                $filename = $_FILES["file"]["name"];
                $filesize = $_FILES["file"]["size"];
                $filetype = $_FILES["file"]["type"];
                $filetitle = $_POST["filetitle"] ?? "";
                $coursecode = $_POST["coursecode"] ?? "";
                $description = $_POST["description"] ?? "";
                $upload_time = date("Y-m-d H:i:s");

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
                    }
                } catch (Exception $e) {
                    $response["message"] = $e->getMessage();
                }

                try {
                    $command = "INSERT INTO mfiles (macID, filename, filetitle, coursecode, filesize, filetype, description, upload_time) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                    $stmt = $dbh->prepare($command);
                    $args = [$macID, $filename, $filetitle, $coursecode, $filesize, $filetype, $description, $upload_time];
                    $success = $stmt->execute($args);

                    if ($success) {
                        $response["success"] = true;
                        $response["message"] = "The file " . htmlspecialchars($filename) . " has been uploaded and stored.";

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

                        $fileInfo = [
                            "name" => $filename,
                            "size" => $_FILES["file"]["size"],
                            "type" => $_FILES["file"]["type"],
                            "path" => "../uploads/" . basename($filename),
                            "upload_time" => date("Y-m-d H:i:s"),
                            "is_currently_being_viewed" => false
                        ];

                        $_SESSION["users"][$macID][$filetitle] = $fileInfo;

                    } else {
                        $response["message"] = "Database error while storing file information! Please try again later.";
                    }
                } catch (Exception $e) {
                    $response["message"] = "Database error: " . $e->getMessage();
                }
            } else {
                $response["message"] = "Error uploading your file.";
            }
        }
    } else {
        $response["message"] = "No file was uploaded.";
    }
}

echo json_encode($response);
?>