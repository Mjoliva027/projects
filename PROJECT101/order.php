<?php
session_start();
include("connection.php");
include("function.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_id = mysqli_real_escape_string($con, $_POST['order_id']);
    $user_id = $_SESSION['user_id'];
    $admin_id = 1; // Assuming admin_id is 1 for simplicity. Adjust as necessary.

    // Fetch user and product details
    $userQuery = "SELECT fullname FROM users WHERE user_id = '$user_id'";
    $orderQuery = "SELECT prod_name, date_ordered FROM orders WHERE order_id = '$order_id'";

    $userResult = mysqli_query($con, $userQuery);
    $orderResult = mysqli_query($con, $orderQuery);

    if ($userResult && $orderResult) {
        $user = mysqli_fetch_assoc($userResult);
        $order = mysqli_fetch_assoc($orderResult);

        $userName = mysqli_real_escape_string($con, $user['fullname']);
        $productName = mysqli_real_escape_string($con, $order['prod_name']);
        $dateOrdered = mysqli_real_escape_string($con, $order['date_ordered']);

        // Insert a message into the messages table
        $message = "User $userName has received the order $productName.";
        $message = mysqli_real_escape_string($con, $message);
        
        $query = "INSERT INTO messages (user_id, order_id, message) VALUES ('$user_id', '$order_id', '$message')";

        if (mysqli_query($con, $query)) {
            // Update the order status to 'received'
            $updateQuery = "UPDATE orders SET status='received' WHERE order_id = '$order_id'";
            if (mysqli_query($con, $updateQuery)) {
                $_SESSION['success'] = "Order received confirmation sent to admin.";
            } else {
                $_SESSION['error'] = "Error updating the order status.";
            }
        } else {
            $_SESSION['error'] = "Error sending confirmation to admin.";
        }
    } else {
        $_SESSION['error'] = "Error fetching user or order details.";
    }

    // Redirect back to the orders page
    header("Location: order.php");
    exit();
}

// Fetch orders associated with the logged-in user that are not marked as 'received'
$user_id = $_SESSION['user_id'];
$orderQuery = "SELECT orders.order_id, users.fullname, orders.prod_name, orders.size, orders.quantity, orders.price_total, orders.status, orders.date_ordered 
               FROM orders 
               JOIN users ON orders.user_id = users.user_id 
               WHERE orders.user_id = '$user_id' AND orders.status != 'received'";

$orderResult = mysqli_query($con, $orderQuery);

$orders = [];
if ($orderResult) {
    while ($row = mysqli_fetch_assoc($orderResult)) {
        $orders[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Orders</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css">
    <style>
        /* Custom CSS styles */
        body {
            background-color: #f8f9fa;
        }

        .navbar-brand img {
            margin-right: 20px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-3">
        <div class="container">
            <a class="navbar-brand" href="product.php">
                <img src="images/shoe-haven-high-resolution-logo-transparent.png" width="50" height="50" alt="Shoe Haven Logo">
                Shoe Haven
            </a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="user_prof.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="inbox.php">Inbox</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="order.php">Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container py-5">
        <h2>Your Orders</h2>
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <?php if (count($orders) > 0): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Order ID</th>
                            <th>Name</th>
                            <th>Product Name</th>
                            <th>Size</th>
                            <th>Quantity</th>
                            <th>Total Price</th>
                            <th>Status</th>
                            <th>Order Date</th>
                            <th>Action</th> <!-- New column for the button -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $orderItem): ?>
    <tr>
        <td><?php echo htmlspecialchars($orderItem['order_id']); ?></td>
        <td><?php echo htmlspecialchars($orderItem['fullname']); ?></td>
        <td><?php echo htmlspecialchars($orderItem['prod_name']); ?></td>
        <td><?php echo htmlspecialchars($orderItem['size']); ?></td>
        <td><?php echo htmlspecialchars($orderItem['quantity']); ?></td>
        <td><?php echo htmlspecialchars($orderItem['price_total']); ?></td>
        <td><?php echo htmlspecialchars($orderItem['status']); ?></td>
        <td><?php echo htmlspecialchars($orderItem['date_ordered']); ?></td>
        <td>
            <?php if ($orderItem['status'] == 'delivered'): ?>
                <form method="POST">
                    <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($orderItem['order_id']); ?>">
                    <button type="submit" class="btn btn-success">Order Received</button>
                </form>
            <?php else: ?>
                <button class="btn btn-success" disabled>Order Received</button>
            <?php endif; ?>
        </td>
    </tr>
<?php endforeach;?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p>You have no orders.</p>
        <?php endif; ?>
    </main>
    <?php require_once('include/footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fAIlT894z9Opbl3NsR5U2vt8LP6SX9mzxNfuqsGOaptbwHjbWEjHWCH+wxNsoCSt" crossorigin="anonymous"></script>
</body>

</html>
