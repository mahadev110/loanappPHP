<?php
include 'includes/connection.php';

$from_date = $to_date = "";
$records = [];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];

    $sql = "SELECT c.application_number, c.customer_name, c.mobile, c.address, c.given_loan_amt, 
                   lc.amount_collected, lc.collection_date 
            FROM customers c
            JOIN loan_collections lc ON c.application_number = lc.application_number
            WHERE lc.collection_date BETWEEN ? AND ?
            ORDER BY lc.collection_date DESC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $from_date, $to_date);
    $stmt->execute();
    $result = $stmt->get_result();
    
    while ($row = $result->fetch_assoc()) {
        $records[] = $row;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Date Wise Loan Collection</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

 
</head>

<body>
    <div class="container mt-4">
        <div class="d-flex text-center ">
            <img src="images/loan-logo2.jpg" alt="Loan Logo" width="50" height="70">
            <h2 class="mt-3 mx-3">Loan Collection - Date Wise Search</h2>
        </div>
  <!-- Back Button -->
  <div class="text-end mb-3">
            <a href="index.php" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Back</a>
        </div>
        <!-- Search Form -->
         
        <form method="POST" class="my-4">
            <div class="row">
                <div class="col-md-4">
                    <label>From Date</label>
                    <input type="date" name="from_date" class="form-control" required value="<?= $from_date; ?>">
                </div>
                <div class="col-md-4">
                    <label>To Date</label>
                    <input type="date" name="to_date" class="form-control" required value="<?= $to_date; ?>">
                </div>
                <div class="col-md-4 mt-4">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
                </div>
            </div>
        </form>

        <!-- Results Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Application No.</th>
                        <th>Customer Name</th>
                        <th>Mobile</th>
                        <th>Address</th>
                        <th>Loan Amount</th>
                        <th>Collected Amount</th>
                        <th>Collection Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($records)) : 
                        $i = 1;
                        foreach ($records as $row) : ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= strtoupper($row['application_number']); ?></td>
                                <td><?= $row['customer_name']; ?></td>
                                <td><?= $row['mobile']; ?></td>
                                <td><?= $row['address']; ?></td>
                                <td>Rs. <?= number_format($row['given_loan_amt'], 2); ?></td>
                                <td>Rs. <?= number_format($row['amount_collected'], 2); ?></td>
                                <td><?= date("d/m/Y", strtotime($row['collection_date'])); ?></td>
                            </tr>
                    <?php endforeach;
                    else : ?>
                        <tr>
                            <td colspan="8" class="text-center">No records found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</body>

</html>
