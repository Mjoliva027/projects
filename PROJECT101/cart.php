<?php
session_start();
include("connection.php");
include("function.php");

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$_SESSION;

if (isset($_POST['update_update_btn'])) {
    $update_value = $_POST['update_quantity'];
    $update_id = $_POST['update_quantity_id'];
    $update_quantity_query = mysqli_query($con, "UPDATE `cart` SET quantity = '$update_value' WHERE id = '$update_id'");
    if ($update_quantity_query) {
        header('location:cart.php');
    };
};

if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];
    mysqli_query($con, "DELETE FROM `cart` WHERE id = '$remove_id'");
    header('location:cart.php');
};

if (isset($_GET['delete_all'])) {
    mysqli_query($con, "DELETE FROM `cart`");
    header('location:cart.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="bootstrap-5.3.2-dist/css/bootstrap.css">
    <script src="https://kit.fontawesome.com/c8fb92272e.js" crossorigin="anonymous"></script>
    <title>Shoe Haven</title>
    <style>
        /* Adjust padding and margin for table cells */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        /* Set specific padding for columns */
        th.img,
        td.img {
            width: 15%;
            /* Adjust width as needed */
        }

        th.name,
        td.name {
            width: 25%;
            /* Adjust width as needed */
        }

        th.price,
        td.price,
        th.size,
        td.size,
        th.qty,
        td.qty,
        th.tp,
        td.tp,
        th.action,
        td.action {
            width: 10%;
            /* Adjust width as needed */
        }

        /* Center align text in the 'ACTION' column */
        td.action {
            text-align: center;
        }
    </style>
    <title>Shoe Haven</title>
</head>

<body>
    <?php require_once('include/cartnav.php'); ?>


    <div class="container">

        <section class="shopping-cart">

            <h3 style="margin-top:8%;">shopping cart</h3>

            <table>
                <thead>
                    <tr>
                        <th class="img">IMAGE</th>
                        <th class="name">NAME</th>
                        <th class="price">PRICE</th>
                        <th class="size">SIZE</th>
                        <th class="qty">QUANTITY</th>
                        <th class="tp">TOTAL PRICE</th>
                        <th class="action">ACTION</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $select_cart = mysqli_query($con, "SELECT * FROM `cart` WHERE user_id = '" . $_SESSION['user_id'] . "'");
                    $grand_total = 0;

                    if (mysqli_num_rows($select_cart) > 0) {
                        while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                            // Calculate subtotal for each item
                            $sub_total = $fetch_cart['price'] * $fetch_cart['quantity'];
                            // Accumulate subtotal to grand total
                            $grand_total += $sub_total;
                    ?>
                            <tr>
                                <td class="img"><img src="./images/<?php echo $fetch_cart['image']; ?>" height="100" alt="product"></td>
                                <td class="name"><?php echo $fetch_cart['name']; ?></td>
                                <td class="price">₱<?php echo $fetch_cart['price']; ?></td>
                                <td class="size"><?php echo $fetch_cart['size']; ?></td>
                                <td class="qty">
                                    <form action="" method="post">
                                        <input type="hidden" name="update_quantity_id" value="<?php echo $fetch_cart['id']; ?>">
                                        <input type="number" name="update_quantity" min="1" value="<?php echo $fetch_cart['quantity']; ?>">
                                        <input type="submit" value="update" name="update_update_btn">
                                    </form>
                                </td>
                                <td class="tp">₱<?php echo number_format($sub_total); ?></td>
                                <td class="action"><a href="cart.php?remove=<?php echo $fetch_cart['id']; ?>" onclick="return confirm('remove item from cart?')" class="delete-btn"> <i class="fas fa-trash"></i> remove</a></td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                    <tr class="table-bottom">
                        <td colspan="5">Grand Total</td>
                        <td>₱<?php echo number_format($grand_total); ?></td>
                        <td class="action"><a href="cart.php?delete_all" onclick="return confirm('are you sure you want to delete all?');" class="delete-btn"> <i class="fas fa-trash"></i> delete all </a></td>
                    </tr>
                </tbody>
            </table>

            <div class="checkout-btn mt-4" style="margin-left: 90%;">
               <a href="checkout.php" class="btn btn-primary"<?= ($grand_total > 1) ? '' : 'disabled'; ?> >Checkout</a>
            </div>

        </section>

    </div>
    <?php require_once('include/footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="bootstrap-5.3.2-dist/js/bootstrap.bundle.js"></script>

</body>

</html>