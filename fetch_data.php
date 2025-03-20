<?php
include 'includes/connection.php';

if (isset($_POST['application_number'])) {
    $appNumber = $_POST['application_number'];

    // Fetch customer details (only one record)
    $customer_sql = "SELECT customer_name, mobile, address, pan, aadhar, 
                            request_loan_amt, eligible_loan_amt, given_loan_amt, loan_date 
                     FROM customers WHERE application_number = ?";

    $customer_stmt = $conn->prepare($customer_sql);
    $customer_stmt->bind_param("s", $appNumber);
    $customer_stmt->execute();
    $customer_result = $customer_stmt->get_result();

    // Fetch loan collection records (multiple rows)
    $collection_sql = "SELECT application_number, amount_collected, collection_date 
                       FROM loan_collections WHERE application_number = ?";
    
    $collection_stmt = $conn->prepare($collection_sql);
    $collection_stmt->bind_param("s", $appNumber);
    $collection_stmt->execute();
    $collection_result = $collection_stmt->get_result();

    // Check if customer data exists
    if ($customer_result->num_rows > 0) {
        $customer = $customer_result->fetch_assoc();
        echo "<h5>Customer Details</h5>";
        echo "<table class='table table-bordered table-light'>
                <tr><th>Borrower Name</th><td>{$customer['customer_name']}</td><th>Mobile</th><td>{$customer['mobile']}</td></tr>
               
                <tr><th>Address</th><td>{$customer['address']}</td><th>Aadhar</th><td>{$customer['aadhar']}</td></tr>

               
                 <tr><th>Given Loan</th><td>Rs. " . number_format($customer['given_loan_amt'], 2) . "</td><th>Loan Date</th><td>" . date("d/m/Y", strtotime($customer['loan_date'])) . "</td></tr>
                  </table>";
    } else {
        echo "<h5>No customer data found.</h5>";
    }

    // Display Loan Collection Records
    if ($collection_result->num_rows > 0) {
        echo "<h5>Loan Collection Details</h5>";
        echo "<table class='table table-bordered table-info'>
        <thead>
            <tr>
                <th>#</th>
                <th>Application No</th>
                <th>Collected Amount</th>
                <th>Collection Date</th>
            </tr>
        </thead>
        <tbody>";

$sn = 1; // Initialize serial number

while ($row = $collection_result->fetch_assoc()) {
    echo "<tr>
            <td>" . $sn++ . "</td>
            <td>" . strtoupper($row['application_number']) . "</td>
            <td>Rs. " . number_format($row['amount_collected'], 2) . "</td>
            <td>" . date("d/m/Y", strtotime($row['collection_date'])) . "</td>
          </tr>";
}

echo "</tbody></table>";

    } else {
        echo "<h5>No collection records found.</h5>";
    }

    $customer_stmt->close();
    $collection_stmt->close();
    $conn->close();
}
?>
