<?php
include "connect.php";

// Grab the search query safely
$query = filter_input(INPUT_POST, 'query', FILTER_SANITIZE_STRING);

// Check if query is valid
if ($query === false || $query === null) {
    echo json_encode(["error" => "Invalid search query"]);
    exit;
}

try {
    // Prepare the SQL command with proper LIKE syntax
    $cmd = "SELECT * FROM grades WHERE firstname LIKE ?";
    $stmt = $dbh->prepare($cmd);

    // Bind the query with wildcard characters for pattern matching
    $args = ["%$query%"];
    $success = $stmt->execute($args);

    if (!$success) {
        echo json_encode(["error" => "Database query failed"]);
        exit;
    }

    // Fetch all results
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return JSON response
    echo json_encode($results);
} catch (Exception $e) {
    echo json_encode(["error" => "Something went wrong"]);
}
?>
