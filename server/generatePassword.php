<?php
// Replace with the password you want to hash
$password = "Scott1234"; 

// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Output the hashed password
echo "Hashed password: " . $hashed_password;
?>
