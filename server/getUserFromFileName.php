<?php

/**
 * This file gets the username from the uploaded file
 * Author: Sepanta Kamali
 */

// This PHP file gets the username from the filename
header("Content-Type: application/json");
include "./connect.php";

$filename = filter_input(INPUT_POST, "filename", FILTER_SANITIZE_SPECIAL_CHARS);
$response = ["user_name" => ""];

if ($filename !== null && $filename !== "") {
    // first get the macID from mfiles
    $command = "SELECT macID FROM mfiles WHERE `filename` = ?";
    $stmt = $dbh->prepare($command);
    $success = $stmt->execute([$filename]);

    if ($success) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result && isset($result["macID"])) {
            $macID = $result["macID"];

            // then we get username from users using macID
            $command2 = "SELECT username FROM users WHERE macID = ?";
            $stmt2 = $dbh->prepare($command2);
            $success2 = $stmt2->execute([$macID]);

            if ($success2) {
                $result2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                if ($result2 && isset($result2["username"])) {
                    $response["user_name"] = $result2["username"];
                } else {
                    $command3 = "SELECT username FROM admins WHERE macID = ?";
                    $stmt3 = $dbh->prepare($command3);
                    $success3 = $stmt3->execute([$macID]);
                    if ($success3) {
                        $result3 = $stmt3->fetch(PDO::FETCH_ASSOC);
                        if ($result3 && isset($result3["username"])) {
                            $response["user_name"] = $result3["username"];
                        }
                    } else {
                        die("ERROR: Failed to fetch username from admins or users table.");
                    }
                }
            } else {
                die("ERROR: Failed to fetch username from users table.");
            }
        } else {
            die("ERROR: macID not found for filename.");
        }
    } else {
        die("ERROR: Failed to fetch macID from mfiles table.");
    }
} else {
    die("ERROR: Invalid parameters!");
}

echo json_encode($response);
