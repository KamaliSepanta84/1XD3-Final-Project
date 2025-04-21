<?php
include "connect.php";
session_start();
header('Content-Type: application/json');

$response = ["success" => false, "message" => ""];

if (!isset($_SESSION["username"])) {
    $response["message"] = "No active session.";
    echo json_encode($response);
    exit;
}

$username = $_SESSION["username"];
$query = isset($_POST["query"]) ? $_POST["query"] : null;

if ($query === null) {
    $response["message"] = "Invalid Query";
    echo json_encode($response);
    exit;
}

try {
    // Step 1: Get macID
    $stmt = $dbh->prepare("SELECT macID FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user || !isset($user["macID"])) {
        throw new Exception("macID not found.");
    }

    $macID = $user["macID"];

    // Step 2: Get matching files from mfiles JOINED with downloads, ordered by downloaddate
    $sql = "
        SELECT m.*
        FROM mfiles m
        JOIN downloads d ON m.filename = d.filename
        WHERE d.username = ?
        AND (m.filetitle LIKE ? OR m.filename LIKE ?)
        ORDER BY d.downloaddate DESC
    ";

    $likeQuery = '%' . $query . '%';
    $stmt = $dbh->prepare($sql);
    $stmt->execute([$username, $likeQuery, $likeQuery]);
    $matchingFiles = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $response["message"] = [$matchingFiles, $macID];

} catch (Exception $e) {
    $response["message"] = $e->getMessage();
}

echo json_encode($response);
?>