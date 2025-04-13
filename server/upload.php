<?php
header('Content-Type: application/json');
include './connect.php';

$response = ["success" => false, "message" => ""];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {
        $target_dir = "uploads/";
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
                    $command = "INSERT INTO mfiles (filename, filetitle, coursecode, filesize, filetype, description, upload_time) VALUES (?, ?, ?, ?, ?, ?, ?)";
                    $stmt = $dbh->prepare($command);
                    $args = [$filename, $filetitle, $coursecode, $filesize, $filetype, $description, $upload_time];
                    $success = $stmt->execute($args);

                    if ($success) {
                        $response["success"] = true;
                        $response["message"] = "The file " . htmlspecialchars($filename) . " has been uploaded and stored.";
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
// header('Content-Type: application/json');
// include './connect.php';

// $response = ["success" => false, "message" => ""];

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     if (isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {
//         $target_dir = "uploads/";
//         $target_file = $target_dir . basename($_FILES["file"]["name"]);
//         $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

//         $allowed_types = ["jpg", "jpeg", "png", "gif", "pdf", "pptx", "zip", "mp3", "docx", "txt"];
//         if (!in_array($file_type, $allowed_types)) {
//             $response["message"] = "Sorry, only specific file types are allowed.";
//         } else {
//             if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
//                 $filename = $_FILES["file"]["name"];
//                 $filesize = $_FILES["file"]["size"];
//                 $filetype = $_FILES["file"]["type"];
//                 $filetitle = $_POST["filetitle"] ?? "";
//                 $coursecode = $_POST["coursecode"] ?? "";
//                 $description = $_POST["description"] ?? "";
//                 $upload_time = date("Y-m-d H:i:s");


//                 try { 
//                     $command = "INSERT INTO mfiles (filename, filetitle, coursecode, filesize, filetype, description, upload_time) VALUES (?, ?, ?, ?, ?, ?, ?)";
//                     $stmt = $dbh->prepare($command);
//                     $args = [$filename, $filetitle, $coursecode, $filesize, $filetype, $description, $upload_time];
//                     $success = $stmt->execute($args);

//                     if ($success) {
//                         $response["success"] = true;
//                         $response["message"] = "The file " . htmlspecialchars($filename) . " has been uploaded and stored.";
//                     } else {
//                         $response["message"] = "Database error while storing file information! Please try again later.";
//                     }
//                 } catch (Exception $e) {
//                     $response["message"] = "Database error: " . $e->getMessage();
//                 }
//             } else {
//                 $response["message"] = "Error uploading your file.";
//             }
//         }
//     } else {
//         $response["message"] = "No file was uploaded.";
//     }
// }

// echo json_encode($response);
?>