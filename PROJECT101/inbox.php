<?php
session_start();
include 'connection.php';
include "function.php";

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

$user_id = $_SESSION['user_id']; 

// Check if a delete request has been made
if (isset($_POST['delete_message'])) {
    $messageId = $_POST['message_id'];
    $sqlDeleteMessage = "DELETE FROM `inbox` WHERE order_id = '$messageId' AND user_id = '$user_id'";
    $con->query($sqlDeleteMessage);
}

$sqlInbox = "SELECT * FROM `inbox` WHERE user_id = '$user_id' ORDER BY date_sent DESC";
$resultInbox = $con->query($sqlInbox);

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>User Inbox</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
   <link rel="stylesheet" href="bootstrap-5.3.2-dist/css/bootstrap.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <style>
     .navbar-brand img {
            margin-right: 20px;
     }

     .inbox-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
     }

     .inbox-header {
            font-size: 30px;
            color: black;
            text-align: center;
            margin-bottom: 20px;
     }

     .table-container {
            display: flex;
            justify-content: center;
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

<div class="inbox-container">
    <h1 class="inbox-header">Inbox</h1>
    <div class="table-container">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Order ID</th>
                    <th>Message</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($resultInbox->num_rows > 0) {
                    while ($row = $resultInbox->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?= $row["date_sent"] ?></td>
                            <td><?= $row["order_id"] ?></td>
                            <td><?= $row["message"] ?></td>
                            <td>
                                <!-- Form to delete the message -->
                                <form method="post" style="display:inline;">
                                    <input type="hidden" name="message_id" value="<?= $row['order_id'] ?>">
                                    <button type="submit" name="delete_message" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this message?');">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<tr><td colspan='4'>No messages to display</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-fAIlT894z9Opbl3NsR5U2vt8LP6SX9mzxNfuqsGOaptbwHjbWEjHWCH+wxNsoCSt" crossorigin="anonymous"></script>
</body>
</html>
