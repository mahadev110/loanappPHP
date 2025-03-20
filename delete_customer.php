<?php
include 'includes/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = intval($_POST['id']); // Get ID and sanitize

    // Start a transaction to ensure both updates succeed together
    $conn->begin_transaction();

    try {
        // Retrieve the application number from the customers table
        $sql_get_app_no = "SELECT application_number FROM customers WHERE id = ?";
        $stmt_get_app_no = $conn->prepare($sql_get_app_no);
        $stmt_get_app_no->bind_param("i", $id);
        $stmt_get_app_no->execute();
        $stmt_get_app_no->bind_result($application_number);
        $stmt_get_app_no->fetch();
        $stmt_get_app_no->close();

        if (!empty($application_number)) {
            // Update the isdelete field in customers table
            $sql1 = "UPDATE customers SET isdelete = 1 WHERE id = ?";
            $stmt1 = $conn->prepare($sql1);
            $stmt1->bind_param("i", $id);
            $stmt1->execute();
            $stmt1->close();

            // Update the isdelete field in loan_collections table using application_number
            $sql2 = "UPDATE loan_collections SET isdelete = 1 WHERE application_number = ?";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->bind_param("s", $application_number); // Use "s" because it's a string (VARCHAR)
            $stmt2->execute();
            $stmt2->close();
        }

        // Commit transaction if everything is successful
        $conn->commit();
        echo "success";
    } catch (Exception $e) {
        // Rollback transaction if there's an error
        $conn->rollback();
        echo "error: " . $e->getMessage();
    }

    $conn->close();
}
?>
