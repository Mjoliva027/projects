<?php
session_start();
include("connection.php");
include("function.php");

//check if the user is click the post button
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $lastname = $_POST['fullname'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    //save to database
    $user_id = random_num(15);
    $query = "INSERT INTO `users`( `user_id`, `fullname`, `age`, `gender`, `email`, `username`, `password`) 
        VALUES ('$user_id','$fullname','$age','$gender','$email','$username','$password')";

    mysqli_query($con, $query);

    header("location: login.php");
    die;
}

$_SESSION;

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap-5.3.2-dist/css/bootstrap.css">
    <link rel="stylesheet" href="style.css">
    <title>Shoe haven</title>
</head>

<body id="signup">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="images/shoe-haven-high-resolution-logo-transparent.png" width="50" height="50"> Shoe Haven</a>
        </div>
    </nav>

    <div class="container d-flex justify-content-center align-items-center min-vh-100">

        <div class="row border rounded-5 p-3 bg-white shadow box-area">


            <div class="container">
                <div class="row align-items-center">
                    <div class="header-text mb-1">
                        <p style="color: black;">Sign Up</p>
                    </div>
                    <form method="post">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6">


                                    <div class="  mb-2">
                                        <input type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Fullname" name="fullname" required>
                                    </div>

                                    <div class=" mb-2">
                                        <input type="number" class="form-control form-control-lg bg-light fs-6" placeholder="Age" name="age" required>
                                    </div>

                                    <div class="btn-group w-100 mb-2" role="group" aria-label="Basic radio toggle button group">
                                        <input type="radio" class="btn-check" name="gender" id="btnradio1" autocomplete="off" checked value="male">
                                        <label class="btn btn-outline-primary" for="btnradio1">Male</label>

                                        <input type="radio" class="btn-check" name="gender" id="btnradio2" autocomplete="off" value="female">
                                        <label class="btn btn-outline-primary" for="btnradio2">Female</label>
                                    </div>

                                    <div class="mb-2">
                                        <input type="email" class="form-control form-control-lg bg-light fs-6" placeholder="Email Address" name="email" required>
                                    </div>
                                </div>

                                <!--2nd row-->
                                <div class="col-md-6">

                                    <div class=" mb-2">
                                        <input type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Username" name="username" required>
                                    </div>

                                    <div class=" mb-2">
                                        <input type="password" class="form-control form-control-lg bg-light fs-6" id="password" placeholder="Password" name="password" required>
                                    </div>

                                    <div class=" mb-2">
                                        <input type="password" class="form-control form-control-lg bg-light fs-6" id="confirmPassword" placeholder="Confirm Password" required>
                                        <span id="passwordError" class="error"></span>
                                    </div>

                                </div>



                            </div>

                        </div>
                </div>

                <div class="input-group mb-3 mt-3 align-items-center justify-content-center">
                    <button class="btn btn-md btn-primary w-50 fs-6" onclick="validatePassword()">Sign up</button>

                </div>

                <div class="row text-center">
                    <Small style="color: black;">Have an account? <a href="login.php">Log in</a></Small>
                </div>

                </form>




            </div>

        </div>


    </div>
    </div>


    <script>
        function validatePassword() {
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirmPassword").value;
            var errorElement = document.getElementById("passwordError");

            if (password === "" || confirmPassword === "") {
                errorElement.textContent = "Please enter both password and confirm password.";
                errorElement.style.color = "red";
                return false;
            }

            if (password !== confirmPassword) {
                errorElement.textContent = "Passwords do not match!";
                errorElement.style.color = "red";
            } else {
                errorElement.textContent = "Sign up Successfully";
                errorElement.style.color = "blue";
                // Redirect to the login page
                window.location.href = "login.php";
            }
        }
    </script>


    <script src="bootstrap-5.3.2-dist/js/bootstrap.bundle.js"></script>
</body>

</html>