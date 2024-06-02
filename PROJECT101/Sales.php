<?php
@include 'connection.php';
include "function.php";

// Check if an order has been accepted
if(isset($_POST['accept_order'])){
    $orderId = $_POST['accept_order'];
    // Update the order status to accepted in the database
    $sqlUpdateOrder = "UPDATE `orders` SET status = 'accepted' WHERE order_id = '$orderId'";
    $con->query($sqlUpdateOrder);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Page</title>
    <link rel="stylesheet" href="css/adminCSS.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  

   <style>
       /* Make the table more compact */
       table.table {
           width: 100%;
           border-collapse: collapse;
       }
       table.table th, table.table td {
           padding: 5px;
           font-size: 12px;
           text-align: center;
       }
       table.table td {
           border: 1px solid #ddd;
       }
   </style>
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
                <th>Product</th>
                <th>Fullname</th>
                <th>Address</th>
                <th>Zip code</th>
                <th>Phone No.</th>
                <th>Payment Method</th>
                <th>Gcash reference</th>
                <th>acc name</th>
                <th>acc number</th>
                <th>amount</th>
                <th>Total Product</th>
                <th>Price Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sqlOrders = "SELECT * FROM `orders` WHERE status = 'received'"; // Select only accepted orders
            $resultOrders = $con->query($sqlOrders);

            $totalPaidSales = 0;

            if ($resultOrders->num_rows > 0) {
                while ($row = $resultOrders->fetch_assoc()) {
                    ?>
                    <tr>
                    <td>
                        <?= $row["o_id"] ?></td>
                        <td><?= $row["order_id"] ?></td>
                        <td><?= $row["prod_name"] ?></td>
                        <td><?= $row["fullname"] ?></td>
                        <td><?= $row["address"] ?></td>
                        <td><?= $row["zip_code"] ?></td>
                        <td><?= $row["phone_num"] ?></td>
                        <td><?= $row["payment"] ?></td>
                        <td><?= $row["gcash_reference"] ?></td>
                        <td><?= $row["acc_name"] ?></td>
                        <td><?= $row["acc_number"] ?></td>
                        <td><?= $row["amount_paid"] ?></td>
                        <td><?= $row["quantity"] ?></td>
                        <td>₱<?= $row["price_total"] ?></td>
                    </tr>
                    <?php
                    // Accumulate price_total to calculate total sales
                    $totalPaidSales += $row["price_total"];
                }
            } else {
                echo "<tr><td colspan='10'>No accepted orders</td></tr>";
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
