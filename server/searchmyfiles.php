<?php
$filetitle = filter_input(INPUT_POST, 'filetitle', filter: FILTER_SANITIZE_SPECIAL_CHARS);
$macID = filter_input(INPUT_POST, 'macID', filter: FILTER_SANITIZE_SPECIAL_CHARS);
$category = filter_input(INPUT_POST, 'category', filter: FILTER_SANITIZE_SPECIAL_CHARS);

if ($category === "uploads") {
    decideQuery("SELECT * FROM mfiles WHERE filetitle LIKE ? AND macID = ?", ["%" . $filetitle . "%", $macID], $filetitle);
} else {
    decideQuery("SELECT * FROM downloadedfiles WHERE filetitle LIKE ? AND macIDofDownloader = ?", ["%" . $filetitle . "%", $macID], $filetitle);
}

//SELECT filename FROM downloadedfiles WHERE macID = ?a
//$parameters = [$macID]

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
        echo json_encode(["error" => "", "message" => $results]);
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