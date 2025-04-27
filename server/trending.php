<?php
    /**
     * This file creates an algorithm and gets the trending files from database
     * Author: Sepanta Kamali
     */

    // Set response content type to JSON
    header('Content-Type: application/json'); 
    // Connect to database
    include "./connect.php";

    // SQL command to select top 10 files ranked by score
    $command = "SELECT `filename`, `filetitle`, `coursecode`, `description`, `rating`, `download-number`, `upload_time`,
       ROUND((rating * 8 + `download-number` * 0.5) / (1 + DATEDIFF(NOW(), upload_time)), 2) 
       AS score
       FROM mfiles
       ORDER BY score DESC
       LIMIT 10";

    // Prepare and execute the SQL statement
    $stmt = $dbh->prepare($command);
    $success = $stmt->execute();

    // If query successful, return results as JSON
    if ($success) {
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($results); 
    } else {
        // If query fails, return an error message
        echo json_encode(["error" => "Query failed"]);
    }
?>
