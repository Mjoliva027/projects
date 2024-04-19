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
  <title>Shoe Haven</title>
  <link rel="stylesheet" href="bootstrap-5.3.2-dist/css/bootstrap.css">

  <link rel="stylesheet" href="style.css">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
</head>

<body id="index">

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top ">
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
          <ul class="navbar-nav justify-content-center align-items-center flex-grow-1 pe-3">
            <li class="nav-item mx-2">
              <a class="nav-link" aria-current="page" href="#home">Home</a>
            </li>
            <li class="nav-item mx-2">
              <a class="nav-link" href="#about">About</a>
            </li>
            <li class="nav-item mx-2">
              <a class="nav-link" href="#contact">Contact Us</a>
            </li>
          </ul>
          <div class="buttons mt-2 pe-2">
            <a href="login.php"><button type="button" class="btn btn-outline-primary">Login</button></a>
          </div>
          <div class="buttons mt-2">
            <a href="signup.php"><button type="button" class="btn btn-outline-primary">Signup</button></a>
          </div>
        </div>
      </div>
    </div>
  </nav>


  <body>
    <!-- Swiper -->
    <div class="swiper mySwiper">
      <div class="swiper-wrapper">
        <div class="swiper-slide"><img src="https://cdn.thewirecutter.com/wp-content/media/2021/10/running-shoes-2048px-3128-2x1-1.jpg?auto=webp&quality=75&crop=2:1&width=1024.jpg" alt=""></div>
        <div class="swiper-slide"><img src="https://staticg.sportskeeda.com/editor/2022/04/cb16b-16512353836768-1920.jpg" alt="..."></div>
        <div class="swiper-slide"><img src="https://media.gq.com/photos/63eba1b2275d2fef78a425c2/master/pass/nike-running-shoes-streakfly-invincible.jpg" alt=""></div>
        <div class="swiper-slide">Slide 4</div>
        <div class="swiper-slide">Slide 5</div>
        <div class="swiper-slide">Slide 6</div>
        <div class="swiper-slide">Slide 7</div>
        <div class="swiper-slide">Slide 8</div>
        <div class="swiper-slide">Slide 9</div> 
      </div>
      <div class="swiper-button-next"></div>
      <div class="swiper-button-prev"></div>
      <div class="swiper-pagination"></div>
    </div>

      <h4 class="fw-semibold ps-5">Latest Drop</h4>
    <div class="row row-cols-2   row-cols-md-6 g-4 ps-4">
      <div class="col">
        <div class="card mh-100">
          <img src="https://static.nike.com/a/images/t_PDP_1280_v1/f_auto,q_auto:eco/99486859-0ff3-46b4-949b-2d16af2ad421/custom-nike-dunk-high-by-you-shoes.png" class="card-img-top mh-100" alt="...">
          <div class="card-body">
            <h6 class="card-title">Nike Dunk High</h6>
            <p class="card-text fw-semibold">₱8,595.00 PHP</p>
          </div>
        </div>
      </div>

      <div class="col">
        <div class="card mh-100">
          <img src="https://static.nike.com/a/images/q_auto:eco/t_product_v1/f_auto/dpr_1.0/h_411,c_limit/4f37fca8-6bce-43e7-ad07-f57ae3c13142/air-force-1-07-shoes-WrLlWX.png" class="card-img-top mh-100"  alt="...">
          <div class="card-body">
            <h6 class="card-title">Nike Air Force 1</h6>
            <p class="card-text fw-semibold">₱5,495.00 PHP</p>
          </div>
        </div>
      </div>

      <div class="col">
        <div class="card mh-100">
          <img src="https://assets.adidas.com/images/w_600,f_auto,q_auto/f2d9229b65c248488c78af3b00851dab_9366/Runfalcon_3.0_Shoes_White_HP7557_01_standard.jpg" class="card-img-top" alt="...">
          <div class="card-body">
            <h6 class="card-title">Addidas Runfalcon3.0</h6>
            <p class="card-text fw-semibold">₱3,500.00 PHP</p>
          </div>
        </div>
      </div>
      
      <div class="col">
        <div class="card mh-100">
          <img src="https://assets.adidas.com/images/h_840,f_auto,q_auto,fl_lossy,c_fill,g_auto/71a00703e8c14c76aa8471445a9eaf40_9366/Ultrabounce_Shoes_Blue_HP5783_HM1.jpg" class="card-img-top" alt="...">
          <div class="card-body">
            <h6 class="card-title">Ultrabounce</h6>
            <p class="card-text fw-semibold">₱4,500.00 PHP</p>
          </div>
        </div>
      </div>

      <div class="col">
        <div class="card mh-100">
          <img src="https://assets.adidas.com/images/w_600,f_auto,q_auto/f2d9229b65c248488c78af3b00851dab_9366/Runfalcon_3.0_Shoes_White_HP7557_01_standard.jpg" class="card-img-top" alt="...">
          <div class="card-body">
            <h6 class="card-title">Addidas Runfalcon3.0</h6>
            <p class="card-text fw-semibold">₱3,500.00 PHP</p>
          </div>
        </div>
      </div>
      
      <div class="col">
        <div class="card mh-100">
          <img src="https://assets.adidas.com/images/h_840,f_auto,q_auto,fl_lossy,c_fill,g_auto/71a00703e8c14c76aa8471445a9eaf40_9366/Ultrabounce_Shoes_Blue_HP5783_HM1.jpg" class="card-img-top" alt="...">
          <div class="card-body">
            <h6 class="card-title">Ultrabounce</h6>
            <p class="card-text fw-semibold">₱4,500.00 PHP</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="bootstrap-5.3.2-dist/js/bootstrap.bundle.js"></script>

    <!-- Initialize Swiper -->
    <script>
      var swiper = new Swiper(".mySwiper", {
        spaceBetween: 30,
        centeredSlides: true,
        autoplay: {
          delay: 2500,
          disableOnInteraction: false,
        },
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