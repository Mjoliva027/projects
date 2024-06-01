<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap Footer</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" integrity="sha384-0evSXBKJEiFNJhqCsLnT4GxjtBhBcs+BJZbpsV+YE1JEu7EXfFoqwuQo74PVu1D4" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/c8fb92272e.js" crossorigin="anonymous"></script>
    <style>
        .fa-solid {
            letter-spacing: 2px;
            font-size: 12px;
        }
        .text {
            text-decoration: none;
            color: aliceblue;
        }
    </style>
</head>
<body>
<div class="text-body-emphasis" style="margin-top: 10%;">
    <footer class="container-fluid bg-dark text-white py-3">
        <div class="row">
            <div class="col-md-3"  style="margin-left: 20%;">
                <h5>Contact Us</h5>
                <ul class="list-unstyled">
                    <li><i class="fa-solid fa-phone"></i> 09912345678</li>
                    <li><i class="fa-solid fa-envelope"></i> shoehaven@gmail.com</li>
                    <li>
                        <a class="text" href="" data-bs-toggle="modal" data-bs-target="#about">About Us</a>
                        <!-- Modal -->
                        <div class="modal fade" style="color: black;" id="about" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">About Us</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Welcome to Shoe Haven, your ultimate destination for stylish and comfortable footwear! At Shoe Haven, we believe that the perfect pair of shoes can transform your look and elevate your confidence. Whether you're searching for the latest trends, timeless classics, or performance-driven athletic shoes, our curated collection offers something for everyone. Step into Shoe Haven and discover unparalleled quality, exceptional service, and a haven for all your shoe needs. Your perfect pair awaits!</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="col-md-3">
                <h5>Payment Method</h5>
                <ul class="list-unstyled">
                    <li>
                        <a class="text" href="" data-bs-toggle="modal" data-bs-target="#gcash">Gcash</a>
                        <!-- Modal -->
                        <div class="modal fade" style="color: black;" id="gcash" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">GCASH PAYMENT</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="text-center">
                                            <img src="./images/QRgcash.jpg" alt="gcash" style="width: 150px; height: 150px;">
                                        </div>
                                        <p>On the place order page, if you select GCash as the payment method, a QR code will appear. Scan the QR code to pay for your order and enter the reference number before clicking the place order button.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <a class="text" href="" data-bs-toggle="modal" data-bs-target="#cod">Cash On Delivery</a>
                        <!-- Modal -->
                        <div class="modal fade" style="color: black;" id="cod" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Cash On Delivery</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Pay when the item arrives.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="col-md-3">
                <h5>Follow</h5>
                <ul class="list-unstyled">
                    <li><a class="text" href="#">Facebook</a></li>
                    <li><a class="text" href="#">Instagram</a></li>
                    <li><a class="text" href="#">Twitter</a></li>
                </ul>
            </div>
        </div>
        <div class="row text-center py-1">
            <div class="col">
                <p>&copy; 2024 Shoe Haven. All Rights Reserved</p>
            </div>
        </div>
    </footer>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-4wqw9LA3wCDG/CvflcJLCLvEYPwYkWpIWuo9LUwFNsSvoeQCTUh4wZiDwfKd/Bd0" crossorigin="anonymous"></script>
</body>
</html>
