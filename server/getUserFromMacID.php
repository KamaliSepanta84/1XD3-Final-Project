<?php
     /**
     * This file gets the username from the macID
     * Author: Sepanta Kamali
     */

    // Set response content type to JSON
    header('Content-Type: application/json');
    
    // Connect to database
    include "./connect.php";

    // Get and sanitize macID from POST request
    $macID = filter_input(INPUT_POST, "macID", FILTER_SANITIZE_SPECIAL_CHARS);
    
    //Set Default Response
    $response = ["username" => ""];

    // Check if macID is provided and valid
    if ($macID !== null && $macID !== "") {
        // SQL command to find username from macID
        $command = "SELECT username FROM users WHERE macID = ?";
        $stmt = $dbh->prepare($command);
        $args = [$macID];
        $success = $stmt->execute($args);

        // If query executes successfully
        if ($success) {
            // Fetch the result
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            // If username is found, set it in the response
            if ($row && isset($row["username"])) {
                $response["username"] = $row["username"];
            } else {
                // If username not found, return error 
                die(json_encode(["error" => "Username not found."]));
            }
        } else {
            // If query fails, return error
            die(json_encode(["error" => "Database query failed."]));
        }
    } else {
        // If macID is missing or invalid, return error
        die(json_encode(["error" => "Invalid parameters."]));
    }

    // Output the response as JSON
    echo json_encode($response);
?>
