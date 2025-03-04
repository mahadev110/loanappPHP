<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Application</title>
    <link rel="icon" type="image/x-icon" href="images/loan-logo2.jpg">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>

    <div class="container mt-4">
        <div class="d-flex text-center ">
            <img src="images/loan-logo2.jpg" alt="Loan Logo" width="50" height="70">
            <h2 class="mt-3 mx-3">Loan Application Process</h2>
        </div>

        <!-- Loan Application Form -->
        <div class="card text-bg-light mt-3">
            <div class="card-body">

                <div class="row mb-3">
                    <!-- Left Side: Form -->
                    <div class="col-md-4">
                        <form action="save_collection.php" method="POST">
                            <label class="form-label">Application Number:</label>
                            <input type="text" class="form-control mb-2" id="app_number" name="application_number"
                                placeholder="Enter Application Number" onkeyup="fetchBorrower()">

                            <label class="form-label">Borrower Name:</label>
                            <input type="text" class="form-control mb-2" id="borrower_name" name="borrower_name"
                                placeholder="" readonly
                                style="background-color: #f8d7da; color: #721c24; font-weight: bold;">

                            <label class="form-label">Amount Collected:</label>
                            <input type="text" class="form-control mb-2" name="amount_collected"
                                placeholder="Enter Amount">

                            <label class="form-label">Date:</label>
                            <input type="date" class="form-control mb-3" name="collection_date">

                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                            <input class="btn btn-primary" type="reset" value="Reset">
                        </form>
                    </div>

                    <!-- Right Side: Table -->
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                                <!-- Set fixed height & scroll -->
                                <?php
                                include 'includes/connection.php';
                                // Fetch only the latest 6 records from loan_collections table
                                $sql = "SELECT id, application_number, amount_collected, collection_date 
                                FROM loan_collections 
                                ORDER BY id DESC";
                                $result = $conn->query($sql);
                                ?>

                                <table class="table table-hover table-bordered">
                                    <thead class="table-dark">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Application No.</th>
                                            <th scope="col">Collected Amt</th>
                                            <th scope="col">Collected Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($result->num_rows > 0) {
                                            $count = 1; // Initialize serial number before the loop
                                            while ($row = $result->fetch_assoc()) {
                                                ?>
                                                <tr>
                                                    <th scope='row'><?php echo $count++; ?></th>
                                                    <!-- Increment inside the loop -->
                                                    <td><?php echo strtoupper($row['application_number']); ?></td>
                                                    <td>Rs. <?php echo number_format($row['amount_collected'], 2); ?></td>
                                                    <td><?php echo date("d/m/Y", strtotime($row['collection_date'])); ?></td>
                                                </tr>
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <tr>
                                                <td colspan="4" class="text-center">No records found</td>
                                            </tr>
                                            <?php
                                        }
                                        ?>

                                    </tbody>
                                </table>

                                <?php $conn->close(); ?> <!-- Close the connection -->
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

        <!-- Search Bar -->
        <div class="card mt-5">
            <div class="card-body">
                <div class="row">
                    <!-- Search Input and Button -->
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="text" id="searchAppNumber" class="form-control"
                                placeholder="Search by Application Number">
                            <button class="btn btn-primary" id="searchButton"><i class="fa fa-search"></i>
                                Search</button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!-- Icons in the Last Corner -->
                        <div class="text-end">
                            <a href="new_customer.php"> <button class="btn btn-success me-2"><i class="fa fa-plus"></i>
                                    Create
                                    New Customer</button></a>
                            <a href="date_search.php">
                                <button class="btn btn-warning"><i class="fa fa-star"></i>
                                    Date wise view</button></a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script>
        function fetchBorrower() {
            var appNumber = document.getElementById("app_number").value;
            if (appNumber.length > 0) {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "fetch_borrower.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        document.getElementById("borrower_name").value = xhr.responseText;
                    }
                };
                xhr.send("app_number=" + encodeURIComponent(appNumber));
            } else {
                document.getElementById("borrower_name").value = "";
            }
        }
    </script>
</body>

</html>


<!-- Modal -->
<!-- Modal -->
<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="searchModalLabel">Loan & Collection Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalContent">
                <!-- Data from fetch_data.php will be inserted here -->
            </div>
        </div>
    </div>
</div>

<!-- jQuery and AJAX -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $("#searchButton").click(function () {
            var appNumber = $("#searchAppNumber").val();

            if (appNumber === "") {
                alert("Please enter an application number!");
                return;
            }

            $.ajax({
                url: "fetch_data.php",
                type: "POST",
                data: { application_number: appNumber },
                success: function (response) {
                    $("#modalContent").html(response);
                    $("#searchModal").modal("show");
                },
                error: function () {
                    alert("Error fetching data.");
                }
            });
        });
    });

</script>