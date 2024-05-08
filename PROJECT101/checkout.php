<?php

session_start();
include("connection.php");
include("function.php");

$user_id = $_SESSION['user_id'];
$_SESSION;

if (isset($_POST['place_order'])) {

    $fullname = $_POST['fullname'];
    $address = $_POST['address'];
    $zip_code = $_POST['zip_code'];
    $number = $_POST['number'];
    $payment = $_POST['payment'];
   
    $select_cart = mysqli_query($con, "SELECT * FROM `cart` WHERE user_id = '" . $_SESSION['user_id'] . "'");
    
                    $price_total = 0;
                    $product_name = []; // Initialize $product_name as an empty array

                    if (mysqli_num_rows($select_cart) > 0) {
                        while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                            // Calculate subtotal for each item
                            $product_price = $fetch_cart['price'] * $fetch_cart['quantity'];
                            // Accumulate subtotal to grand total
                            $price_total += $product_price;
                            // Push product names into the $product_name array
                            $product_name[] = $fetch_cart['name'] . ' (' . $fetch_cart['quantity'] . ')';
                        }
                    }


    $total_product = implode(', ', $product_name);
    $order_id = random_num(15);
    $detail_query = mysqli_query($con, "INSERT INTO `order`(`order_id`, `fullname`, `address`, `zip_code`, `number`, `payment`, `total_product`, `price_total`) 
    VALUES('$order_id', '$fullname', '$address', '$zip_code', '$number', '$payment', '$total_product', '$price_total')") or die('query failed');

    if ($select_cart && $detail_query) {
        echo "
       <div class='order-message-container'>
       <div class='message-container'>
          <h3>thank you for shopping!</h3>
          <div class='order-detail'>
             <span>" . $total_product . "</span>
             <span class='total'> total : $" . $price_total . "  </span>
          </div>
          <div class='customer-details'>
             <p> your name : <span>" . $fullname . "</span> </p>
             <p> your number : <span>" . $number . "</span> </p>
             <p> your address : <span>" . $address .  " - " . $zip_code . "</span> </p>
             <p> your payment mode : <span>" . $payment . "</span> </p>
             <p>(*pay when product arrives*)</p>
          </div>
             <a href='product.php' class='btn'>continue shopping</a>
          </div>
       </div>
       ";
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
    <?php //require_once('include/nav.php'); ?>
    <div class="container">
        <header class="header" style="margin-bottom: 8%;">
        </header>
        <main class="content">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="mb-3">Order Summary</h3>

                    <?php
                    $cart_query = mysqli_query($con, "SELECT * FROM `cart` WHERE user_id = '" . $_SESSION['user_id'] . "'");
                    $price_total = 0;
                    if (mysqli_num_rows($cart_query) > 0) {
                        while ($fetch_cart = mysqli_fetch_assoc($cart_query)) {

                            $product_name[] = $fetch_cart['name'] . ' (' . $fetch_cart['quantity'] . ')';
                            $product_price = $fetch_cart['price'] * $fetch_cart['quantity'];
                            $price_total += $product_price;
                    ?>

                            <div class="card mb-1">
                                <div class="card-body d-flex flex-wrap ">
                                    <div class="item-image flex-shrink-0 me-5"> <img src="./images/<?php echo $fetch_cart['image']; ?>" width="100" height="100" alt="product">
                                    </div>
                                    <div class="item-desc flex-grow-1 ">
                                        <p class="item-name mb-1">Name: <?php echo $fetch_cart['name']; ?></p>
                                        <p class="item-qty mb-1">Quantity: <?php echo $fetch_cart['quantity']; ?></p>
                                        <?php if (!empty($fetch_cart['size'])) { ?> <p class="item-size">Size: <?php echo $fetch_cart['size']; ?></p>
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
                            <input type="zip=code" class="form-control" id="zip-code" name="zip_code" placeholder="" required> 
                            <label for="zip=code" class="form-label ms-2">Zip Code</label>
                        </div>

                        <div class="form-floating col-md-6">
                            <input type="tel" class="form-control" id="phone" name="number" placeholder="123-456-7890" required>
                             <label for="phone" class="form-label ms-2">Phone Number</label>
                        </div>
                        <div class="col-12">
                            <label for="paymentDetails" class="form-label">Payment Details</label>
                            <select id="paymentDetails" class="form-select" name="payment" required>
                                <option value="">Select Payment Method</option>
                                <option value="cod">Cash On Delivery</option>
                                <option value="gcash">Gcash</option>
                            </select>
                        </div>
                        <div class="d-grid gap-2 col-12 mt-3">
                            <input type="submit" class="btn btn-primary" name="place_order">Place Order</input>
                        </div>
                    </form>
                    </div>
                </div>
        </main>
    </div>

    <script src="bootstrap-5.3.2-dist/js/bootstrap.bundle.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    
</body>

</html>