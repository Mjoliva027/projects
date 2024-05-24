<?php
session_start();
include("connection.php");
include("function.php");

$user_id = $_SESSION['user_id'];

// Check if the user is logged in
if (!isset($user_id)) {
    header("Location: login.php");
    exit();
}

// Fetch orders for the logged-in user
$query = "SELECT * FROM `orders` WHERE user_id = '$user_id' LIMIT 1";
$result = mysqli_query($con, $query);

$order = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $order[] = $row;
    }
} else {
    $error = "Error fetching orders from database.";
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
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <?php if (count($order) > 0): ?>
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
                            <th>Order Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($order as $orderItem): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($orderItem['order_id']); ?></td>
                                <td><?php echo htmlspecialchars($orderItem['fullname']); ?></td>
                                <td><?php echo htmlspecialchars($orderItem['prod_name']); ?></td>
                                <td><?php echo htmlspecialchars($orderItem['size']); ?></td>
                                <td><?php echo htmlspecialchars($orderItem['quantity']); ?></td>
                                <td><?php echo htmlspecialchars($orderItem['price_total']); ?></td>
                                <td><?php echo htmlspecialchars($orderItem['date_ordered']); ?></td>    
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p>You have no orders.</p>
        <?php endif; ?>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fAIlT894z9Opbl3NsR5U2vt8LP6SX9mzxNfuqsGOaptbwHjbWEjHWCH+wxNsoCSt" crossorigin="anonymous"></script>
</body>

</html>
