<?php
@include 'connection.php';
include("function.php");

$message = array();

if (isset($_POST['add_product'])) {
    $p_name = $_POST['p_prod_name'];
    $p_price = $_POST['p_prod_price'];

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
    $color_stock = $_POST['color_stock'];

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
    $insert_query = mysqli_query($con, "INSERT INTO `products`(prod_name, prod_price, prod_image) VALUES('$p_name', '$p_price', '$p_image')") or die('query failed');

    if ($insert_query) {
        move_uploaded_file($p_image_tmp_name, $p_image_folder);

        // Get the last inserted product ID
        $product_id = mysqli_insert_id($con);

        // Insert selected sizes into the size table
        foreach ($p_sizes as $size) {
            mysqli_query($con, "INSERT INTO `size` (product_id, size_name) VALUES ('$product_id', '$size')") or die('Size insertion failed');
        }

        // Loop through each view image
        foreach ($view_images as $key => $view_image) {
            $view_image_tmp_name = $view_image_tmp_names[$key];
            $view_image_path = $view_image_folder . $view_image;

            // Move uploaded file to destination folder
            if (move_uploaded_file($view_image_tmp_name, $view_image_path)) {
                // Insert image name into view_prod table with product_id
                $insert_view_query = mysqli_query($con, "INSERT INTO `view_prod` (product_id, img_name) VALUES ('$product_id', '$view_image')") or die('View image insertion failed');
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
                $insert_color_query = mysqli_query($con, "INSERT INTO `color` (product_id, color_name, stock) VALUES ('$product_id', '$color_image', '$color_stock')") or die('Color image insertion failed');
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
    if ($delete_cart_query && $delete_view_query && $delete_color_query) {
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
        $message[] = 'Failed to delete related cart, view products or color variations';
    }
}

if (isset($_POST['update_product'])) {
    $update_p_id = $_POST['update_p_id'];
    $update_p_name = $_POST['update_p_prod_name'];
    $update_p_price = $_POST['update_p_prod_price'];
    $update_p_image = $_FILES['update_p_prod_image']['name'];
    $update_p_image_tmp_name = $_FILES['update_p_prod_image']['tmp_name'];
    $update_p_image_folder = 'uploaded_img/' . $update_p_image;

    $update_query = mysqli_query($con, "UPDATE `products` SET prod_name = '$update_p_name', prod_price = '$update_p_price', prod_image = '$update_p_image' WHERE product_id = '$update_p_id'");

    if ($update_query) {
        move_uploaded_file($update_p_image_tmp_name, $update_p_image_folder);
        echo'<div class="alert alert-success alert-dismissible fade show position-fixed top-50 start-50 translate-middle" role="alert" style="z-index: 9999;">
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

    <?php require_once('include/nava.php'); ?>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/adminCSS.css">

</head>

<body>

    <?php

    if (isset($message)) {
        foreach ($message as $msg) {
            echo '<div class="message"><span>' . $msg . '</span> <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i> </div>';
        };
    };

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
        <option value="40">40</option>
        <option value="41">41</option>
        <option value="42">42</option>
        <option value="43">43</option>
        <option value="44">44</option>
        <option value="45">45</option>
    </select>

    <input type="submit" value="Add the Product" name="add_product" class="btn">
</form>

        </section>

        <section class="display-product-table">

            <table>

                <thead>
                    <th>Image</th>
                    <th>Product Name</th>
                    <th>Product Price</th>
                    <th>Stock</th>
                    <th>Action</th>
                </thead>

                <tbody>
                    <?php

                    $select_products = mysqli_query($con, "SELECT * FROM `products`");
                    if (mysqli_num_rows($select_products) > 0) {
                        while ($row = mysqli_fetch_assoc($select_products)) {
                            $product_id = $row['product_id'];
                            $select_colors = mysqli_query($con, "SELECT * FROM `color` WHERE product_id = $product_id");
                    ?>

                            <tr>
                                <td><img src="images/<?php echo $row['prod_image']; ?>" height="100" alt=""></td>
                                <td><?php echo $row['prod_name']; ?></td>
                                <td>₱<?php echo $row['prod_price']; ?></td>
                                <td>
                                    <?php 
                                    if (mysqli_num_rows($select_colors) > 0) {
                                        while ($color = mysqli_fetch_assoc($select_colors)) {
                                            echo "Color: " . $color['color_name'] . " - Stock: " . $color['stock'] . "<br>";
                                        }
                                    } else {
                                        echo "No color variations";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <a href="addproducts.php?delete=<?php echo $row['product_id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this?');"> <i class="fas fa-trash"></i> Delete </a>
                                    <a href="addproducts.php?edit=<?php echo $row['product_id']; ?>" class="option-btn"> <i class="fas fa-edit"></i> Update </a>
                                </td>
                            </tr>

                    <?php
                        };
                    } else {
                        echo "<div class='empty'>No product added</div>";
                    };
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

                            <form action="" method="post" enctype="multipart/form-data">
                                <img src="images/<?php echo $fetch_edit['prod_image']; ?>" height="200" alt="">
                                <input type="hidden" name="update_p_id" value="<?php echo $fetch_edit['product_id']; ?>">
                                <label for="update_p_prod_name">Product Name</label>
                                <input type="text" id="update_p_prod_name" class="box" required name="update_p_prod_name" value="<?php echo $fetch_edit['prod_name']; ?>">

                                <label for="update_p_prod_price">Product Price</label>
                                <input type="number" id="update_p_prod_price" min="0" class="box" required name="update_p_prod_price" value="<?php echo $fetch_edit['prod_price']; ?>">

                                <label for="update_p_prod_image">Product Image</label>
                                <input type="file" id="update_p_prod_image" class="box" name="update_p_prod_image" accept="image/png, image/jpg, image/jpeg">

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
           document.getElementById('close-edit').addEventListener('click', function() {
               document.querySelector('.edit-form-container').style.display = 'none';
           });
       </script>
   
   </body>
   
   </html>
