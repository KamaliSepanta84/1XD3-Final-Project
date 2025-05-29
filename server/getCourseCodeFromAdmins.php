
<?php
/**
 * This file retrieves the course codes associated with an admin.
 * Author: Marko Kosoric
 */
header('Content-Type: application/json');
include "./connect.php";

// Only accept POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["success" => false, "message" => "Invalid request method.", "courseCodes" => []] );
    exit;
}

// Start a session
session_start();

//Check if is admin
if (!isset($_SESSION["is_admin"]) || $_SESSION["is_admin"] !== true) {
    echo json_encode(["success" => false, "message" => "Unauthorized", "courseCodes" => []]);
    exit;
}

if (isset($_SESSION["username"])){
    $username = $_SESSION["username"];

    $command = "SELECT course_code FROM admins WHERE username = ?";
    $stmt = $dbh->prepare($command);
    $args = [$username];
    $success = $stmt->execute($args);
    if ($success){
        // Fetch all results
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Extract just the course_code column into a flat array
        $codes = array_column($results, 'course_code');
        echo json_encode(["success" => true, "message" => "Succesfully retrived coursecode from admin", "courseCodes" => $codes]);
    }else{
        echo json_encode(["success" => false, "message" => "retrieving courscodes from admin unsuccesful", "courseCodes" => []]);
    }

}else{
    echo json_encode(["success" => false, "message" => "Username does not exist", "courseCodes" => []]);
}

?>