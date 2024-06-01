<?php
session_start();
include("connection.php");
include("function.php");

// Fetch messages for admin inbox
$query = "SELECT m.message_id, m.message, m.received_date, u.fullname, o.prod_name 
          FROM messages m
          JOIN users u ON m.user_id = u.user_id
          JOIN orders o ON m.order_id = o.order_id
          ORDER BY m.received_date DESC";
$resultInbox = mysqli_query($con, $query);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_message'])) {
    $message_id = mysqli_real_escape_string($con, $_POST['message_id']);

    $query = "DELETE FROM messages WHERE message_id = '$message_id'";

    if (mysqli_query($con, $query)) {
        $_SESSION['success'] = "Message deleted successfully.";
    } else {
        $_SESSION['error'] = "Error deleting message.";
    }

    // Redirect back to the admin inbox page
    header("Location: order_received.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Inbox</title>
    <link rel="stylesheet" href="css/adminCSS.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        
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
        .alert {
            max-width: 800px;
            margin: 0 auto 20px;
        }
    </style>
</head>

<body>

<?php require_once('include/nava.php'); ?>
    <div class="container">

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <div class="inbox-container">
            <h1 class="inbox-header">Admin Inbox</h1>
            <div class="table-container">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>User</th>
                            <th>Product</th>
                            <th>Message</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($resultInbox && mysqli_num_rows($resultInbox) > 0) {
                            while ($row = mysqli_fetch_assoc($resultInbox)) {
                                ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row["received_date"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["fullname"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["prod_name"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["message"]); ?></td>
                                    <td>
                                        <!-- Form to delete the message -->
                                        <form method="post" style="display:inline;">
                                            <input type="hidden" name="message_id" value="<?php echo htmlspecialchars($row['message_id']); ?>">
                                            <button type="submit" name="delete_message" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this message?');">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "<tr><td colspan='5'>No messages to display</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-fAIlT894z9Opbl3NsR5U2vt8LP6SX9mzxNfuqsGOaptbwHjbWEjHWCH+wxNsoCSt" crossorigin="anonymous"></script>
</body>
</html>
