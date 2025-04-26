<?php
decideQuery();

/**
 * Builds Query to be sent to database object
 * @return void
 */
function decideQuery()
{
    include "connect.php";

    $defaultcmd = "SELECT * FROM mfiles WHERE filetitle LIKE ?";
    $filesizefiltercmd = "";
    $coursecodefiltercmd = "";
    $filesizefilter = filter_input(INPUT_POST, 'filesizefilter', FILTER_SANITIZE_SPECIAL_CHARS);
    $filesizefilter = html_entity_decode($filesizefilter);  // Decode HTML entities
    // When the filesizefilter object was stringified and sent in the request, any double quotes (") around the property 
    // names or values in the JSON object were automatically converted into &#34; (the HTML entity for the double quote 
    // character). This is a common behavior in HTML to ensure special characters are safely represented in a way that 
    // won't break the structure of the document. but when PHP tried to json_decode() this string, it failed to parse correctly, 
    // leading to the issue where the min and max values ended up as 0.
    $query = filter_input(INPUT_POST, 'query', filter: FILTER_SANITIZE_SPECIAL_CHARS);
    $coursecodefilter = filter_input(INPUT_POST, 'coursecodefilter', FILTER_SANITIZE_SPECIAL_CHARS);
    $coursecodefilter = html_entity_decode($coursecodefilter);  // Decode HTML entities
    $orderbyoption = filter_input(INPUT_POST, 'orderbyoption', FILTER_SANITIZE_SPECIAL_CHARS);


    if ($query == null || $query == false) {
        echo json_encode(value: ["error" => "No file name given"]);
        exit;
    }
    //Builds the filesize between part of the query
    if (!($filesizefilter == null || $filesizefilter == false)) {
        $min = json_decode($filesizefilter)->min * 1024;
        $max = json_decode($filesizefilter)->max * 1024;
        $filesizefiltercmd = " AND filesize BETWEEN ? AND ?";
        $parameters = ["%" . $query . "%", $min, $max];
    } 

    $coursecodes = json_decode($coursecodefilter)->coursecodes;

    // Builds the AND coursecode IN (?, ?, ..., ?) part of the queyr
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

    $orderbycmd = "";

    if ($orderbyoption === "filetitle") {
        $orderbycmd = " ORDER BY " . $orderbyoption . " ASC";
    } else {
        $orderbycmd = " ORDER BY " . $orderbyoption . " DESC";
    }


    $fullcmd = $defaultcmd . $filesizefiltercmd . $coursecodefiltercmd . $orderbycmd;
    //Parameters are only allowed for values, not SQL identifiers like column names or table names, hence why I put orderbyoption in the string.

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
    // Check if query is valid

    try {
        // Prepare the SQL command with proper LIKE syntax
        $stmt = $dbh->prepare($cmd);

        // Bind the query with wildcard characters for pattern matching
        $success = $stmt->execute($query);

        if (!$success) {
            echo json_encode(["error" => "Database query failed"]);
            exit;
        }

        // Fetch all results
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Return JSON response
        echo json_encode(["error" => "", "result" => $results]);
    } catch (Exception $e) {
        echo json_encode(["error" => $e->getMessage()]);
    }
}
?>