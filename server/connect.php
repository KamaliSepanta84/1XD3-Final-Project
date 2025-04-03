<?php
// create a connection to the database
try {
    $dbh = new PDO(
        "mysql:host=localhost;dbname=quresu9_db", #changed from sepanta's macid
        "root",
        ""
    );
} catch (Exception $e) {
    die("ERROR: Couldn't connect. {$e->getMessage()}");
}
