    <?php
    session_start();
    include("connection.php");
    include("function.php");

    // Check if user is logged in and retrieve user_id from session
    if (!isset($_SESSION['user_id'])) {
        // Handle the case where the user is not logged in
        echo "User is not logged in. Please log in to add items to the cart.";
        exit();
    }



    if (isset($_POST['add_to_cart'])) {

        $prod_name = $_POST['prod_name'];
        $prod_price = $_POST['prod_price'];
        $size_name = $_POST['size_name'];
        $color_name = $_POST['color_name'];
        $quantity = $_POST['Quantity'];
        // Retrieve user_id from session
        $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

        $insert_product = mysqli_query($con, "INSERT INTO `cart`(user_id,name, price, image, size, quantity) VALUES('$user_id','$prod_name', '$prod_price', '$color_name', '$size_name', '$quantity')");
        if ($insert_product) {
            echo '<div class="alert alert-success alert-dismissible fade show position-fixed top-50 start-50 translate-middle" role="alert" style="z-index: 9999;">
                <h4 class="text-center"> Successfully Added to Cart </h4>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        } else {
            $message[] = 'Error: ' . mysqli_error($con);
        }
    }


    // Check if product_id is set
    if (isset($_GET['product_id'])) {
        $product_id = $_GET['product_id'];

        // Fetch all images for the specified product_id
        $query_images = "SELECT img_name FROM view_prod WHERE product_id = $product_id";
        $result_images = mysqli_query($con, $query_images);

        // Initialize arrays to store image URLs
        $swiper2_images = [];
        $swiper_images = [];

        if (mysqli_num_rows($result_images) > 0) {
            // Iterate over fetched rows to populate image arrays
            while ($row = mysqli_fetch_assoc($result_images)) {
                $img_name = $row['img_name'];

                // Append image URL to respective arrays
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
    } else {
        echo "Invalid product ID.";
        exit(); // Stop executing the script if product ID is not set
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
            html,
            body {
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
                height: 100%;
                box-sizing: border-box;
                padding: 5px 0;
            }

            .mySwiper .swiper-slide {
                width: 30%;
                height: 100%;
                opacity: 0.8;
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
        </style>
        <style>
            .size-button {
                padding: 8px 12px;
                font-size: 16px;
                cursor: pointer;
            }

            .size-option.selected .size-button {
                border: 2px solid blue;
                /* Blue border for selected size */
            }
        </style>


    </head>

    <body>

        <?php

        if (isset($message)) {
            foreach ($message as $message) {
                echo '<div class="message"><span>' . $message . '</span> <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i> </div>';
            };
        };

        ?>
        <?php require_once('include/nav.php'); ?>

        <!--IMAGES OF PRODUCTS-->
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


                <div class="mt-5" style="width: 206%; height: 10px; background-color:#Bcbfbf;"></div>

                <div class="mt-5">
                    <h4 class="ms-5">Product Description</h4>
                </div>
                <p class="ms-5"><?php echo $row['prod_des']; ?></p>


            </div>



            <div class="col-md-6" style="padding-top: 7%;">



                <form action="" method="POST">

                    <!---PRODUCT NAME--->
                    <?php
                    $query = "SELECT prod_name, prod_price FROM products WHERE product_id = $product_id";
                    $result = mysqli_query($con, $query);
                    if ($row = mysqli_fetch_assoc($result)) {
                    ?>
                        <h2><?php echo $row['prod_name']; ?></h2>
                        <h5 class="pt-3"><?php echo $row['prod_price'] ?></h5>

                        <input type="hidden" name="prod_name" value="<?php echo htmlspecialchars($row['prod_name']); ?>">
                        <input type="hidden" name="prod_price" value="<?php echo htmlspecialchars($row['prod_price']); ?>">
                    <?php
                    }
                    ?>

                    <div class="pt-5">
                        <h6 class="text-secondary">Color</h6>

                        <?php
                        $query = "SELECT color_name FROM color WHERE product_id = $product_id";
                        $result = mysqli_query($con, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                            $color_name = isset($_POST['color_name']) ? $_POST['color_name'] : '';
                        ?>
                            <div class="color-option" style="display: inline-block; margin-right: 10px;">
                                <img src="./images/<?php echo $row['color_name']; ?>" alt="<?php echo $row['color_name']; ?>" class="color-image" style="width: 70px; height: 70px; border-radius: 10%; cursor: pointer;">

                            </div>
                        <?php
                        }
                        ?>
                    </div>

                    <div class="mt-5">
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
                                    <div class="size-option mb-2" style="flex-basis: 30%; max-width: 20%; margin-left:-5%;">
                                        <button type="button" class="btn btn-outline-secondary size-button" data-size="<?php echo htmlspecialchars($size_name); ?>"><?php echo htmlspecialchars($size_name); ?></button>
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
                    <h6 class="text-secondary">Quantity</h6>
                    <div class="input-group mt-3">
                        <div class="input-group-prepend">
                            <button class="btn btn-outline-secondary" type="button" id="decrease">-</button>
                        </div>

                        <input type="text" class="form-control quantity-input text-center" name="Quantity" value=1 vaaria-describedby="decrease increase" style="max-width: 80px;">

                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" id="increase">+</button>
                        </div>
                    </div>

                    <div class="mt-4">
                        <input type="hidden" name="color_name">
                        <input type="hidden" name="size_name" id="selected-size" value="">
                        <input type="submit" value="Add to Cart" name="add_to_cart" class="btn btn-warning me-3">
                        <button type="button" class="btn btn-success ">Buy now</button>
                    </div>
                </form>
            </div>

        </div>
        <!-- Include jQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <!-- Include Bootstrap JS -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="bootstrap-5.3.2-dist/js/bootstrap.bundle.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

        <script>
            // JavaScript to handle quantity buttons
            document.getElementById('increase').addEventListener('click', function() {
                var input = document.querySelector('.quantity-input');
                input.value = parseInt(input.value) + 1;
            });

            document.getElementById('decrease').addEventListener('click', function() {
                var input = document.querySelector('.quantity-input');
                if (parseInt(input.value) > 1) {
                    input.value = parseInt(input.value) - 1;
                }
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Get all color images and size buttons
                const colorImages = document.querySelectorAll('.color-image');
                const sizeButtons = document.querySelectorAll('.size-button');

                // Function to handle color selection   
                function selectColor(selectedImage) {
                    // Remove border from all color images

                    colorImages.forEach(image => {
                        image.style.border = 'none';
                    });

                    // Add border to the selected color image
                    selectedImage.style.border = '2px solid blue'; // Blue border for selected color

                    // Get the color name from the selected image's alt attribute
                    const colorName = selectedImage.getAttribute('alt');

                    // Set the selected color name to the hidden input field
                    document.querySelector('input[name="color_name"]').value = colorName;
                }

                // Function to handle size selection
                function selectSize(selectedButton) {
                    // Remove border from all size buttons

                    sizeButtons.forEach(button => {
                        button.style.border = '';
                    });

                    // Add border to the selected size button
                    selectedButton.style.border = '2px solid blue'; // Blue border for selected size

                    event.preventDefault()

                    // Get the size value from the selected button
                    var sizeValue = selectedButton.getAttribute('data-size');

                    // Set the selected size value to a hidden input field
                    document.querySelector('#selected-size').value = sizeValue;
                }

                document.getElementById('decrease').addEventListener('click', function() {
                    var input = document.querySelector('.quantity-input');
                    if (parseInt(input.value) > 1) {
                        input.value = parseInt(input.value) - 1;
                        updateQuantity(input.value);
                    }
                });

                // Add click event listener to each color image
                colorImages.forEach(image => {
                    image.addEventListener('click', function() {
                        selectColor(this); // 'this' refers to the clicked color image
                    });
                });

                // Add click event listener to each size button
                sizeButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        selectSize(this); // 'this' refers to the clicked size button
                    });
                });
            });
        </script>


        <!-- Initialize Swiper -->
        <script>
            var swiper = new Swiper(".mySwiper", {
                loop: true,
                spaceBetween: 10,
                slidesPerView: 6,
                freeMode: true,
                watchSlidesProgress: true,
            });
            var swiper2 = new Swiper(".mySwiper2", {
                loop: true,
                spaceBetween: 10,
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
                thumbs: {
                    swiper: swiper,
                },
            });
        </script>







    </body>

    </html>