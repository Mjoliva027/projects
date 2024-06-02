<?php include('connection.php') ?>
<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php?msg=no_user_found");
    exit(); // Ensure to stop further execution
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
   
   
   <title>Admin Page</title>

   <style>
/* Font Import */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600&display=swap');

/* Variable Declarations */
:root {
   --blue: #2980b9;
   --red: rgb(255, 0, 0);
   --orange: orange;
   --black: #333;
   --white: #fff;
   --bg-color: #eee;
   --dark-bg: rgba(0, 0, 0, .7);
   --box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .1);
   --border: .1rem solid #999;
}

/* General Styling */
* {
   font-family: 'Poppins', sans-serif;
   margin: 0;
   padding: 0;
   box-sizing: border-box;
   outline: none;
   border: none;
   text-decoration: none;
   text-transform: capitalize;
color: rgb(149, 184, 255);
}

html {
   font-size: 62.5%;
   overflow-x: hidden;
}

.container {
   max-width: 1200px;
   margin: 0 auto;
   margin-top: 50px;
}

.small-box{
   height: 120px;
   width: 300px ;
   text-align: center;
   padding-top: 25px;
   margin-left: 400px;
}

.small-box .inner p {
   font-size: 16px;
   color: #333;
}

   </style>
 </head>
  
<body>
   <?php require_once('include/nava.php'); ?>
<div class="container">
        <div class="row">
          <div class="col-md-3">
            <div class="small-box bg-light shadow-sm border">
              <div class="inner">
                <h3><?php echo $con->query("SELECT * FROM `products`")->num_rows; ?></h3>

                <p>Total Products</p>
              </div>
            </div>
          </div>
       </div>

       <div class="row">
          <div class="col-md-3">
            <div class="small-box bg-light shadow-sm border">
              <div class="inner">
                <h3><?php echo $con->query("SELECT * FROM `users`")->num_rows; ?></h3>

                <p>Total Users</p>
              </div>
              
            </div>
          </div>
       </div>

       <div class="row">
          <div class="col-md-3">
            <div class="small-box bg-light shadow-sm border">
              <div class="inner">
                <h3><?php echo $con->query("SELECT * FROM `orders`")->num_rows; ?></h3>

                <p>Total Orders</p>
              </div>
              <div class="icon">
                <i class="fa fa-building"></i>
              </div>
            </div>
          </div>
       </div>

       <div class="row">
    <div class="col-md-3">
        <div class="small-box bg-light shadow-sm border">
            <div class="inner">
            <?php

// Query to select total sales from orders where payment_status is '1'
$result = $con->query("SELECT SUM(price_total) AS total_sales FROM `orders` WHERE `status` = 'received'");
$totalPaidSales = 0;
// Check if the query executed successfully
if ($result) {
    // Fetch the total sales value
    $row = $result->fetch_assoc();
    $totalPaidSales = $row["total_sales"];
} 
?>

                <h3>₱<?= number_format($totalPaidSales, 2) ?></h3>
                <p>Total Sales: </p>
            </div>
            <div class="icon">
                <i class="fa fa-building"></i>
            </div>
        </div>
    </div>
</div>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

