<?php

session_start();

$filetitle = filter_input(INPUT_POST, 'filetitle', filter: FILTER_SANITIZE_SPECIAL_CHARS); // Whatever the user put in search bar
$macID = filter_input(INPUT_POST, 'macID', filter: FILTER_SANITIZE_SPECIAL_CHARS); // Their macID
$category = filter_input(INPUT_POST, 'category', filter: FILTER_SANITIZE_SPECIAL_CHARS); // Tells the server what parameters to send to the decideQuery function

// If category is uploads, then make a query to mfiles table
// If category is downloads, then make a qury to downloadedfiles table
// If category is macID, then make a query to users table
if ($category === "uploads") {
    decideQuery("SELECT * FROM mfiles WHERE filetitle LIKE ? AND macID = ?", ["%" . $filetitle . "%", $macID], $filetitle);
} else if ($category === "downloads") {
    decideQuery("SELECT * FROM downloadedfiles WHERE filetitle LIKE ? AND macIDofDownloader = ?", ["%" . $filetitle . "%", $macID], $filetitle);
} else {
    getResults("SELECT macID FROM users WHERE username = ?", [$_SESSION["username"]]);
}

/**
 * Builds Query to be sent to database object
 * @param mixed $defaultcmd | the "SELECT * FROM tablename" part of the query, or the start, as both the upload and download query start the same
 * @param mixed $parameters | the parameters that will fill the quiestion marks in the command
 * @param mixed $filetitle | Whatever the user put into the search bar
 * @return void
 */
function decideQuery($defaultcmd, $parameters, $filetitle)
{
    include "connect.php";
    $coursecodefiltercmd = ""; // Initializes part of query that is: "AND coursecode IN (?,?,...,?)"
    $coursecodefilter = filter_input(INPUT_POST, 'coursecodefilter', FILTER_SANITIZE_SPECIAL_CHARS);
    $coursecodefilter = html_entity_decode($coursecodefilter);  // Decode HTML entities
    $orderbyoption = filter_input(INPUT_POST, 'orderbyoption', FILTER_SANITIZE_SPECIAL_CHARS);
    $coursecodes = json_decode($coursecodefilter)->coursecodes;


    // Builds the AND coursecode IN (?, ?, ..., ?)
    if (!(count($coursecodes) == 0)) {
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

    // Creates part of query that is: ORDER BY (?) 
    //Parameters are only allowed for values, not SQL identifiers like column names or table names, hence why I put orderbyoption in the string.
    $orderbycmd = "";
    if ($orderbyoption === "filetitle") {
        $orderbycmd = " ORDER BY " . $orderbyoption . " ASC";
    } else {
        $orderbycmd = " ORDER BY " . $orderbyoption . " DESC";
    }

    $fullcmd = $defaultcmd . $coursecodefiltercmd . $orderbycmd; // The full command to be sent to the table

    getResults($fullcmd, $parameters);
}

/**
 * Prepares the command and executes the query and echoes the repose in the form of an object with keys error and message
 * @param mixed $cmd | the command created by decideQuery()
 * @param mixed $query | the $parameters
 * @return void
 */
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