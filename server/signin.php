<?php
    // start a session
    session_start();

    header('Content-Type: application/json');
    include "connect.php";

    $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
    $password = $_POST["password"] ?? ""; // we don't sanitize password to avoid altering it
    $macID = "";
    $response = ["status" => "fail", "username" => "", "message" => ""];

    if ($email && !empty($password)) {
        $macID = explode("@", $email)[0];

        $command = "SELECT * FROM users WHERE macID = ?";
        $stmt = $dbh->prepare($command);
        $args = [$macID];
        $success = $stmt->execute($args);

        if ($success) {
            if ($stmt->rowCount() == 0) {
                $response["message"] = "This MacID doesn't exist! Please create an account first!";
            } else {
                $row = $stmt->fetch();
                $stored_hash = $row["password"];

                if (password_verify($password, $stored_hash)) {
                    $response["status"] = "success";
                    $response["message"] = "Logged in successfully";
                    $response["username"] = $row["username"]; // we add this when login is successful
                    $_SESSION["username"] = $row["username"];
                } else {
                    $response["message"] = "Wrong password!";
                }
            }
        } else {
            $response["message"] = "Failed to get user data from database";
        }
    } else {
        $response["message"] = "Invalid parameters!";
    }

    echo json_encode($response);
?>
