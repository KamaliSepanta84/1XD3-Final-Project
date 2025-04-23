<?php

session_start();

$filetitle = filter_input(INPUT_POST, 'filetitle', filter: FILTER_SANITIZE_SPECIAL_CHARS);
$macID = filter_input(INPUT_POST, 'macID', filter: FILTER_SANITIZE_SPECIAL_CHARS);
$category = filter_input(INPUT_POST, 'category', filter: FILTER_SANITIZE_SPECIAL_CHARS);

if ($category === "uploads") {
    decideQuery("SELECT * FROM mfiles WHERE filetitle LIKE ? AND macID = ?", ["%" . $filetitle . "%", $macID], $filetitle);
} else if ($category === "downloads") {
    decideQuery("SELECT * FROM downloadedfiles WHERE filetitle LIKE ? AND macIDofDownloader = ?", ["%" . $filetitle . "%", $macID], $filetitle);
} else {
    getResults("SELECT macID FROM users WHERE username = ?", [$_SESSION["username"]]);
}

function decideQuery($defaultcmd, $parameters, $filetitle)
{
    include "connect.php";
    $coursecodefiltercmd = "";
    $coursecodefilter = filter_input(INPUT_POST, 'coursecodefilter', FILTER_SANITIZE_SPECIAL_CHARS);
    $coursecodefilter = html_entity_decode($coursecodefilter);  // Decode HTML entities
    $orderbyoption = filter_input(INPUT_POST, 'orderbyoption', FILTER_SANITIZE_SPECIAL_CHARS);
    $coursecodes = json_decode($coursecodefilter)->coursecodes;


    if (!(count($coursecodes) == 0)) {
        //  AND coursecode IN (?, ?, ..., ?)
        $coursecodefiltercmd = " AND coursecode IN (";
        for ($i = 0; $i < count($coursecodes); $i++) {
            if ($i == count($coursecodes) - 1) {
                $coursecodefiltercmd .= "?";
            } else {
                $coursecodefiltercmd .= "?,";
            }
            array_push($parameters, $coursecodes[$i]);
        }
        $coursecodefiltercmd .= ")";
    } else {
        $coursecodefiltercmd = "";
    }

    $orderbycmd = "";
    if ($orderbyoption === "filetitle") {
        $orderbycmd = " ORDER BY " . $orderbyoption . " ASC";
    } else {
        $orderbycmd = " ORDER BY " . $orderbyoption . " DESC";
    }

    $fullcmd = $defaultcmd . $coursecodefiltercmd . $orderbycmd;
    //Parameters are only allowed for values, not SQL identifiers like column names or table names, hence why I put orderbyoption in the string.



    getResults($fullcmd, $parameters);
}

function getResults($cmd, $query)
{
    include "connect.php";
    try {
        $stmt = $dbh->prepare($cmd);
        $success = $stmt->execute($query);
        if (!$success) {
            echo json_encode(["error" => "Database query failed"]);
            exit;
        }
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(["error" => "", "message" => $results]);
    } catch (Exception $e) {
        echo json_encode(["error" => $e->getMessage()]);
    }
}
?>