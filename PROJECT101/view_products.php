<?php
session_start();
include("connection.php");
include("function.php");

$user_data = check_login($con);

$_SESSION;

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
</head>

<body>

   <?php require_once('include/nav.php');?>
  <!--IMAGES OF PRODUCTS-->
<div class="row align-items-start">
    <div class="col-md-6">
        <?php
        if (isset($_GET['product_id'])) {
            $product_id = $_GET['product_id'];

            // Fetch all images for the specified product_id
            $query = "SELECT img_name FROM view_prod WHERE product_id = $product_id";
            $result = mysqli_query($con, $query);

            if (mysqli_num_rows($result) > 0) {
                // Initialize arrays to store image URLs
                $swiper2_images = [];
                $swiper_images = [];

                // Iterate over fetched rows to populate image arrays
                while ($row = mysqli_fetch_assoc($result)) {
                    $img_name = $row['img_name'];

                    // Append image URL to respective arrays
                    $swiper2_images[] = $img_name;
                    $swiper_images[] = $img_name;
                }

                ?>
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
            <?php
            } else {
                echo "No images found for this product.";
            }
        } else {
            echo "Invalid product ID.";
        }
        ?>
    </div>

    <div class="col-md-6" style="padding-top: 7%;">
    <?php
            $query = "SELECT prod_name,prod_price FROM products WHERE product_id = $product_id";
            $result = mysqli_query($con, $query);
                if ($row = mysqli_fetch_assoc($result)) {
                  
            ?>
            <h2><?php echo $row['prod_name']; ?></h2>
            <h5 class="pt-3"><?php echo $row['prod_price']?></h5>

            <div class="pt-5">
                <h6 class="text-secondary">Color</h6>
                <!-- Display color variations here if applicable -->
            </div>
        <?php
        }
    
        ?>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
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

<script src="bootstrap-5.3.2-dist/js/bootstrap.bundle.js"></script>


</script>
</body>

</html>