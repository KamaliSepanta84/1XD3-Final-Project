<?php
// This file gets the username from the session key and passes to other files \
// when users log in.

/**
 * This file gets the user from the active session
 * Author: Umer Qureshi
 */
// start the session
session_start();

header('Content-Type: application/json');

$access = isset($_SESSION["username"]);

echo json_encode([
    "access" => $access,
    "username" => $_SESSION["username"] ?? null
]);
?>