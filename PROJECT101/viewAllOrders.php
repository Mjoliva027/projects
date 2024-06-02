<?php
@include 'connection.php';
include "function.php";

if(isset($_POST['order_action'])){
    $orderId = $_POST['order_id'];
    $action = $_POST['order_action'];

    // Determine the next status based on the current action
    switch($action) {
        case 'accept':
            $nextStatus = 'accepted';
            $message = "Your order #$orderId has been accepted.";
            break;
        case 'ship':
            $nextStatus = 'shipped';
            $message = "Your order #$orderId has been shipped.";
            break;
        case 'deliver':
            $nextStatus = 'delivered';
            $message = "Your order #$orderId has been delivered.";
            break;
        default:
            $nextStatus = 'pending';
            $message = "";
    }

    // Update the order status in the database
    $sqlUpdateOrder = "UPDATE `orders` SET status = '$nextStatus' WHERE order_id = '$orderId'";
    if ($con->query($sqlUpdateOrder) === TRUE) {
        // Get the user_id associated with the order
        $sqlGetUser = "SELECT user_id FROM `orders` WHERE order_id = '$orderId'";
        $resultUser = $con->query($sqlGetUser);
        if ($resultUser->num_rows > 0) {
            $rowUser = $resultUser->fetch_assoc();
            $userId = $rowUser['user_id'];

            // Insert a message into the inbox
            $sqlInsertMessage = "INSERT INTO `inbox` (user_id, order_id, message) VALUES ('$userId', '$orderId', '$message')";
            $con->query($sqlInsertMessage);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin age</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/adminCSS.css">
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
       button.btn {
           padding: 5px 10px;
           font-size: 12px;
       }
   </style>
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
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sqlOrders = "SELECT * FROM `orders` WHERE status IN ('pending', 'accepted', 'shipped')"; // Select relevant orders
            $resultOrders = $con->query($sqlOrders);

            if ($resultOrders->num_rows > 0) {
                while ($row = $resultOrders->fetch_assoc()) {
                    $currentStatus = $row["status"];
                    $nextAction = "";
                    $buttonText = "";

                    // Determine the next action and button text based on the current status
                    switch($currentStatus) {
                        case 'pending':
                            $nextAction = 'accept';
                            $buttonText = 'Accept';
                            break;
                        case 'accepted':
                            $nextAction = 'ship';
                            $buttonText = 'Ship';
                            break;
                        case 'shipped':
                            $nextAction = 'deliver';
                            $buttonText = 'Deliver';
                            break;
                    }
                    ?>
                    <tr>
                        <td><?= $row["o_id"] ?></td>
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
                        <td>
                            <!-- Form to accept the order -->
                            <form method="post">
                                <input type="hidden" name="order_id" value="<?= $row['order_id'] ?>">
                                <input type="hidden" name="order_action" value="<?= $nextAction ?>">
                                <button type="submit" class="btn btn-primary" style="cursor: pointer;"><?= $buttonText ?></button>
                            </form>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                echo "<tr><td colspan='11'>No orders to display</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</body>
</html>
