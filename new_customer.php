<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Customer - Loan Application</title>
    <link rel="icon" type="image/x-icon" href="images/loan-logo2.jpg">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>

    <div class="container mt-4">

        <div class="d-flex text-center ">
            <img src="images/loan-logo2.jpg" alt="Loan Logo" width="50" height="70">
            <h2 class="mt-3 mx-3">New Customer Registration</h2>
        </div>
        <!-- Back Button -->
        <div class="text-end mb-3">
            <a href="index.php" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Back</a>
        </div>

        <div class="card text-bg-light ">
            <div class="card-body">
                <form action="save_customer.php" method="POST">
                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label">Application No:</label>
                            <input type="text" name="application_number" class="form-control"
                                placeholder="Enter Application No." required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Customer Name:</label>
                            <input type="text" name="customer_name" class="form-control"
                                placeholder="Enter Customer Name" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Mobile:</label>
                            <input type="text" name="mobile" class="form-control" placeholder="Enter Mobile Number"
                                pattern="\d{10}" title="Enter a valid 10-digit mobile number" required>
                        </div>

                    </div>

                    <!-- 2nd Row -->
                    <div class="row mt-2">
                        <div class="col-md-4">
                            <label class="form-label">Address:</label>
                            <textarea name="address" class="form-control" placeholder="Enter Address" rows="2"
                                required></textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">PAN Number:</label>
                            <input type="text" name="pan" class="form-control" placeholder="Enter PAN Number"
                                pattern="[A-Z]{5}[0-9]{4}[A-Z]{1}" title="Enter a valid PAN (e.g. ABCDE1234F)">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Aadhar Number:</label>
                            <input type="text" name="aadhar" class="form-control" placeholder="Enter Aadhar Number"
                                pattern="\d{12}" title="Enter a valid 12-digit Aadhar number">
                        </div>

                    </div>

                    <!-- 3rd Row -->
                    <div class="row mt-2">

                        <div class="col-md-4">
                            <label class="form-label">Given Loan Amount:</label>
                            <input type="number" name="given_loan_amt" class="form-control"
                                placeholder="Enter Given Loan Amount" min="0" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Loan Date:</label>
                            <input type="date" name="loan_date" class="form-control" required>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Customer</button>

                        <input class="btn btn-primary" type="reset" value="Reset">
                    </div>
                </form>
            </div>
        </div>
        <?php include 'includes/connection.php'; ?>
<!-- List view -->
<div class="card">
    <div class="card-body">
        <table class="table table-hover table-bordered">
            <thead class="table-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Application No.</th>
                    <th scope="col">Customer Name</th>
                    <th scope="col">Mobile</th>
                    <th scope="col">PAN No.</th>
                    <th scope="col">Aadhar</th>
                    <th scope="col">Loan Given Amount</th>
                    <th scope="col">Sanctioned Date</th>
                    <th scope="col">Action</th> <!-- New Column for Delete -->
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT id, application_number, customer_name, mobile, pan, aadhar, given_loan_amt, loan_date 
                FROM customers 
                WHERE isdelete = 0 
                ORDER BY id DESC";
        
                // $sql = "SELECT id, application_number, customer_name, mobile, pan, aadhar, given_loan_amt, loan_date FROM customers ORDER BY id DESC";
                $result = $conn->query($sql);
                $count = 1; // Serial number

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <th scope='row'>{$count}</th>
                            <td>{$row['application_number']}</td>
                            <td>{$row['customer_name']}</td>
                            <td>{$row['mobile']}</td>
                            <td>{$row['pan']}</td>
                            <td>{$row['aadhar']}</td>
                            <td>₹ " . number_format($row['given_loan_amt'], 2) . "</td>
                            <td>{$row['loan_date']}</td>
                            <td>
                                <button class='btn btn-danger btn-sm delete-btn' data-id='{$row['id']}'>
                                    <i class='fa fa-trash'></i>
                                </button>
                            </td>
                          </tr>";
                        $count++;
                    }
                } else {
                    echo "<tr><td colspan='9' class='text-center'>No records found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- JavaScript for Delete Confirmation -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $(".delete-btn").click(function() {
        var customerId = $(this).data("id");
        if (confirm("Are you sure you want to delete this customer record? This will also delete the associated loan collection details.")) {
            $.ajax({
                url: "delete_customer.php",
                type: "POST",
                data: { id: customerId },
                success: function(response) {
                    if (response == "success") {
                        alert("Record deleted successfully!");
                        location.reload();
                    } else {
                        alert("Failed to delete record.");
                    }
                }
            });
        }
    });
});
</script>


        <?php
        // Close database connection
        $conn->close();
        ?>

    </div>

</body>

</html>