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
getResults("SELECT * FROM mfiles WHERE filetitle LIKE ?");

function getResults($cmd)
{
    include "connect.php";

    $query = filter_input(INPUT_POST, 'query', FILTER_SANITIZE_SPECIAL_CHARS);
    /*
    $filter = filter_input(INPUT_POST, 'filter', FILTER_SANITIZE_SPECIAL_CHARS);
    if($filter === null || $filter === false){
        echo json_encode(value: ["error" => "No filters applied"]);
        exit;
    }
        */


    // Check if query is valid
    if ($query === false || $query === null) {
        echo json_encode(value: ["error" => "Invalid search query"]);
        exit;
    }

    try {
        // Prepare the SQL command with proper LIKE syntax
        $stmt = $dbh->prepare($cmd);

        // Bind the query with wildcard characters for pattern matching
        $success = $stmt->execute(["%$query%"]);

        if (!$success) {
            echo json_encode(["error" => "Database query failed"]);
            exit;
        }

        // Fetch all results
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Return JSON response
        echo json_encode(["error" => "", "result" => $results]);
    } catch (Exception $e) {
        echo json_encode(["error" => "Something went wrong!"]);
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