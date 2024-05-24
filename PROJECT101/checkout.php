<?php
session_start();
include("connection.php");
include("function.php");

$user_id = $_SESSION['user_id'];

if (isset($_POST['place_order'])) {
    $fullname = $_POST['fullname'];
    $address = $_POST['address'];
    $zip_code = $_POST['zip_code'];
    $number = $_POST['number'];
    $payment = $_POST['payment'];
    $gcash_reference = isset($_POST['gcash_reference']) ? $_POST['gcash_reference'] : null;

    $select_cart = mysqli_query($con, "SELECT * FROM `cart` WHERE user_id = '" . $user_id . "'");
    $quantity = 0;
    $price_total = 0;
    $product_names = [];
    $product_size = [];

    if (mysqli_num_rows($select_cart) > 0) {
        while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
            $product_price = $fetch_cart['price'] * $fetch_cart['quantity'];
            $price_total += $product_price;
            $product_names[] = $fetch_cart['name'];
            $product_size[] = $fetch_cart['size'];
            $quantity += $fetch_cart['quantity'];

            $color_id = $fetch_cart['color_id'];
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
        $detail_query = mysqli_query($con, "INSERT INTO `orders`(`order_id`, `fullname`, `address`, `zip_code`, `number`, `payment`, `prod_name`, `size`, `quantity`, `price_total`, `user_id`, `gcash_reference`) 
        VALUES('$order_id', '$fullname', '$address', '$zip_code', '$number', '$payment', '$prod_name','$size', '$quantity', '$price_total', '$user_id', '$gcash_reference')") or die('query failed');

        if ($detail_query) {
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
                        <p>Your number: <span>$number</span></p>
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
                    <h3 class="mb-3">Enter your name and address:</h3>
                    <div class="card card-body d-flex flex-wrap mb-1">
                        <?php if (isset($_SESSION['error'])) { ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                            </div>
                        <?php } ?>
                        <form action="" method="post" class="row gy-3">
                            <div class="form-floating col-md-12">
                                <input type="text" class="form-control" id="fullname" name="fullname" placeholder="" required>
                                <label for="fullname" class="ms-2">Fullname</label>
                            </div>

                            <div class="form-floating col-md-12">
                                <input type="text" class="form-control" id="address" name="address" placeholder="" required>
                                <label for="address" class="form-label ms-2">Address</label>
                            </div>

                            <div class="form-floating col-md-6">
                                <input type="text" class="form-control" id="zip-code" name="zip_code" placeholder="" required>
                                <label for="zip-code" class="form-label ms-2">Zip Code</label>
                            </div>

                            <div class="form-floating col-md-6">
                                <input type="tel" class="form-control" id="phone" name="number" placeholder="123-456-7890" required>
                                <label for="phone" class="form-label ms-2">Phone Number</label>
                            </div>
                            <div class="col-12">
                                <label for="paymentDetails" class="form-label">Payment Details</label>
                                <select id="paymentDetails" class="form-select" name="payment" required onchange="toggleGcashReference(this.value)">
                                    <option value="">Select Payment Method</option>
                                    <option value="cod">Cash on Delivery</option>
                                    <option value="gcash">GCash</option>
                                </select>
                            </div>

                            <div class="form-floating col-md-12 mt-3" id="gcashReferenceDiv" style="display: none;">
                                <input type="text" class="form-control" id="gcashReference" name="gcash_reference" placeholder="GCash Reference Number">
                                <label for="gcashReference" class="ms-2">GCash Reference Number</label>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary w-100" name="place_order">Place Order</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        function toggleGcashReference(paymentMethod) {
            var gcashReferenceDiv = document.getElementById('gcashReferenceDiv');
            var gcashReferenceInput = document.getElementById('gcashReference');
            if (paymentMethod === 'gcash') {
                gcashReferenceDiv.style.display = 'block';
                gcashReferenceInput.setAttribute('required', 'required');
            } else {
                gcashReferenceDiv.style.display = 'none';
                gcashReferenceInput.removeAttribute('required');
            }
        }
    </script>

</body>

</html>
