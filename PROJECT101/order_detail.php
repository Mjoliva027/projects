<?php
session_start();
include("connection.php");

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$order_id = $_GET['order_id'];

// Retrieve the specific order for the logged-in user
$query = "SELECT * FROM orders WHERE order_id = '$order_id' AND user_id = '$user_id'";
$result = mysqli_query($con, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $order = mysqli_fetch_assoc($result);
} else {
    echo "Order not found.";
    exit();
}

// Retrieve order items
$query_items = "SELECT * FROM `order` WHERE order_id = '$order_id'";
$result_items = mysqli_query($con, $query_items);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Detail</title>
    <link rel="stylesheet" href="bootstrap-5.3.2-dist/css/bootstrap.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <nav class="navbar-expand-lg bg-dark text-white py-3">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <a class="navbar-brand" href="product.php">
                        <img src="images/shoe-haven-high-resolution-logo-transparent.png" width="50" height="50" style="margin-right: 20px;" alt="Shoe Haven Logo">
                        Shoe Haven
                    </a>
                </div>
                <div class="col-md-6 text-end d-flex align-items-center justify-content-center ">
                    <nav class="nav">
                        <a class="nav-link" href="profile.php">Profile</a>
                        <a class="nav-link" href="#">Inbox</a>
                        <a class="nav-link" href="orders.php">Orders</a>
                        <a class="nav-link" href="logout.php">Logout</a>
                    </nav>
                </div>
            </div>

        </div>
    </nav>

    <main class="container py-5">
        <h2>Order Detail</h2>
        <p>Order ID: <?php echo htmlspecialchars($order['order_id']); ?></p>
        <p>Order Date: <?php echo htmlspecialchars($order['order_date']); ?></p>
        <p>Total Amount: $<?php echo htmlspecialchars($order['price_total']); ?></p>

        <h3>Order Items</h3>
        <?php if (mysqli_num_rows($result_items) > 0): ?>
            <ul class="list-group">
                <?php while ($item = mysqli_fetch_assoc($result_items)): ?>
                    <li class="list-group-item">
                        <?php echo htmlspecialchars($item['total_product']); ?> - $<?php echo htmlspecialchars($item['price']); ?>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>No items found for this order.</p>
        <?php endif; ?>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fAIlT894z9Opbl3NsR5U2vt8LP6SX9mzxNfuqsGOaptbwHjbWEjHWCH+wxNsoCSt" crossorigin="anonymous"></script>
</body>

</html>
