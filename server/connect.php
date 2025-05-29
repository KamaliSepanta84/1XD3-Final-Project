<?php
/**
 * This file makes connection to the database
 * Author: Sepanta Kamali
 */
try {
    $dbh = new PDO(
        "mysql:host=localhost;dbname=kosoricm_db", 
        "root",
        "" 
    );
} catch (Exception $e) {
    die("ERROR: Couldn't connect. {$e->getMessage()}");
}
