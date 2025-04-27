<?php
    /**
     * This file starts a session and stores username when the user signs in
     * Author: Sepanta Kamali
     */

    // Start a session
    session_start();

    // Set response type to JSON
    header('Content-Type: application/json');
    //Connect to Database
    include "connect.php";

    // Get and validate email from POST request
    $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
    $password = $_POST["password"] ?? ""; // we don't sanitize password to avoid altering it
    //Initialize reponse and macID
    $macID = ""; 
    $response = ["status" => "fail", "username" => "", "message" => ""];

    // Check if email and password are valid
    if ($email && !empty($password)) {
        // Extract macID from email (before @ symbol)
        $macID = explode("@", $email)[0];

        // SQL command to select user by macID
        $command = "SELECT * FROM users WHERE macID = ?";
        $stmt = $dbh->prepare($command);
        $args = [$macID];
        $success = $stmt->execute($args);

        if ($success) {
            // If no user found
            if ($stmt->rowCount() == 0) {
                $response["message"] = "This MacID doesn't exist! Please create an account first!";
            } else {
                // If user is found fetch results
                $row = $stmt->fetch();
                //Set stored_hash to hashed password
                $stored_hash = $row["password"];

                 // Verify password against stored hash
                if (password_verify($password, $stored_hash)) {
                    //if login successful
                    $response["status"] = "success";
                    $response["message"] = "Logged in successfully";
                    $response["username"] = $row["username"]; // we add this when login is successful
                    $_SESSION["username"] = $row["username"];
                } else {
                    //password does not match
                    $response["message"] = "Wrong password!";
                }
            }
        } else {
            // Query Failed to excevute
            $response["message"] = "Failed to get user data from database";
        }
    } else {
        // Email or password unsuccessful
        $response["message"] = "Invalid parameters!";
    }

    // Output the response as JSON
    echo json_encode($response);
?>
