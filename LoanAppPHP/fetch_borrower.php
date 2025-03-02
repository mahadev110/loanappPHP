<?php
include 'includes/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['app_number'])) {
    $app_number = trim($_POST['app_number']);

    // Prepare the SQL statement
    $stmt = $conn->prepare("SELECT customer_name FROM customers WHERE application_number = ?");
    if ($stmt) {
        // Bind the application number as a string
        $stmt->bind_param("s", $app_number);
        $stmt->execute();
        $stmt->bind_result($customer_name);
        $stmt->fetch();
        $stmt->close();

        // Return the fetched customer name or "Not Found" if empty
        echo !empty($customer_name) ? $customer_name : "Not Found";
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>
