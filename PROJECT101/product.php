<?php
session_start();
include("connection.php");
include("function.php");



$_SESSION;

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap-5.3.2-dist/css/bootstrap.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://kit.fontawesome.com/c8fb92272e.js" crossorigin="anonymous"></script>
    <title>Shoe Haven</title>

    <style>
       
        .swiper-slide video {
            max-width: 90%;
            max-height: 80%;
        }
    </style>
</head>

<body>

    <?php require_once('include/nav.php'); ?>
    <!-- Swiper -->
    <div class="swiper mySwiper">
        <div class="swiper-wrapper">
        <div class="swiper-slide">
                <video src="./video/Nike ads Motion Graphics.mp4" autoplay loop muted></video>
            </div>
            <div class="swiper-slide">
                <img src="https://staticg.sportskeeda.com/editor/2022/04/cb16b-16512353836768-1920.jpg" alt="...">
            </div>
            <div class="swiper-slide">
                <img src="https://media.gq.com/photos/63eba1b2275d2fef78a425c2/master/pass/nike-running-shoes-streakfly-invincible.jpg" alt="">
            </div>
            <div class="swiper-slide">
                <img src="https://cdn.thewirecutter.com/wp-content/media/2021/10/running-shoes-2048px-3128-2x1-1.jpg?auto=webp&quality=75&crop=2:1&width=1024.jpg" alt="">
            </div>
            <div class="swiper-slide">Slide 5</div>
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
    </div>

    <h4 class="fw-semibold ps-5 mt-5 mb-5">All Products</h4>
    <form action="" method="post">
        <div class="row row-cols-2 row-cols-md-6 g-4 ps-4">

            <?php
            $query = "SELECT * FROM `products` ORDER BY RAND()";
            $result = mysqli_query($con, $query);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $product_id = $row['product_id'];
                    $prod_name = $row['prod_name'];
                    $prod_price = $row['prod_price'];
                    $prod_image = $row['prod_image'];

            ?>
                    <div class="col">
                        <a href="view_products.php?product_id=<?php echo $product_id; ?>" class="text-decoration-none text-black">
                            <div class="card mh-100 shadow-sm">
                                <div style="max-height: 200px; overflow: hidden;">
                                    <img src="./images/<?php echo $prod_image; ?>" class="card-img-top img-fluid " alt="<?php echo $prod_name; ?>">
                                </div>
                                <div class="card-body">
                                    <small class="card-title" style="font-size: 15px;"><?php echo $prod_name; ?></small>
                                    <p class="card-text fw-semibold text-muted">₱<?php echo $prod_price; ?></p>
                                </div>
                        </a>
                    </div>
        </div>

<?php
                };
            } else {
                echo "No products found.";
            }

?>

    </form>
    </div>
    <?php require_once('include/footer.php'); ?>
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="bootstrap-5.3.2-dist/js/bootstrap.bundle.js"></script>

    <!-- Initialize Swiper -->
    <script>
        var swiper = new Swiper(".mySwiper", {
            spaceBetween: 30,
            centeredSlides: true,
           
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });
    </script>


    <script src="bootstrap-5.3.2-dist/js/bootstrap.bundle.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
</body>

</html>