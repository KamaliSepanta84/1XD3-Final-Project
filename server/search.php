<?php

/**
 * Search files with filters:
 * - File size
 * - Course code
 * - Case-insensitive file title search
 */

decideQuery();

function decideQuery()
{
    include "connect.php";

    $debugMode = false; // set to true for debugging

    $defaultcmd = "SELECT * FROM mfiles WHERE LOWER(filetitle) LIKE LOWER(?)";
    $filesizefiltercmd = "";
    $coursecodefiltercmd = "";
    $parameters = [];

    // Sanitize and decode inputs
    $query = filter_input(INPUT_POST, 'query', FILTER_SANITIZE_SPECIAL_CHARS);
    $filesizefilter = html_entity_decode(filter_input(INPUT_POST, 'filesizefilter', FILTER_SANITIZE_SPECIAL_CHARS));
    $coursecodefilter = html_entity_decode(filter_input(INPUT_POST, 'coursecodefilter', FILTER_SANITIZE_SPECIAL_CHARS));
    $orderbyoption = filter_input(INPUT_POST, 'orderbyoption', FILTER_SANITIZE_SPECIAL_CHARS);

    // Handle missing query
    if (!$query) {
        echo json_encode(["error" => "No file name given"]);
        exit;
    }

    // Add query to parameters
    $parameters[] = "%" . $query . "%";

    // Decode filesize filter safely
    $decodedFileSize = json_decode($filesizefilter);
    $min = isset($decodedFileSize->min) ? $decodedFileSize->min * 1024 : 0;
    $max = isset($decodedFileSize->max) ? $decodedFileSize->max * 1024 : 524288000; // 500MB default max

    $filesizefiltercmd = " AND filesize BETWEEN ? AND ?";
    array_push($parameters, $min, $max);

    // Decode course codes safely
    $decodedCourse = json_decode($coursecodefilter);
    if (isset($decodedCourse->coursecodes) && is_array($decodedCourse->coursecodes) && count($decodedCourse->coursecodes) > 0) {
        $coursecodefiltercmd = " AND coursecode IN (" . implode(',', array_fill(0, count($decodedCourse->coursecodes), '?')) . ")";
        foreach ($decodedCourse->coursecodes as $code) {
            $parameters[] = $code;
        }
    }

    // Validate orderbyoption (prevents SQL injection)
    $validOrderColumns = ["filetitle", "filesize", "coursecode", "dateuploaded"];
    if (!in_array($orderbyoption, $validOrderColumns)) {
        $orderbyoption = "filetitle"; // fallback
    }

    $fullcmd = $defaultcmd . $filesizefiltercmd . $coursecodefiltercmd . " ORDER BY $orderbyoption DESC";

    if ($debugMode) {
        echo json_encode([
            "debug_sql" => $fullcmd,
            "debug_params" => $parameters
        ]);
        exit;
    }

    getResults($fullcmd, $parameters);
}

function getResults($cmd, $params)
{
    include "connect.php";

    try {
        $stmt = $dbh->prepare($cmd);
        $success = $stmt->execute($params);

        if (!$success) {
            echo json_encode(["error" => "Database query failed"]);
            exit;
        }

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(["error" => "", "result" => $results]);
    } catch (Exception $e) {
        echo json_encode(["error" => $e->getMessage()]);
    }
}
?>
