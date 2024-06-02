<?php
session_start();
include("connection.php");
include("function.php");

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['place_order'])) {
    $fullname = mysqli_real_escape_string($con, $_POST['fullname']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $zip_code = mysqli_real_escape_string($con, $_POST['zip_code']);
    $phone_num = mysqli_real_escape_string($con, $_POST['phone_num']);
    $payment = mysqli_real_escape_string($con, $_POST['payment']);
    $gcash_reference = isset($_POST['gcash_reference']) ? mysqli_real_escape_string($con, $_POST['gcash_reference']) : null;
    $gcash_account_name = isset($_POST['gcash_account_name']) ? mysqli_real_escape_string($con, $_POST['gcash_account_name']) : null;
    $gcash_account_number = isset($_POST['gcash_account_number']) ? mysqli_real_escape_string($con, $_POST['gcash_account_number']) : null;
    $gcash_amount = isset($_POST['gcash_amount']) ? mysqli_real_escape_string($con, $_POST['gcash_amount']) : null;

    $select_cart = mysqli_query($con, "SELECT * FROM `cart` WHERE user_id = '$user_id'");
    $quantity = 0;
    $price_total = 0;
    $product_names = [];
    $product_size = [];

    if (mysqli_num_rows($select_cart) > 0) {
        while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
            $product_price = $fetch_cart['price'] * $fetch_cart['quantity'];
            $price_total += $product_price;
            $product_names[] = mysqli_real_escape_string($con, $fetch_cart['name']);
            $product_size[] = mysqli_real_escape_string($con, $fetch_cart['size']);
            $quantity += $fetch_cart['quantity'];
            $color_id = mysqli_real_escape_string($con, $fetch_cart['color_id']);
            $product_quantity = $fetch_cart['quantity'];

            $update_stock = mysqli_query($con, "UPDATE `color` SET stock = stock - $product_quantity WHERE color_id = '$color_id'");

            if (!$update_stock) {
                die('Error updating stock: ' . mysqli_error($con));
            }
        }
    }

    $prod_name = implode(', ', $product_names);
    $size = implode(', ', $product_size);
    $order_id = random_num(15);

    $detail_query = mysqli_query($con, "INSERT INTO `orders`(`order_id`, `fullname`, `address`, `zip_code`, `phone_num`, `payment`, `prod_name`, `size`, `quantity`, `price_total`, `user_id`, `gcash_reference`, `acc_name`, `acc_number`, `amount_paid`) 
        VALUES('$order_id', '$fullname', '$address', '$zip_code', '$phone_num', '$payment', '$prod_name', '$size', '$quantity', '$price_total', '$user_id', '$gcash_reference', '$gcash_account_name', '$gcash_account_number', '$gcash_amount')") or die('query failed: ' . mysqli_error($con));

    if ($detail_query) {
        $delete_cart = mysqli_query($con, "DELETE FROM `cart` WHERE user_id = '$user_id'");

        if (!$delete_cart) {
            die('Error deleting cart items: ' . mysqli_error($con));
        }

        $_SESSION['success'] = "
        <div class='alert alert-success alert-dismissible fade show position-fixed top-50 start-50 translate-middle' role='alert' style='z-index: 9999;'>
            <div class='message-container'>
                <h3>Thank you for shopping!</h3>
                <div class='order-detail'>
                    <p>Product Name: <span>$prod_name</span></p>
                    <p>Size: <span>$size</span></p>
                    <span>Total Quantity: $quantity</span>
                    <span class='total'>Total: ₱$price_total</span>
                </div>
                <div class='customer-details'>
                    <p>Your name: <span>$fullname</span></p>
                    <p>Your number: <span>$phone_num</span></p>
                    <p>Your address: <span>$address - $zip_code</span></p>
                    <p>Your payment mode: <span>$payment</span></p>
                    <p>(*pay when product arrives*)</p>
                </div>
                <a href='product.php' class='btn btn-primary'>Continue shopping</a>
            </div>
        </div>";
        header("Location: order_confirmation.php");
        exit;
    }
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
</head>
<body>
<?php require_once('include/nav.php'); ?>
    <div class="container">
        <header class="header" style="margin-bottom: 8%;"></header>
        <main class="content">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="mb-3">Order Summary</h3>

                    <?php
                    $cart_query = mysqli_query($con, "SELECT * FROM `cart` WHERE user_id = '$user_id'");
                    $price_total = 0;
                    $product_name = [];

                    if (mysqli_num_rows($cart_query) > 0) {
                        while ($fetch_cart = mysqli_fetch_assoc($cart_query)) {
                            $product_name[] = $fetch_cart['name'] . ' (' . $fetch_cart['quantity'] . ')';
                            $product_price = $fetch_cart['price'] * $fetch_cart['quantity'];
                            $price_total += $product_price;
                    ?>

                            <div class="card mb-1">
                                <div class="card-body d-flex flex-wrap">
                                    <div class="item-image flex-shrink-0 me-5">
                                        <img src="./images/<?php echo $fetch_cart['image']; ?>" width="100" height="100" alt="product">
                                    </div>
                                    <div class="item-desc flex-grow-1">
                                        <p class="item-name mb-1">Name: <?php echo $fetch_cart['name']; ?></p>
                                        <p class="item-qty mb-1">Quantity: <?php echo $fetch_cart['quantity']; ?></p>
                                        <?php if (!empty($fetch_cart['size'])) { ?>
                                            <p class="item-size">Size: <?php echo $fetch_cart['size']; ?></p>
                                        <?php } ?>
                                        <p class="item-price mb-0 mt-0">Price: ₱<?php echo $fetch_cart['price']; ?></p>
                                    </div>
                                </div>
                            </div>

                    <?php
                        }
                    }
                    ?>

                    <hr>

                    <div class="d-flex justify-content-between mt-2">
                        <p class="text-muted">Subtotal:</p>
                        <p class="h5">₱<?php echo number_format($price_total); ?></p>
                    </div>
                    <div class="d-flex justify-content-between mt-2">
                        <p class="text-muted">Delivery/Shipping:</p>
                        <p class="h5">Free</p>
                    </div>
                    <div class="d-flex justify-content-between mt-2">
                        <p class="text-muted">Total:</p>
                        <p class="h5">₱<?php echo number_format($price_total); ?></p>
                    </div>
                </div>

                <div class="col-md-6">
                    <h3 class="mb-3">Enter your details</h3>
                    <div id="error-message" class="alert alert-danger" style="display: none;"></div> <!-- Error message container -->
                    <form id="order-form" method="POST">
                        <div class="form-floating mb-3 col-md-12">
                            <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Enter your full name" required>
                            <label for="fullname">Full Name</label>
                        </div>
                        <div class="form-floating mb-3 col-md-12">
                            <input type="text" class="form-control" id="address" name="address" placeholder="Enter your address" required>
                            <label for="address">Address</label>
                        </div>
                        <div class="form-floating mb-3 col-md-12">
                            <input type="number" class="form-control" id="zip_code" name="zip_code" placeholder="Enter your zip code" required>
                            <label for="zip_code">Zip Code</label>
                        </div>
                        <div class="form-floating mb-3 col-md-12">
                            <input type="text" class="form-control" id="phone_num" name="phone_num" placeholder="Enter your phone number" required>
                            <label for="phone_num">Phone Number</label>
                        </div>
                        <div class="form-floating mb-3 col-md-12">
                            <select class="form-select" id="payment" name="payment" required>
                                <option value="cod">Cash on Delivery</option>
                                <option value="gcash">GCash</option>
                            </select>
                            <label for="payment">Payment Method</label>
                        </div>
                        <div id="gcash_fields" style="display: none;">
                            <div class="form-floating mb-3 col-md-12">
                                <input type="text" class="form-control" id="gcash_reference" name="gcash_reference" placeholder="Enter GCash Reference Number">
                                <label for="gcash_reference">GCash Reference Number</label>
                            </div>
                            <div class="form-floating mb-3 col-md-12">
                                <input type="text" class="form-control" id="gcash_account_name" name="gcash_account_name" placeholder="Enter GCash Account Name">
                                <label for="gcash_account_name">GCash Account Name</label>
                            </div>
                            <div class="form-floating mb-3 col-md-12">
                                <input type="text" class="form-control" id="gcash_account_number" name="gcash_account_number" placeholder="Enter GCash Account Number">
                                <label for="gcash_account_number">GCash Account Number</label>
                            </div>
                            <div class="form-floating mb-3 col-md-12">
                                <input type="number" class="form-control" id="gcash_amount" name="gcash_amount" placeholder="Enter GCash Amount">
                                <label for="gcash_amount">GCash Amount</label>
                                <div id="gcash-error-message" class="text-danger mt-1" style="display: none;"></div> <!-- GCash amount error message container -->
                            </div>
                        </div>
                        <div class="d-grid gap-2 col-6 mx-auto mb-5">
                            <button class="btn btn-primary" type="button" id="place_order">Place Order</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
    <script>
        var priceTotal = <?php echo $price_total; ?>; // Get the total price from PHP

        document.getElementById('payment').addEventListener('change', function() {
            var gcashFields = document.getElementById('gcash_fields');
            if (this.value === 'gcash') {
                gcashFields.style.display = 'block';
            } else {
                gcashFields.style.display = 'none';
                document.getElementById('gcash-error-message').style.display = 'none'; // Hide error message when switching payment method
            }
        });

        document.getElementById('place_order').addEventListener('click', function() {
            var fullname = document.getElementById('fullname').value;
            var address = document.getElementById('address').value;
            var zip_code = document.getElementById('zip_code').value;
            var phone_num = document.getElementById('phone_num').value;
            var payment = document.getElementById('payment').value;
            var gcash_reference = document.getElementById('gcash_reference').value;
            var gcash_amount = document.getElementById('gcash_amount').value;

            if (fullname === '' || address === '' || zip_code === '' || phone_num === '') {
                document.getElementById('error-message').style.display = 'block';
                document.getElementById('error-message').innerHTML = 'Please fill out all fields.';
                return false;
            }

            if (payment === 'gcash') {
                if (gcash_reference === '' || gcash_amount === '') {
                    document.getElementById('error-message').style.display = 'block';
                    document.getElementById('error-message').innerHTML = 'Please fill out all GCash fields.';
                    return false;
                }
                if ((gcash_amount) != priceTotal) {
                    document.getElementById('gcash-error-message').style.display = 'block';
                    document.getElementById('gcash-error-message').innerHTML = 'Please pay the exact amount: ₱' + priceTotal;
                    return false;
                }
            }

            document.getElementById('order-form').submit();
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybBogGzA+NmPBautJdMwWvOVkAGNV6K07ep7F0XqKibNRQ64+" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-qZY6BTFvSNDA1dXYgCF5D6cccy/NY/z9+azlY6Q67FYSm+5m1W9KKb6vDXkHk9tm" crossorigin="anonymous"></script>
</body>
</html>
