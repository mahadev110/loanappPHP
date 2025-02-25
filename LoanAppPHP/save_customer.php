<?php
// Include database connection
include 'includes/connection.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_name = trim($_POST["customer_name"]);
    $mobile = trim($_POST["mobile"]);
    $address = trim($_POST["address"]);
    $pan = trim($_POST["pan"]);
    $aadhar = trim($_POST["aadhar"]);
    $request_loan_amt = trim($_POST["request_loan_amt"]);
    $eligible_loan_amt = trim($_POST["eligible_loan_amt"]);
    $given_loan_amt = trim($_POST["given_loan_amt"]);
    $loan_date = trim($_POST["loan_date"]);

    // Validate mobile (10 digits)
    if (!preg_match("/^\d{10}$/", $mobile)) {
        die("Invalid mobile number. Please enter a 10-digit number.");
    }

    // Validate PAN (Format: ABCDE1234F)
    if (!preg_match("/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/", $pan)) {
        die("Invalid PAN format. Please enter a valid PAN number.");
    }

    // Validate Aadhar (12 digits)
    if (!preg_match("/^\d{12}$/", $aadhar)) {
        die("Invalid Aadhar number. Please enter a 12-digit number.");
    }

    // Insert data into database
    $sql = "INSERT INTO customers (customer_name, mobile, address, pan, aadhar, request_loan_amt, eligible_loan_amt, given_loan_amt, loan_date)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssss", $customer_name, $mobile, $address, $pan, $aadhar, $request_loan_amt, $eligible_loan_amt, $given_loan_amt, $loan_date);

    if ($stmt->execute()) {
        echo "<script>alert('Customer added successfully!'); window.location.href='new_customer.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
