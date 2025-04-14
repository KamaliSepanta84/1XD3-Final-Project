<?php
    header('Content-Type: application/json');
    include "./connect.php";
    session_start();

    if (isset($_SESSION["username"])) {
        // Get the username from session
        $username = $_SESSION["username"];

        // Get macID from username
        $command = "SELECT macID FROM users WHERE username = ?";
        $stmt = $dbh->prepare($command);
        $args = [$username];
        $success = $stmt->execute($args);

        if ($success) {
            $macID = $stmt->fetch(PDO::FETCH_ASSOC)['macID'];

            if ($macID) {
                // Get number of uploads and downloads
                $updatedashboardCommand = "SELECT number_uploads, num_downloads FROM users WHERE macID = ?";
                $updatedashboardStmt = $dbh->prepare($updatedashboardCommand);
                $updatedashboardArgs = [$macID];
                $updatedashboardSuccess = $updatedashboardStmt->execute($updatedashboardArgs);

                if ($updatedashboardSuccess) {
                    $row = $updatedashboardStmt->fetch(PDO::FETCH_ASSOC);
                    $numberOfUploads = $row['number_uploads'];
                    $numberOfDownloads = $row['num_downloads'];
                    
                    echo json_encode([
                        "numberOfUploads" => $numberOfUploads,
                        "numberOfDownloads" => $numberOfDownloads
                      ]);                      
                } else {
                    die("ERROR: Failed to get download and upload numbers.");
                }
            } else {
                die("ERROR: Invalid macID!");
            }
        } else {
            die("ERROR: Failed to get macID from the database.");
        }
    } else {
        die("ERROR: There is no active session!");
    }
?>
