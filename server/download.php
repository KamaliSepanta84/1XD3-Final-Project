<?php

include "./connect.php";
session_start();

if (isset($_SESSION["username"])) {
    // Get the username from session
    $username = $_SESSION["username"];
    $filename = filter_input(INPUT_POST, "filename", FILTER_SANITIZE_SPECIAL_CHARS);

    if ($filename === "" || $filename === null) {
        die("ERROR: Invalid parameters for filename");
    }

    else{
        $mfilesCommand = "UPDATE mfiles SET `download-number` = `download-number` + 1 WHERE filename = ?";
        $mfilesStmt = $dbh->prepare($mfilesCommand);
        $mfilesArgs = [$filename];
        $mfilesSuccess = $mfilesStmt->execute($mfilesArgs);

        if (!$mfilesSuccess){
            die("ERROR: failed to update number of downloads in the database!");
        }
    }
    // Prepare SQL to fetch macID
    $command = "SELECT macID FROM users WHERE username = ?";
    $stmt = $dbh->prepare($command);
    $args = [$username];
    $success = $stmt->execute($args);

    if ($success) {
        // Fetch macID from the result
        $macID = $stmt->fetch(PDO::FETCH_ASSOC)['macID'];

        // If macID is valid, update the download count
        if ($macID) {
            $updateDatabaseCommand = "UPDATE users SET num_downloads = num_downloads + 1 WHERE macID = ?";
            $updateDatabaseStmt = $dbh->prepare($updateDatabaseCommand);
            $updateDatabaseArgs = [$macID];
            $updateDatabaseSuccess = $updateDatabaseStmt->execute($updateDatabaseArgs);

            if (!$updateDatabaseSuccess) {
                die("ERROR: Failed to update the download count.");
            }
        } else {
            die("ERROR: Invalid macID.");
        }
    } else {
        die("ERROR: Failed to get the macID from the database.");
    }
} else {
    die("ERROR: There is no active session!");
}
?>

 <?php

// include "./connect.php";
// session_start();

// if (isset($_SESSION["username"])) {
//     // Get the username from session
//     $username = $_SESSION["username"];
//     $filename = $_POST["filename"];

//     if ($filename === "" || $filename === null) {
//         die("ERROR: Invalid parameters for filename");
//     }

//     else{
//         $mfilesCommand = "UPDATE mfiles SET `download-number` = `download-number` + 1 WHERE filename = ?";
//         $mfilesStmt = $dbh->prepare($mfilesCommand);
//         $mfilesArgs = [$filename];
//         $mfilesSuccess = $mfilesStmt->execute($mfilesArgs);

//         if (!$mfilesSuccess){
//             die("ERROR: failed to update number of downloads in the database!");
//         }
//     }
//     // Prepare SQL to fetch macID
//     $command = "SELECT macID FROM users WHERE username = ?";
//     $stmt = $dbh->prepare($command);
//     $args = [$username];
//     $success = $stmt->execute($args);

//     if ($success) {
//         // Fetch macID from the result
//         $macID = $stmt->fetch(PDO::FETCH_ASSOC)['macID'];

//         // If macID is valid, update the download count
//         if ($macID) {
//             $updateDatabaseCommand = "UPDATE users SET num_downloads = num_downloads + 1 WHERE macID = ?";
//             $updateDatabaseStmt = $dbh->prepare($updateDatabaseCommand);
//             $updateDatabaseArgs = [$macID];
//             $updateDatabaseSuccess = $updateDatabaseStmt->execute($updateDatabaseArgs);

//             if (!$updateDatabaseSuccess) {
//                 die("ERROR: Failed to update the download count.");
//             }
//         } else {
//             die("ERROR: Invalid macID.");
//         }
//     } else {
//         die("ERROR: Failed to get the macID from the database.");
//     }
    
//     $downloadsCommand = "SELECT filename FROM downloads WHERE username = ? AND filename = ?";
//     $downloadsStmt = $dbh->prepare($downloadsCommand);
//     $downloadsArgs = [$username, $filename];
//     $downloadsSuccess = $downloadsStmt->execute($downloadsArgs);

//     if ($downloadsSuccess) {
//         $row = $downloadsStmt->fetch(PDO::FETCH_ASSOC);
//         $downloadedFileName = $row['filename'] ?? null;
        
//         if ($downloadedFileName === NULL){
//             $downloads2Command = "INSERT INTO downloads (username, filename) VALUES (?, ?);";
//             $downloads2Stmt = $dbh->prepare($downloads2Command);
//             $downloads2Args = [$username, $filename];
//             $downloads2success = $downloads2Stmt->execute($downloads2Args);
//         } else{
//             try {
//                 $downloads3Command = "UPDATE downloads SET downloaddate = NOW() WHERE username = ? AND filename = ?";
//                 $downloads3stmt = $dbh->prepare($downloads3Command);
//                 $downloads3success = $downloads3stmt->execute([$username, $filename]);
            
//                 if (!$downloads3success) {
//                     die("ERROR: Failed to update download date.");
//                 }
//             } catch (Exception $e) {
//                 die("Error: " . $e->getMessage());
//             }
//         }
    
    
//     }else {
//         die("ERROR: Failed to get the fileName from the database.");
//     }


// } else {
//     die("ERROR: There is no active session!");
// }
?>