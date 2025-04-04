<?php
    header('Content-Type: application/json');
    include "connect.php";

    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
    $macID;
    $response = ["status" => "fail", "message" => ""];

    $isParamOk = false;

    if ($username !== null && $username !== "" && $email !== null && $email !== false
        && $password !== null && $password !== ""){
        $isParamOk = true;
    }

    if ($isParamOk){
        $macID = explode("@", $email)[0];

        $command = "SELECT * FROM users WHERE macID = ?";
        $stmt = $dbh->prepare($command);
        $args = [$macID];
        $success = $stmt->execute($args);

        if ($success) {
            if ($stmt->rowCount() != 0){
                $response["message"] = "This MacID alraedy exists! Please log in!";
            } 
            else{
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $command = "INSERT INTO users (macID, username, email, password) VALUES (?, ?, ?, ?)";
                $stmt = $dbh->prepare($command);
                $args = [$macID, $username, $email, $hashed_password];
                $success = $stmt->execute($args);

                if ($success){
                    $response["status"] = "success";
                    $response["message"] = "user added successfully!";
                }

                else{
                    $response["status"] = "fail";
                    $response["message"] = "failed to add user!";
                }
            }
        }
        else{
            $response["message"] = "failed to get user data from database";
        }
    } 
    else{
        $response["message"] = "Invalid parameters!";
    }

    echo json_encode($response);
?>