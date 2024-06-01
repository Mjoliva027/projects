<?php
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "shoe_haven";

if (!$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname)) {
    die("failed to connect");
}

$query = $_GET['query'];
$query = $con->real_escape_string($query);

$sql = "SELECT * FROM products WHERE prod_name LIKE '%$query%' OR prod_des LIKE '%$query%'";
$result = $con->query($sql);

// Fetching suggested products
$suggested_sql = "SELECT * FROM products ORDER BY RAND() LIMIT 5"; // Change the limit as needed
$suggested_result = $con->query($suggested_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="bootstrap-5.3.2-dist/css/bootstrap.css">
    <script src="https://kit.fontawesome.com/c8fb92272e.js" crossorigin="anonymous"></script>
    <style>
        .card {
            width: 200px; 
            margin-bottom: 20px; 
        }
        .search {margin-top: 10%;}
        .card-body {
            padding: 5px; /* Adjust padding */
        }
        .card-body p {
            margin-bottom: 0; /* Remove bottom margin of paragraph */
        }
        
    </style>
</head>
<body>

<?php require_once('include/nav.php'); ?>

<div class="container mt-5">
    <h1 class="search">Search Results for "<?php echo htmlspecialchars($query); ?>"</h1>
    <?php if ($result->num_rows > 0): ?>
        <div class="row row-cols-2 row-cols-md-5 g-6 ps-4">
            <?php while ($row = $result->fetch_assoc()): ?>
                <?php
                $product_id = $row['product_id'];
                $prod_name = $row['prod_name'];
                $prod_price = $row['prod_price'];
                $prod_image = $row['prod_image'];
                ?>
                <div class="col">
                    <a href="view_products.php?product_id=<?= $row['product_id'] ?>" class="text-decoration-none text-black">
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
    <?php else: ?>
        <p>No results found for "<?php echo htmlspecialchars($query); ?>".</p>
    <?php endif; ?>
    
    <!-- Suggested Products Section -->
    <h2 class="mt-5 mb-5">Suggested Products</h2>
   
    <div class="row row-cols-2 row-cols-md-5 g-6 ps-4">
        <?php while ($row = $suggested_result->fetch_assoc()): ?>
            <?php
                $product_id = $row['product_id'];
                $prod_name = $row['prod_name'];
                $prod_price = $row['prod_price'];
                $prod_image = $row['prod_image'];
                ?>
                <div class="col">
                    <a href="view_products.php?product_id=<?= $row['product_id'] ?>" class="text-decoration-none text-black">
                        <div class="card mh-100 mb-4 shadow-sm">
                            <div style="max-height: 200px; overflow: hidden;">
                                <img src="./images/<?php echo $prod_image; ?>" class="card-img-top img-fluid" alt="<?php echo $prod_name; ?>">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"style="font-size: 15px;"><?= htmlspecialchars($row['prod_name']) ?></h5>
                                <p class="text-muted">₱<?= htmlspecialchars($row['prod_price']) ?></p>
                            </div>
                        </div>
                    </a>
                </div>
        <?php endwhile; ?>
    </div>

    
   
    <!-- End of Suggested Products Section -->
    
    <?php $con->close(); ?>
</div>
<?php require_once('include/footer.php'); ?>
<script src="bootstrap-5.3.2-dist/js/bootstrap.bundle.js"></script>
</body>
</html>
