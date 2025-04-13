<?php

// Grab the search query safely

/**
 * FILTERS:
 * 
 * - Size
 * - CourseCode
 * 
 * 
 */

//example $cmd:"SELECT * FROM mfiles WHERE filetitle LIKE ? AND coursecode = '1XC3'"
//1KB = 1024 bytes
// SELECT * FROM mfiles 
// WHERE filetitle LIKE ? 
// AND filesize BETWEEN 0 AND 512000;

decideQuery();

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
    $query = filter_input(INPUT_POST, 'query', FILTER_SANITIZE_SPECIAL_CHARS);
    $coursecodefilter = filter_input(INPUT_POST, 'coursecodefilter', FILTER_SANITIZE_SPECIAL_CHARS);
    $coursecodefilter = html_entity_decode($coursecodefilter);  // Decode HTML entities
    $orderbyoption = filter_input(INPUT_POST, 'orderbyoption', FILTER_SANITIZE_SPECIAL_CHARS);


    if ($query == null || $query == false) {
        echo json_encode(value: ["error" => "No file name given"]);
        exit;
    }
    $min = json_decode($filesizefilter)->min * 1024;
    $max = json_decode($filesizefilter)->max * 1024;
    $filesizefiltercmd = " AND filesize BETWEEN ? AND ?";


    $coursecodes = json_decode($coursecodefilter)->coursecodes;
    $parameters = ["%" . $query . "%", $min, $max];

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


    $fullcmd = $defaultcmd . $filesizefiltercmd . $coursecodefiltercmd . " ORDER BY " . $orderbyoption . " DESC";
    //Parameters are only allowed for values, not SQL identifiers like column names or table names, hence why I put orderbyoption in the string.



    getResults($fullcmd, $parameters);
}

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

/*
ORDER_BY operator

--for customers, the default column that the table is sorted by is customer_id because
  it is the primary key columnn (click wrench icon next to customers and youll see key icon next to column name).
  In relational databases, every table should have a primary key column and the values in that column should all 
  appear once, so that they can uniqeuly identify the records in each row 
  
SELECT *
FROM customers
ORDER BY city

-above, sorted defatul is by ascending but can make it dewcening by using DESC
SELECT *
FROM customers
ORDER BY city DESC

-can also sort with multiple columsn (say you wanted to sort by state and then within each state you sort those ones by first_name)
SELECT *
FROM customers
ORDER BY state, first_name

-columns dont have to be selected for you to sort by them, eg
SELECT first_name, last_name
FROM customers
ORDER BY state

--can also do aliases
SELECT first_name, "dummy balue" AS bruh
FROM customers
ORDER BY bruh
*/
?>