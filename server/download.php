<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "./connect.php";
session_start();

if (isset($_SESSION["username"])) {
    // Get the username from session
    $username = $_SESSION["username"];
    
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
