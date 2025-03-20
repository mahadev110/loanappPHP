<?php
// Include database connection
include 'includes/connection.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {    
    $application_number = trim($_POST["application_number"]);
    $customer_name = trim($_POST["customer_name"]);
    $mobile = trim($_POST["mobile"]);
    $address = trim($_POST["address"]);
    $pan = trim($_POST["pan"]);
    $aadhar = trim($_POST["aadhar"]);
    $given_loan_amt = trim($_POST["given_loan_amt"]);
    $loan_date = trim($_POST["loan_date"]);

    // Validate mobile (10 digits)
    if (!preg_match("/^\d{10}$/", $mobile)) {
        die("<script>alert('Invalid mobile number. Please enter a 10-digit number.'); window.history.back();</script>");
    }

    // Validate Aadhar (12 digits)
    if (!preg_match("/^\d{12}$/", $aadhar)) {
        die("<script>alert('Invalid Aadhar number. Please enter a 12-digit number.'); window.history.back();</script>");
    }

    // Check if mobile number or Aadhar already exists
    $check_sql = "SELECT id FROM customers WHERE mobile = ? OR aadhar = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ss", $mobile, $aadhar);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        die("<script>alert('Mobile number or Aadhar number already exists! Please use a different one.'); window.history.back();</script>");
    }
    $check_stmt->close();

    // Insert data into database
    $sql = "INSERT INTO customers (application_number, customer_name, mobile, address, pan, aadhar, given_loan_amt, loan_date)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssss", $application_number, $customer_name, $mobile, $address, $pan, $aadhar, $given_loan_amt, $loan_date);

    if ($stmt->execute()) {
        echo "<script>alert('Customer added successfully!'); window.location.href='new_customer.php';</script>";
    } else {
        die("<script>alert('Database Error: " . addslashes($stmt->error) . "'); window.history.back();</script>");
    }

    $stmt->close();
}

$conn->close();
?>
