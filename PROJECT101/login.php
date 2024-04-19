<?php
session_start();
include("connection.php");
include("function.php");

//check if the user is click the post button
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $username = $_POST['username'];
    $password = $_POST['password'];
    if (!empty($username) && !empty($password)) {
        //read from database
        $query = "SELECT * FROM users WHERE username = '$username' LIMIT 1";
        $result = mysqli_query($con, $query);

        $result = mysqli_query($con, $query);
        if ($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);

            if ($user_data['password'] === $password) {
                // Set user_id in the session and redirect
                $_SESSION['user_id'] = $user_data['user_id'];
                header("location: product.php");
                die;
            } else {
                // Set an error message for incorrect password
                $error = "Incorrect password. Please try again.";
            }
        } else {
            // Set an error message for incorrect username
            $error = "Incorrect Username. Please try again";
        }
    }
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
    <title>Shoe Haven</title>
</head>

<body id="login">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="images/shoe-haven-high-resolution-logo-transparent.png " width="50" height="50" Shoe Haven> Shoe Haven</a>
        </div>
    </nav>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">

        <div class="row border rounded-5 p-3 bg-white shadow box-area">

            <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box ">
                <div class="featured-image mb-2">
                    <img src="images/shoe-haven-high-resolution-logo.png" class="img-fluid" style="width: 450px;">
                </div>

            </div>
            <div class="right-box col-md-6 ">
                <div class="row align-items-center">
                    <div class="header-text mb-3">
                        <p style="color: black;">Log In</p>
                    </div>
                    <form method="post">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Username" name="username" required>
                        </div>

                        <div class="input-group mb-1">
                            <input type="password" class="form-control form-control-lg bg-light fs-6" placeholder="Password" name="password" required>
                        </div>

                        <div class="forgot mb-3">
                            <small><a href="#">Forgot Password</a></small>
                        </div>
                        <?php if (!empty($error)) : ?>
                            <div class="alert alert-danger mb-3">
                                <?php echo $error; ?>
                            </div>
                        <?php endif; ?>
                        <div class="input-group mb-3">
                            <button class="btn bnt-lg btn-primary w-100 fs-6">Login</button>
                        </div>

                        <div class="row text-center">
                            <Small style="color: black;">Don't have an account? <a href="signup.php">Sign up</a></Small>
                        </div>
                    </form>
                </div>

            </div>

        </div>
    </div>

    <script src="bootstrap-5.3.2-dist/js/bootstrap.bundle.js"></script>
</body>

</html>