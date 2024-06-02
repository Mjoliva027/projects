<?php
session_start();
include("connection.php");
include("function.php");

$user_id = $_SESSION['user_id'];

if (isset($_POST['place_order'])) {
    $fullname = mysqli_real_escape_string($con, $_POST['fullname']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $zip_code = mysqli_real_escape_string($con, $_POST['zip_code']);
    $phone_num = mysqli_real_escape_string($con, $_POST['phone_num']);
    $payment = mysqli_real_escape_string($con, $_POST['payment']);
    $gcash_reference = isset($_POST['gcash_reference']) ? mysqli_real_escape_string($con, $_POST['gcash_reference']) : null;
    $gcash_account_name = isset($_POST['gcash_account_name']) ? mysqli_real_escape_string($con, $_POST['gcash_account_name']) : null;
    $gcash_account_number = isset($_POST['gcash_account_number']) ? mysqli_real_escape_string($con, $_POST['gcash_account_number']) : null;
    $gcash_amount = isset($_POST['gcash_amount']) ? mysqli_real_escape_string($con, $_POST['gcash_amount']) : null;

    // Debugging: Print form data
    echo "Form Data:<br>";
    echo "Fullname: $fullname<br>";
    echo "Address: $address<br>";
    echo "Zip Code: $zip_code<br>";
    echo "Phone Number: $phone_num<br>";
    echo "Payment Method: $payment<br>";
    echo "GCash Reference: $gcash_reference<br>";
    echo "GCash Account Name: $gcash_account_name<br>";
    echo "GCash Account Number: $gcash_account_number<br>";
    echo "GCash Amount: $gcash_amount<br>";

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

    if ($payment === 'gcash' && empty($gcash_reference)) {
        $_SESSION['error'] = "Please provide the GCash reference number to complete your order.";
        header("Location: place_order.php");
        exit;
    } else {
        $detail_query = mysqli_query($con, "INSERT INTO `orders`(`order_id`, `fullname`, `address`, `zip_code`, `phone_num`, `payment`, `prod_name`, `size`, `quantity`, `price_total`, `user_id`, `gcash_reference`,`acc_name`,`acc_number`,`amount_paid`) 
        VALUES('$order_id', '$fullname', '$address', '$zip_code', '$phone_num', '$payment', '$prod_name', '$size', '$quantity', '$price_total', '$user_id', '$gcash_reference', '$gcash_account_name', '$gcash_account_number', '$gcash_amount')") or die('query failed: ' . mysqli_error($con));

        if ($detail_query) {
            // Debugging: Verify data inserted
            echo "Order placed successfully. Order ID: $order_id<br>";

            // Delete items from cart
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
                    $cart_query = mysqli_query($con, "SELECT * FROM `cart` WHERE user_id = '" . $user_id . "'");
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
                    <form action="" method="post">
                        <div class="form-floating mb-3 col-md-12">
                            <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Enter Fullname" required>
                            <label for="fullname" class="ms-2">Enter Fullname</label>
                        </div>
                        <div class="form-floating col-md-12 mb-3">
                            <input type="text" class="form-control" id="address" name="address" placeholder="Enter Address" required>
                            <label for="address" class="ms-2">Enter Address</label>
                        </div>
                        <div class="form-floating col-md-12 mb-3">
                            <input type="number" class="form-control" id="zip_code" name="zip_code" placeholder="Enter Zip Code" required>
                            <label for="zip_code" class="ms-2">Enter Zip Code</label>
                        </div>

                        <div class="form-floating col-md-12 mb-3">
                            <input type="number" class="form-control" id="phone_num" name="phone_num" placeholder="Enter Phone Number" required>
                            <label for="phone_num" class="ms-2">Enter Phone Number</label>
                        </div>

                        <div class="form-floating col-md-12 mb-3">
                            <select name="payment" id="payment" class="form-select" onchange="toggleGcashReference(this.value)" required>
                                <option value="">Select Payment Method</option>
                                <option value="cod">Cash on Delivery</option>
                                <option value="gcash">GCash</option>
                            </select>
                            <label for="payment" class="ms-2">Select Payment Method</label>
                        </div>

                        <div class=" col-md-12 mt-3" id="gcashReferenceDiv" style="display: none;">

                            <div class="form-floating col-md-12 mb-3">
                            <input type="text" class="form-control mb-2" id="gcashReference" name="gcash_reference" placeholder="GCash Reference Number">
                            <label for="gcashReference" class="ms-2">GCash Reference Number</label>
                            </div>

                            <div class="form-floating col-md-12 mb-3">  
                            <input type="text" class="form-control mb-2" id="gcashAccountName" name="gcash_account_name" placeholder="GCash Account Name">
                            <label for="gcashAccountName" class="ms-2">GCash Account Name</label>
                            </div>

                            <div class="form-floating col-md-12 mb-3">
                            <input type="number" class="form-control mb-2" id="gcashAccountNumber" name="gcash_account_number" placeholder="GCash Account Number">
                            <label for="gcashAccountNumber" class="ms-2">GCash Account Number</label>
                            </div>

                            <div class="form-floating col-md-12 mb-3">
                            <input type="number" class="form-control" id="gcashAmount" name="gcash_amount" placeholder="Amount Paid">
                            <label for="gcashAmount" class="ms-2">Amount Paid</label>
                            </div>
                            

                            <img src="./images/QRgcash.jpg" alt="GCash QR Code" width="150" height="150">
                        </div>

                        <div class="d-grid mt-3">
                            <button type="submit" name="place_order" class="btn btn-primary btn-block">Place Order</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
        <footer class="footer mt-4 mb-2"></footer>
    </div>

    <script>
        function toggleGcashReference(paymentMethod) {
            var gcashReferenceDiv = document.getElementById('gcashReferenceDiv');
            var gcashReferenceInput = document.getElementById('gcashReference');
            var gcashAccountNameInput = document.getElementById('gcashAccountName');
            var gcashAccountNumberInput = document.getElementById('gcashAccountNumber');
            var gcashAmountInput = document.getElementById('gcashAmount');

            if (paymentMethod === 'gcash') {
                gcashReferenceDiv.style.display = 'block';
                gcashReferenceInput.setAttribute('required', 'required');
                gcashAccountNameInput.setAttribute('required', 'required');
                gcashAccountNumberInput.setAttribute('required', 'required');
                gcashAmountInput.setAttribute('required', 'required');
            } else {
                gcashReferenceDiv.style.display = 'none';
                gcashReferenceInput.removeAttribute('required');
                gcashAccountNameInput.removeAttribute('required');
                gcashAccountNumberInput.removeAttribute('required');
                gcashAmountInput.removeAttribute('required');
            }
        }
    </script>
</body>
</html>
