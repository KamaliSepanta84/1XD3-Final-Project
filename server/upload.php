<?php
// Include the separate database connection file
include 'connect.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if a file was uploaded without errors
    if (isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {
        $target_dir = "uploads/"; // Directory for uploaded files
        $target_file = $target_dir . basename($_FILES["file"]["name"]);
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Allowed file types
        $allowed_types = ["jpg", "jpeg", "png", "gif", "pdf", "pptx", "zip", "mp3", "docx", "txt"];
        if (!in_array($file_type, $allowed_types)) {
            echo "Sorry, only specific file types are allowed.";
        } else {
            // Move the uploaded file to the specified directory
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                // File upload success, now store information in the database
                $filename = $_FILES["file"]["name"];
                $filesize = $_FILES["file"]["size"];
                $filetype = $_FILES["file"]["type"];

                try {
                    // Use prepared statements for security
                    $command = "INSERT INTO mfiles (filename, filesize, filetype) VALUES (:filename, :filesize, :filetype)";
                    $stmt = $dbh->prepare($command);
                    $stmt->bindParam(':filename', $filename);
                    $stmt->bindParam(':filesize', $filesize);
                    $stmt->bindParam(':filetype', $filetype);
                    
                    if ($stmt->execute()) {
                        echo "The file " . htmlspecialchars(basename($filename)) . " has been uploaded and stored in the database.";
                    } else {
                        echo "Sorry, there was an error storing file information in the database.";
                    }
                } catch (Exception $e) {
                    echo "Database error: " . $e->getMessage();
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        echo "No file was uploaded.";
    }
}
?>