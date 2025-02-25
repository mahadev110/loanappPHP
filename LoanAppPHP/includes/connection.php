<?php
$servername = "localhost"; // Change if needed
$username = "root"; // Change as per your database user
$password = ""; // Change as per your database password
$database = "loanapp_db"; // Change to your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
