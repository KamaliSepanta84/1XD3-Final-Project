<?php
header("Content-Type: application/json");
include "./connect.php";

$filename = filter_input(INPUT_POST, "filename", FILTER_SANITIZE_SPECIAL_CHARS);

$response = ["download_count" => 0]; // default value is 0

if ($filename !== null && $filename !== "") {
    $command = "SELECT `download-number` FROM mfiles WHERE `filename` = ?";
    $stmt = $dbh->prepare($command);
    $args = [$filename];
    $success = $stmt->execute($args);

    if ($success) {
        $row = $stmt->fetch();
        if ($row) {
            $response["download_count"] = $row["download-number"];
        }
    }

    else{
        die("ERROR: failed to fetch to number of downloads from database");
        exit();
    }
}

else{
    die("ERROR: Invalid parameters!");
    exit();
}

echo json_encode($response);
?>
