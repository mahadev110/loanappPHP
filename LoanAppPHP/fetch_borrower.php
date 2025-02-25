<?php
include 'includes/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['app_number'])) {
    $app_number = trim($_POST['app_number']);
    
    // Extracting numeric ID from "APP00001"
    $id = intval(substr($app_number, 3));

    $stmt = $conn->prepare("SELECT customer_name FROM customers WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($customer_name);
    $stmt->fetch();
    $stmt->close();
    
    echo $customer_name ? $customer_name : "Not Found";
}

$conn->close();
?>
