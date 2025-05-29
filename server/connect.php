<?php
/**
 * This file makes connection to the database
 * Author: Sepanta Kamali
 */
try {
    $dbh = new PDO(
<<<<<<< HEAD
        "mysql:host=localhost;dbname=kosoricm_db", 
        "root",
        "" 
=======
        "mysql:host=localhost;dbname=kamals19_db", 
        "root",
        ""
        //;>VdLnYe
>>>>>>> 749e01dcfc1df13c80fecbe257704acf92337c00
    );
} catch (Exception $e) {
    die("ERROR: Couldn't connect. {$e->getMessage()}");
}
