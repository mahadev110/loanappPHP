<?php
include 'includes/connection.php'; // Include database connection

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $application_number = isset($_POST['application_number']) ? trim($_POST['application_number']) : '';
    $borrower_name = isset($_POST['borrower_name']) ? trim($_POST['borrower_name']) : '';
    $amount_collected = isset($_POST['amount_collected']) ? trim($_POST['amount_collected']) : '';
    $collection_date = isset($_POST['collection_date']) ? trim($_POST['collection_date']) : '';

    // Check for empty fields
    if (empty($application_number) || empty($borrower_name) || empty($amount_collected) || empty($collection_date)) {
        die("Error: All fields are required.");
    }

    // Prepare SQL query to insert data
    $sql = "INSERT INTO loan_collections (application_number, borrower_name, amount_collected, collection_date) 
            VALUES (?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssds", $application_number, $borrower_name, $amount_collected, $collection_date);

    if ($stmt->execute()) {
        echo "<script>alert('Collection data saved successfully!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Database Error: " . $stmt->error . "');</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    die("Invalid request method!");
}
?>
