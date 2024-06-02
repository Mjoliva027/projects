<?php
session_start();
include("connection.php");
include("function.php");

// Check if user is logged in and retrieve user_id from session
$is_logged_in = isset($_SESSION['user_id']);
if (!$is_logged_in) {
    echo "User is not logged in. Please log in to add items to the cart.";
}

$user_id = $_SESSION['user_id'] ?? null;

// Ensure product_id is set before using it
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
} else {
    echo "Invalid product ID.";
    exit();
}

if (isset($_POST['add_to_cart'])) {
    $prod_name = mysqli_real_escape_string($con, $_POST['prod_name']);
    $prod_price = mysqli_real_escape_string($con, $_POST['prod_price']);
    $size_name = mysqli_real_escape_string($con, $_POST['size_name']);
    $color_name = mysqli_real_escape_string($con, $_POST['color_name']);
    $quantity = mysqli_real_escape_string($con, $_POST['Quantity']);
    $user_id = $_SESSION['user_id'] ?? null;

    // Get color_id based on color_name and product_id
    $color_query = "SELECT color_id FROM color WHERE color_name = '$color_name' AND product_id = $product_id";
    $color_result = mysqli_query($con, $color_query);
    if ($color_result && mysqli_num_rows($color_result) > 0) {
        $color_row = mysqli_fetch_assoc($color_result);
        $color_id = $color_row['color_id'];

        // Check if the product exists in the products table
        $product_query = "SELECT product_id FROM products WHERE product_id = $product_id";
        $product_result = mysqli_query($con, $product_query);
        if (mysqli_num_rows($product_result) > 0) {
            // Product exists, proceed with insertion into the cart
            $insert_product = mysqli_query($con, "INSERT INTO `cart` (user_id, product_id, color_id, name, price, image, size, quantity) VALUES ('$user_id', '$product_id', '$color_id', '$prod_name', '$prod_price', '$color_name', '$size_name', '$quantity')");
            if ($insert_product) {
                echo '<div class="alert alert-success alert-dismissible fade show position-fixed top-50 start-50 translate-middle" role="alert" style="z-index: 9999;">
                    <h4 class="text-center"> Successfully Added to Cart </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            } else {
                // Error inserting into the cart
                echo 'Error: ' . mysqli_error($con);
            }
        } else {
            // Product does not exist
            echo "Product does not exist.";
        }
    } else {
        echo "Invalid color selected.";
    }
}

// Fetch all images for the specified product_id
$query_images = "SELECT img_name FROM view_prod WHERE product_id = $product_id";
$result_images = mysqli_query($con, $query_images);

$swiper2_images = [];
$swiper_images = [];

if (mysqli_num_rows($result_images) > 0) {
    while ($row = mysqli_fetch_assoc($result_images)) {
        $img_name = $row['img_name'];
        $swiper2_images[] = $img_name;
        $swiper_images[] = $img_name;
    }
} else {
    echo "No images found for this product.";
}

// Fetch product description
$query_description = "SELECT prod_des FROM products WHERE product_id = $product_id";
$result_description = mysqli_query($con, $query_description);

if ($result_description && $row = mysqli_fetch_assoc($result_description)) {
    $prod_description = $row['prod_des'];
} else {
    $prod_description = "No Product Description.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap-5.3.2-dist/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://kit.fontawesome.com/c8fb92272e.js" crossorigin="anonymous"></script>
    <title>Shoe Haven</title>
    <style>
        html, body {
            position: relative;
            height: 100%;
        }

        body {
            background: #eee;
            font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
            font-size: 14px;
            color: white;
            margin: 0;
            padding: 0;
        }

        .swiper-slide {
            text-align: center;
            font-size: 18px;
            background: #fff;
        }

        .swiper-slide img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        body {
            background: white;
            color: #000;
        }

        .swiper {
            width: 50%;
            height: 100px;
            margin-left: auto;
            margin-right: auto;
        }

        .swiper-slide {
            background-size: cover;
            background-position: center;
        }

        .mySwiper2 {
            padding-top: 15%;
            height: 50%;
            width: 70%;
        }

        .mySwiper {
            height: 50%;
            box-sizing: border-box;
            padding: 5px 0;
        }

        .mySwiper .swiper-slide {
            width: 20%;
            height: 100%;
            opacity: 0.8;
        }

        .swiper-button-next, .swiper-button-prev {
            color: blue;
        }

        .mySwiper .swiper-slide-thumb-active {
            opacity: 5;
        }

        .swiper-slide img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .size-button {
            padding: 8px 12px;
            font-size: 16px;
            cursor: pointer;
        }

        .size-option.selected .size-button {
            border: 2px solid blue;
        }

        .color-option {
            display: inline-block;
            margin-right: 10px;
            text-align: center;
        }

        .color-option img {
            width: 70px;
            height: 80px;
            border-radius: 10%;
            cursor: pointer;
        }

        .color-option.out-of-stock img {
            opacity: 0.5;
        }

        .color-option span {
            display: block;
            margin-top: 5px;
            color: black;
        }

        .color-option.out-of-stock span {
            color: red;
        }
    </style>
</head>
<body>
    <?php
    if (isset($message)) {
        foreach ($message as $message) {
            echo '<div class="message"><span>' . $message . '</span> <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i> </div>';
        }
    }
    ?>

    <?php require_once('include/nav.php'); ?>

    <!-- IMAGES OF PRODUCTS -->
    <div class="row align-items-start">
        <div class="col col-md-6">

            <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff" class="swiper mySwiper2">
                <div class="swiper-wrapper" style="max-height: 500px;">
                    <?php
                    // Loop through $swiper2_images array to generate swiper slides
                    foreach ($swiper2_images as $img) {
                    ?>
                        <div class="swiper-slide">
                            <img src="./images/<?php echo $img; ?>" />
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>

            <div thumbsSlider="" class="swiper mySwiper">
                <div class="swiper-wrapper">
                    <?php
                    // Loop through $swiper_images array to generate swiper slides
                    foreach ($swiper_images as $img) {
                    ?>
                        <div class="swiper-slide">
                            <img src="./images/<?php echo $img; ?>" />
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>

            <div class="mt-5" style="width: 206%; height: 10px; background-color:#Bcbfbf;   "></div>

            <div class="mt-5 pt-5">
                <h4 class="ms-5">Product Description</h4>
            </div>
            <p class="ms-5"><?php echo $prod_description; ?></p>

        </div>

        <div class="col-md-6" style="padding-top: 7%;">
            <form action="" method="POST">
                <?php
                $query = "SELECT prod_name, prod_price FROM products WHERE product_id = $product_id";
                $result = mysqli_query($con, $query);
                if ($row = mysqli_fetch_assoc($result)) {
                ?>
                    <h2><?php echo $row['prod_name']; ?></h2>
                    <h5 class="pt-3"><?php echo $row['prod_price']; ?></h5>

                    <input type="hidden" name="prod_name" value="<?php echo htmlspecialchars($row['prod_name']); ?>">
                    <input type="hidden" name="prod_price" value="<?php echo htmlspecialchars($row['prod_price']); ?>">
                <?php
                }
                ?>

                <div class="pt-3">
                    <h6 class="text-secondary">Color</h6>
                    <?php
                    $query = "SELECT color_name, stock FROM color WHERE product_id = $product_id";
                    $result = mysqli_query($con, $query);
                    while ($row = mysqli_fetch_assoc($result)) {
                        $color_name = $row['color_name'];
                        $stock = $row['stock'];
                        $out_of_stock_class = $stock <= 0 ? 'out-of-stock' : '';
                    ?>
                        <div class="color-option <?php echo $out_of_stock_class; ?>">
                            <img src="./images/<?php echo $color_name; ?>" alt="<?php echo $color_name; ?>" class="color-image">
                            <span>Stock: <?php echo $stock; ?></span>
                        </div>
                    <?php
                    }
                    ?>
                </div>

                <div class="mt-3">
                    <h6 class="text-secondary">Size</h6>

                    <!-- Display size options here -->
                    <div class="size-option d-inline-flex flex-wrap justify-content-start align-items-start" style="gap: 0; margin-left:3%;">
                        <?php

                        // Query to fetch size names from the database based on product_id
                        $query = "SELECT size_name FROM `size` WHERE product_id = $product_id";
                        $result = mysqli_query($con, $query);

                        // Check if query was successful
                        if ($result && mysqli_num_rows($result) > 0) {
                            // Loop through fetched rows to display size buttons
                            while ($row = mysqli_fetch_assoc($result)) {
                                $size_name = $row['size_name'];
                        ?>
                                <div class="size-option mb-2" style="flex-basis: 20%; max-width: 20%; margin-left:-2%;">
                                    <button type="button" class="btn btn-outline-secondary size-button " data-size="<?php echo htmlspecialchars($size_name); ?>"><?php echo htmlspecialchars($size_name); ?></button>
                                </div>

                        <?php
                            }
                        } else {
                            // No sizes found for the product
                            echo "No size options available for this product.";
                        }
                        ?>
                    </div>
                </div>

                <!-- Quantity button -->
                <h6 class="text-secondary mt-2">Quantity</h6>
                <div class="input-group mt-3">
                    <div class="input-group-prepend">
                        <button class="btn btn-outline-secondary" type="button" id="decrease">-</button>
                    </div>

                    <input type="text" class="form-control quantity-input text-center" name="Quantity" value=1 aria-describedby="decrease increase" style="max-width: 80px;">

                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" id="increase">+</button>
                    </div>
                </div>

                <div class="mt-4">
                    <input type="hidden" name="color_name">
                    <input type="hidden" name="size_name" id="selected-size" value="">
                    <input type="submit" value="Add to Cart" name="add_to_cart" class="btn btn-warning me-3" id="add-to-cart-button">
                    <button type="button" class="btn btn-success" id="buy-now">Buy now</button>
                </div>
            </form>
        </div>
    </div>


    <?php require_once('include/footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="bootstrap-5.3.2-dist/js/bootstrap.bundle.js"></script>
    <script>
        var swiper = new Swiper(".mySwiper", {
            spaceBetween: 10,
            slidesPerView: 5,
            freeMode: true,
            watchSlidesProgress: true,
        });
        var swiper2 = new Swiper(".mySwiper2", {
            spaceBetween: 10,
            loop: true,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            thumbs: {
                swiper: swiper,
            },
        });

        document.addEventListener('DOMContentLoaded', function() {
            const colorImages = document.querySelectorAll('.color-image');
            const sizeButtons = document.querySelectorAll('.size-button');
            const addToCartButton = document.getElementById('add-to-cart-button');
            const buyNowButton = document.getElementById('buy-now');
            const quantityInput = document.querySelector('.quantity-input');
            const decreaseButton = document.getElementById('decrease');
            const increaseButton = document.getElementById('increase');

            function selectColor(selectedImage) {
                colorImages.forEach(image => {
                    image.style.border = 'none';
                });
                selectedImage.style.border = '2px solid blue';
                const colorName = selectedImage.getAttribute('alt');
                document.querySelector('input[name="color_name"]').value = colorName;

                // Check stock
                const stockSpan = selectedImage.nextElementSibling;
                const stockText = stockSpan.innerText;
                const stock = parseInt(stockText.replace('Stock: ', ''), 10);

                if (stock > 0) {
                    addToCartButton.disabled = false;
                    buyNowButton.disabled = false;
                } else {
                    addToCartButton.disabled = true;
                    buyNowButton.disabled = true;
                }
            }

            function selectSize(selectedButton) {
                sizeButtons.forEach(button => {
                    button.style.border = '';
                });
                selectedButton.style.border = '2px solid blue';
                const sizeValue = selectedButton.getAttribute('data-size');
                document.querySelector('#selected-size').value = sizeValue;
            }

            colorImages.forEach(image => {
                image.addEventListener('click', function() {
                    selectColor(this);
                });
            });

            sizeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    selectSize(this);
                });
            });

            decreaseButton.addEventListener('click', function() {
                let quantity = parseInt(quantityInput.value, 10);
                if (quantity > 1) {
                    quantityInput.value = quantity - 1;
                }
            });

            increaseButton.addEventListener('click', function() {
                let quantity = parseInt(quantityInput.value, 10);
                quantityInput.value = quantity + 1;
            });
        });
    </script>
</body>
</html>

