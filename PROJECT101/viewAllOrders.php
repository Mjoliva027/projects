<?php
@include 'connection.php';
include "function.php";

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
   <title>Once Admin Page</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/adminCSS.css">
</head>
<body>

<?php require_once('include/nava.php'); ?>

<div id="ordersBtn">
    <h2>Pending Orders</h2>
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
                <th>Action</th> <!-- Added a new column for admin action -->
            </tr>
        </thead>
        <tbody>
            <?php
            $sqlOrders = "SELECT * FROM `orders` WHERE status = 'pending'"; // Select only pending orders
            $resultOrders = $con->query($sqlOrders);

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
                        <td><?= $row["quantity"] ?></td>
                        <td><?= $row["price_total"] ?></td>
                        <td>
                            <!-- Form to accept the order -->
                            <form method="post">
                                <input type="hidden" name="accept_order" value="<?= $row['order_id'] ?>">
                                <button type="submit" class="btn btn-primary" style="cursor: pointer;">Accept</button>
                            </form>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                echo "<tr><td colspan='10'>No pending orders</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Your JavaScript code for AJAX requests can go here
</script>

</body>
</html>
