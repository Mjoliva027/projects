<?php

@include 'connection.php';
include "function.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Once Admin Page</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/adminCSS.css">
</head>
<body>

<?php require_once('include/nava.php'); ?>

<div id="ordersBtn">
    <h2>Order Details</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Order ID</th>
                <th>Fullname</th>
                <th>Address</th>
                <th>Zip code</th>
                <th>Phone No.</th>
                <th>Payment Method</th>
                <th>Total Product</th>
                <th>Price Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sqlOrders = "SELECT * FROM `order`"; // Enclose 'order' in backticks as it's a reserved keyword
            $resultOrders = $con->query($sqlOrders);

            $totalPaidSales = 0;

            if ($resultOrders->num_rows > 0) {
                while ($row = $resultOrders->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?= $row["o_id"] ?></td>
                        <td><?= $row["order_id"] ?></td>
                        <td><?= $row["fullname"] ?></td>
                        <td><?= $row["address"] ?></td>
                        <td><?= $row["zip_code"] ?></td>
                        <td>₱<?= $row["number"] ?></td>
                        <td><?= $row["payment"] ?></td>
                        <td><?= $row["total_product"] ?></td>
                        <td><?= $row["price_total"] ?></td>
                    </tr>
                    <?php
                    // Accumulate price_total to calculate total sales
                    $totalPaidSales += $row["price_total"];
                }
            }

            ?>
        </tbody>
    </table>
    <p class="total-sales">Total Sales: ₱<?= $totalPaidSales ?></p> 
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Your JavaScript code for AJAX requests can go here
</script>

</body>
</html>
