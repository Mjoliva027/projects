<?php
@include 'connection.php';
include("function.php");

$message = array();

if (isset($_POST['add_product'])) {
    $p_name = mysqli_real_escape_string($con, $_POST['p_prod_name']);
    $p_price = mysqli_real_escape_string($con, $_POST['p_prod_price']);
    $p_desc = mysqli_real_escape_string($con, $_POST['p_prod_desc']);

    // Single image upload for main product display
    $p_image = $_FILES['p_prod_image']['name'];
    $p_image_tmp_name = $_FILES['p_prod_image']['tmp_name'];
    $p_image_folder = 'images/' . $p_image;

    // Multiple images for color options
    $color_images = $_FILES['color_images']['name'];
    $color_image_tmp_names = $_FILES['color_images']['tmp_name'];
    $color_image_folder = 'color_images/'; // Directory to store color images

    // Multiple images for product views
    $view_images = $_FILES['view_images']['name'];
    $view_image_tmp_names = $_FILES['view_images']['tmp_name'];
    $view_image_folder = 'view_images/'; // Directory to store view images

    // Retrieve the stock value for all color variations
    $color_stock = mysqli_real_escape_string($con, $_POST['color_stock']);

    // Create the directories if they don't exist
    if (!is_dir($color_image_folder)) {
        mkdir($color_image_folder, 0777, true);
    }
    if (!is_dir($view_image_folder)) {
        mkdir($view_image_folder, 0777, true);
    }

    // Size selection
    $p_sizes = $_POST['p_size'];

    // Insert product details into database
    $insert_query = mysqli_query($con, "INSERT INTO `products`(prod_name, prod_price, prod_image, prod_des) VALUES('$p_name', '$p_price', '$p_image', '$p_desc')") or die('query failed');

    if ($insert_query) {
        move_uploaded_file($p_image_tmp_name, $p_image_folder);

        // Get the last inserted product ID
        $product_id = mysqli_insert_id($con);

        // Insert selected sizes into the size table
        foreach ($p_sizes as $size) {
            $size = mysqli_real_escape_string($con, $size);
            mysqli_query($con, "INSERT INTO `size` (product_id, size_name) VALUES ('$product_id', '$size')") or die('Size insertion failed');
        }

        // Loop through each view image
        foreach ($view_images as $key => $view_image) {
            $view_image_tmp_name = $view_image_tmp_names[$key];
            $view_image_path = $view_image_folder . $view_image;

            // Move uploaded file to destination folder
            if (move_uploaded_file($view_image_tmp_name, $view_image_path)) {
                // Insert image name into view_prod table with product_id
                mysqli_query($con, "INSERT INTO `view_prod` (product_id, img_name) VALUES ('$product_id', '$view_image')") or die('View image insertion failed');
            } else {
                $message[] = 'Failed to upload view image: ' . $view_image;
            }
        }

        // Loop through each color image
        foreach ($color_images as $key => $color_image) {
            $color_image_tmp_name = $color_image_tmp_names[$key];
            $color_image_path = $color_image_folder . $color_image;

            // Move uploaded file to destination folder
            if (move_uploaded_file($color_image_tmp_name, $color_image_path)) {
                // Insert image name and stock into color table with product_id
                mysqli_query($con, "INSERT INTO `color` (product_id, color_name, stock) VALUES ('$product_id', '$color_image', '$color_stock')") or die('Color image insertion failed');
            } else {
                $message[] = 'Failed to upload color image: ' . $color_image;
            }
        }

        $message[] = 'Product Added Successfully.';
    } else {
        $message[] = 'Could not add the product';
    }
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];

    // First, delete related records from the cart table
    $delete_cart_query = mysqli_query($con, "DELETE FROM `cart` WHERE product_id = $delete_id") or die('Cart deletion failed');

    // Then, delete related records from the view_prod table
    $delete_view_query = mysqli_query($con, "DELETE FROM `view_prod` WHERE product_id = $delete_id") or die('View product deletion failed');

    // Next, delete related records from the color table
    $delete_color_query = mysqli_query($con, "DELETE FROM `color` WHERE product_id = $delete_id") or die('Color deletion failed');

    // Next, delete related records from the size table
    $delete_size_query = mysqli_query($con, "DELETE FROM `size` WHERE product_id = $delete_id") or die('Size deletion failed');

    // If deletion from cart, view_prod, and color tables are successful, proceed to delete from products
    if ($delete_cart_query && $delete_view_query && $delete_color_query && $delete_size_query) {
        // Now delete the product
        $delete_query = mysqli_query($con, "DELETE FROM `products` WHERE product_id = $delete_id") or die('Product deletion failed');

        if ($delete_query) {
            header('location:addproducts.php');
            $message[] = 'Product has been deleted';
        } else {
            header('location:addproducts.php');
            $message[] = 'Product could not be deleted';
        }
    } else {
        header('location:addproducts.php');
        $message[] = 'Failed to delete related cart, view products, or color variations';
    }
}

if (isset($_POST['update_product'])) {
    $update_p_id = $_POST['update_p_id'];
    $update_p_name = $_POST['update_p_prod_name'];
    $update_p_price = $_POST['update_p_prod_price'];
    $update_p_image = $_FILES['update_p_prod_image']['name'];
    $update_p_image_tmp_name = $_FILES['update_p_prod_image']['tmp_name'];
    $update_p_image_folder = 'images/' . $update_p_image;
    $new_stock = $_POST['update_stock'];

    // Update the products table
    $update_query = mysqli_query($con, "UPDATE `products` SET prod_name = '$update_p_name', prod_price = '$update_p_price', prod_image = '$update_p_image' WHERE product_id = '$update_p_id'");

    // Update the color table
    $update_color_query = mysqli_query($con, "UPDATE `color` SET stock = '$new_stock' WHERE product_id = '$update_p_id'");

    if ($update_query && $update_color_query) {
        move_uploaded_file($update_p_image_tmp_name, $update_p_image_folder);
       
         echo '<div class="alert alert-success alert-dismissible fade show position-fixed top-50 start-50 translate-middle" role="alert" style="z-index: 9999;">
        <h4 class="text-center"> Product Updated Successfully. </h4>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
        header('location:addproducts.php');
    } else {
        $message[] = 'Product could not be updated';
        header('location:addproducts.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="css/adminCSS.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   
    <style>
       table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
    font-size: 0.9em;
    min-width: 400px;
}

table th, table td {
    padding: 8px 12px;
    text-align: left;
}

table th {
    background-color: #f4f4f4;
}

table tbody tr {
    border-bottom: 1px solid #dddddd;
}

table tbody tr:nth-of-type(even) {
    background-color: #f9f9f9;
}

table tbody tr:last-of-type {
    border-bottom: 2px solid #009879;
}

.delete-btn, .option-btn {
    font-size: 0.8em;
    padding: 5px 10px;
    margin: 2px 0;
    border: none;
    cursor: pointer;
    border-radius: 5px;
}

.delete-btn {
    background-color: #e74c3c;
    color: white;
}

.option-btn {
    background-color: #2980b9;
    color: white;
}

.btn {
    font-size: 0.9em;
    padding: 10px 20px;
    margin: 10px 0;
    border: none;
    cursor: pointer;
    border-radius: 5px;
    background-color: #27ae60;
    color: white;
}

.box {
    width: 100%;
    padding: 8px;
    margin: 5px 0;
    border: 1px solid #ddd;
    border-radius: 5px;
    box-sizing: border-box;
}

.size {
       display: inline-block;
       margin-right: 5px;
       color: black;
   }
    </style>
</head>

<body>
<?php require_once('include/nava.php'); ?>
    <?php
    if (isset($message)) {
        foreach ($message as $msg) {
            echo '<div class="message"><span>' . $msg . '</span> <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i> </div>';
        }
    }
    ?>
    <div class="container">

        <section>
            <form action="" method="post" class="add-product-form" enctype="multipart/form-data">
                <h3>Add a New Product</h3>
                <label for="p_prod_name">Product Name</label>
                <input type="text" id="p_prod_name" name="p_prod_name" placeholder="Enter the product name" class="box" required>

                <label for="p_prod_price">Product Price</label>
                <input type="number" id="p_prod_price" name="p_prod_price" min="0" placeholder="Enter the product price" class="box" required>

                <label for="p_prod_image">Main Product Image</label>
                <input type="file" id="p_prod_image" name="p_prod_image" accept="image/png, image/jpg, image/jpeg" class="box" required>

                <label for="color_images">Color Images</label>
                <input type="file" id="color_images" name="color_images[]" accept="image/png, image/jpg, image/jpeg" multiple class="box" required>

                <label for="color_stock">Stock</label>
                <input type="number" id="color_stock" name="color_stock" min="0" placeholder="Enter stock for each color image" class="box" required>

                <label for="view_images">Product View Images</label>
                <input type="file" id="view_images" name="view_images[]" accept="image/png, image/jpg, image/jpeg" multiple class="box" required>

                <label for="p_size">Size</label>
                <select id="p_size" name="p_size[]" class="box" required multiple>
                    <option value="35">35</option>
                    <option value="36">36</option>
                    <option value="37">37</option>
                    <option value="38">38</option>
                    <option value="39">39</option>
                    <option value="40">40</option>
                    <option value="41">41</option>
                    <option value="42">42</option>
                    <option value="43">43</option>
                    <option value="44">44</option>
                    <option value="45">45</option>
                </select>

                <label for="p_prod_desc">Product Description</label>
                <textarea id="p_prod_desc" name="p_prod_desc" placeholder="Enter the product description" class="box" required></textarea>

                <input type="submit" value="Add the Product" name="add_product" class="btn">
            </form>
        </section>

        <section class="display-product-table">
            <table>
                <thead>
                    <th>Product Image</th>
                    <th>Product Name</th>
                    <th>Product Price</th>
                    <th>Color Images</th>
                    <th>Color Stock</th>
                    <th>Size</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    <?php
                    $select_products = mysqli_query($con, "SELECT * FROM `products`");
                    if (mysqli_num_rows($select_products) > 0) {
                        while ($row = mysqli_fetch_assoc($select_products)) {
                            $product_id = $row['product_id'];
                    ?>
                            <tr>
                                <td><img src="images/<?php echo $row['prod_image']; ?>" height="100" alt=""></td>
                                <td><?php echo $row['prod_name']; ?></td>
                                <td>₱<?php echo $row['prod_price']; ?></td>
                                <td>
                                    <?php
                                    $select_color_images = mysqli_query($con, "SELECT * FROM `color` WHERE product_id = $product_id");
                                    if (mysqli_num_rows($select_color_images) > 0) {
                                        while ($color_row = mysqli_fetch_assoc($select_color_images)) {
                                            echo '<img src="color_images/' . $color_row['color_name'] . '" height="50" alt=""> ';
                                        }
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $select_color_stock = mysqli_query($con, "SELECT * FROM `color` WHERE product_id = $product_id");
                                    if (mysqli_num_rows($select_color_stock) > 0) {
                                        while ($stock_row = mysqli_fetch_assoc($select_color_stock)) {
                                            echo $stock_row['stock'] . '<br>';
                                        }
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $select_sizes = mysqli_query($con, "SELECT * FROM `size` WHERE product_id = $product_id");
                                    if (mysqli_num_rows($select_sizes) > 0) {
                                        while ($size_row = mysqli_fetch_assoc($select_sizes)) {
                                            echo '<span class="size">' . $size_row['size_name'] . '</span>';
                                        }
                                    }
                                    ?>
                                </td>
                                <td>
                                    <a href="addproducts.php?delete=<?php echo $row['product_id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this?');"> <i class="fas fa-trash"></i> Delete </a>
                                    <a href="addproducts.php?edit=<?php echo $row['product_id']; ?>" class="option-btn"> <i class="fas fa-edit"></i> Update </a>
                                </td>
                            </tr>
                    <?php
                        }
                    } else {
                        echo "<div class='empty'>No product added</div>";
                    }
                    ?>
                </tbody>
            </table>
        </section>

        <section class="edit-form-container">
            <?php
            if (isset($_GET['edit'])) {
                $edit_id = $_GET['edit'];
                $edit_query = mysqli_query($con, "SELECT * FROM `products` WHERE product_id = $edit_id");
                if (mysqli_num_rows($edit_query) > 0) {
                    while ($fetch_edit = mysqli_fetch_assoc($edit_query)) {
            ?>
                            <form action="" method="post" enctype="multipart/form-data" class="add-product-form">
                                <input type="hidden" name="update_p_id" value="<?php echo $fetch_edit['product_id']; ?>">
                                <label for="update_p_prod_price">Product Price</label>
                                <input type="number" id="update_p_prod_price" min="0" class="box" required name="update_p_prod_price" value="<?php echo $fetch_edit['prod_price']; ?>">
                                <label for="update_stock">New Stock</label>
                                <input type="number" id="update_stock" name="update_stock" min="0" placeholder="Enter new stock for all variations" class="box">
                                <input type="submit" value="Update the Product" name="update_product" class="btn">
                                <input type="reset" value="Cancel" id="close-edit" class="option-btn">
                            </form>
            <?php
                    }
                }
                echo "<script>document.querySelector('.edit-form-container').style.display = 'flex';</script>";
            }
            ?>
        </section>
    </div>

    <script>
        document.getElementById('close-edit').addEventListener('click', function () {
            document.querySelector('.edit-form-container').style.display = 'none';
        });
    </script>
</body>

</html>
