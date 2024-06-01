<?php
session_start();
include("connection.php");
include("function.php");

// Check if the user is logged in
$user_logged_in = isset($_SESSION['user_id']);

$suggested_sql = "SELECT * FROM products ORDER BY RAND() "; // Change the limit as needed
$suggested_result = $con->query($suggested_sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shoe Haven</title>
  <link rel="stylesheet" href="bootstrap-5.3.2-dist/css/bootstrap.css">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

  <style>
    .card {
      width: 200px;
      margin-bottom: 10px; /* Adjust margin */
    }
    .card-body {
      padding: 5px; /* Adjust padding */
    }
    .card-body p {
      margin-bottom: 0; /* Remove bottom margin of paragraph */
    }
    .swiper-slide video {
      max-width: 90%;
      max-height: 80%;
    }
    .row {
      margin-left: 0; /* Remove left margin */
      margin-right: 0; /* Remove right margin */
    }
    .col {
      padding-left: 5px; /* Adjust padding between columns */
      padding-right: 5px; /* Adjust padding between columns */
    }
  </style>
</head>

<body id="index">

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="#">
        <img src="images/shoe-haven-high-resolution-logo-transparent.png" width="50" height="50" alt="Shoe Haven Logo">
        Shoe Haven
      </a>
      <button class="navbar-toggler shadow-none border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="sidebar offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
        <div class="offcanvas-header text-white border-bottom">
          <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Shoe Haven</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <div class="offcanvas-body">
          <div class="buttons mt-2 pe-2" style="margin-left:85%;">
            <a href="login.php"><button type="button" class="btn btn-outline-primary">Login</button></a>
          </div>
          <div class="buttons mt-2">
            <a href="signup.php"><button type="button" class="btn btn-outline-primary">Signup</button></a>
          </div>
        </div>
      </div>
    </div>
  </nav>

  <div class="swiper mySwiper">
    <div class="swiper-wrapper">
      <div class="swiper-slide"><video src="./video/Nike ads Motion Graphics.mp4" autoplay loop muted></video></div>
      <div class="swiper-slide"><img src="https://staticg.sportskeeda.com/editor/2022/04/cb16b-16512353836768-1920.jpg" alt="..."></div>
      <div class="swiper-slide"><img src="https://media.gq.com/photos/63eba1b2275d2fef78a425c2/master/pass/nike-running-shoes-streakfly-invincible.jpg" alt=""></div>
      <div class="swiper-slide">Slide 4</div>
      <div class="swiper-slide">Slide 5</div>
    </div>
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-pagination"></div>
  </div>

  <h2 class="mt-5 ps-5 mb-5">Suggested Products</h2>
   
  <div class="row row-cols-2 row-cols-md-6 g-4 ps-4">
    <?php while ($row = $suggested_result->fetch_assoc()): ?>
      <?php
      $product_id = $row['product_id'];
      $prod_name = $row['prod_name'];
      $prod_price = $row['prod_price'];
      $prod_image = $row['prod_image'];
      ?>
      <div class="col">
        <a href="<?= $user_logged_in ? "view_products.php?product_id=" . $row['product_id'] : "#" ?>" class="text-decoration-none text-black" onclick="<?= $user_logged_in ? "" : "alert('Please log in to view product details.')" ?>">
          <div class="card mh-100 mb-4 shadow-sm">
            <div style="max-height: 200px; overflow: hidden;">
              <img src="./images/<?php echo $prod_image; ?>" class="card-img-top img-fluid" alt="<?php echo $prod_name; ?>">
            </div>
            <div class="card-body">
              <h5 class="card-title" style="font-size: 15px;"><?= htmlspecialchars($row['prod_name']) ?></h5>
              <p class="text-muted">₱<?= htmlspecialchars($row['prod_price']) ?></p>
            </div>
          </div>
        </a>
      </div>
    <?php endwhile; ?>
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
</body>

</html>
