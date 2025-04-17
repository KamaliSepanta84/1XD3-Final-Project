<?php
    // this is a php script to get the username from macID
    
    header('Content-Type: application/json');
    include "./connect.php";

    $macID = filter_input(INPUT_POST, "macID", FILTER_SANITIZE_SPECIAL_CHARS);
    $response = ["username" => ""];

    if ($macID !== null && $macID !== "") {
        $command = "SELECT username FROM users WHERE macID = ?";
        $stmt = $dbh->prepare($command);
        $args = [$macID];
        $success = $stmt->execute($args);

        if ($success) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row && isset($row["username"])) {
                $response["username"] = $row["username"];
            } else {
                die(json_encode(["error" => "Username not found."]));
            }
        } else {
            die(json_encode(["error" => "Database query failed."]));
        }
    } else {
        die(json_encode(["error" => "Invalid parameters."]));
    }

    echo json_encode($response);
?>
