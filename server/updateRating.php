<?php
header('Content-Type: application/json');
include "./connect.php";
session_start(); 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if (!isset($_SESSION["username"])) {
    die("ERROR: No active session for user!");
    exit();
}

$username = $_SESSION["username"];
$rating = filter_input(INPUT_POST, "rating", FILTER_VALIDATE_INT);
$filename = filter_input(INPUT_POST, "filename", FILTER_SANITIZE_SPECIAL_CHARS);

if ($rating !== null && $rating !== false && $filename !== null && $filename !== "") {
    // first update rating count in mfiles
    $ratingColumn = "rating" . $rating;

    $command = "UPDATE mfiles 
                SET `$ratingColumn` = `$ratingColumn` + 1, 
                    `count` = `count` + 1 
                WHERE `filename` = ?";
    $stmt = $dbh->prepare($command);
    $success = $stmt->execute([$filename]);

    if ($success) {
        // the calculate the average rating
        $command2 = "SELECT rating1, rating2, rating3, rating4, rating5, count
                     FROM mfiles WHERE `filename` = ?";
        $stmt2 = $dbh->prepare($command2);
        $success2 = $stmt2->execute([$filename]);

        if ($success2) {
            $row = $stmt2->fetch(PDO::FETCH_ASSOC);

            $ratingSum = (1 * (int)$row["rating1"]) +
                         (2 * (int)$row["rating2"]) +
                         (3 * (int)$row["rating3"]) +
                         (4 * (int)$row["rating4"]) +
                         (5 * (int)$row["rating5"]);

            $count = (int)$row["count"];
            $average = $count > 0 ? round($ratingSum / $count, 1) : 0;

            // update the overall average rating
            $command3 = "UPDATE mfiles SET `rating` = ? WHERE `filename` = ?";
            $stmt3 = $dbh->prepare($command3);
            $stmt3->execute([$average, $filename]);

            // we nned to get the users macID to update the ratings table
            $command4 = "SELECT macID FROM users WHERE username = ?";
            $stmt4 = $dbh->prepare($command4);
            $stmt4->execute([$username]);
            $macIDRow = $stmt4->fetch(PDO::FETCH_ASSOC);
            $macID = $macIDRow ? $macIDRow["macID"] : null;

            if ($macID !== null) {
                // Insert into the ratings table
                $command5 = "INSERT INTO ratings (filename, macID)
                             VALUES (?, ?)";
                $stmt5 = $dbh->prepare($command5);
                $stmt5->execute([$filename, $macID]);
            } else {
                error_log("macID not found for user: $username");
            }
        }
    }
} else {
    die("ERROR: Invalid input.");
    exit();
}

echo "Rating Submitted!";
?>
