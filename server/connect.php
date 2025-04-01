<?php
// create a connection to the database
try {
    $dbh = new PDO(
        # "mysql:host=localhost;dbname=kamals19_db",
        #  "root",
        # ""

    );
} catch (Exception $e) {
    die("ERROR: Couldn't connect. {$e->getMessage()}");
}
