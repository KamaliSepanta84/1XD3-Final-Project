<?php
    header('Content-Type: application/json'); 
    include "./connect.php";

    $command = "SELECT `filename`, `filetitle`, `coursecode`, `description`, `rating`, `download-number`, `upload_time`,
       ROUND((rating * 8 + `download-number` * 0.5) / (1 + DATEDIFF(NOW(), upload_time)), 2) 
       AS score
       FROM mfiles
       ORDER BY score DESC
       LIMIT 10";

    $stmt = $dbh->prepare($command);
    $success = $stmt->execute();

    if ($success) {
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($results); 
    } else {
        echo json_encode(["error" => "Query failed"]);
    }
?>
