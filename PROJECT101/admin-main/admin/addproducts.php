<?php
@include 'connection.php';
include("function.php");

$message = array();

if(isset($_POST['add_product'])){
    $p_name = $_POST['p_prod_name'];
    $p_price = $_POST['p_prod_price'];
    $p_image = $_FILES['p_prod_image']['name'];
    $p_image_tmp_name = $_FILES['p_prod_image']['tmp_name'];
    $p_image_folder = 'images/'.$p_image;

    $insert_query = mysqli_query($con, "INSERT INTO `products`(prod_name, prod_price, prod_image) VALUES('$p_name', '$p_price', '$p_image')") or die('query failed');

    if($insert_query){
       move_uploaded_file($p_image_tmp_name, $p_image_folder);
       $message[] = 'product added successfully';
    }else{
       $message[] = 'could not add the product';
    }
}

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    $delete_query = mysqli_query($con, "DELETE FROM `products` WHERE product_id = $delete_id") or die('query failed');
    if($delete_query){
        header('location:addproducts.php');
        $message[] = 'product has been deleted';
    }else{
        header('location:addproducts.php');
        $message[] = 'product could not be deleted';
    }
}

if(isset($_POST['update_product'])){
    $update_p_id = $_POST['update_p_id'];
    $update_p_name = $_POST['update_p_prod_name'];
    $update_p_price = $_POST['update_p_prod_price'];
    $update_p_image = $_FILES['update_p_prod_image']['name'];
    $update_p_image_tmp_name = $_FILES['update_p_prod_image']['tmp_name'];
    $update_p_image_folder = 'uploaded_img/'.$update_p_image;

    $update_query = mysqli_query($con, "UPDATE `products` SET prod_name = '$update_p_name', prod_price = '$update_p_price', prod_image = '$update_p_image' WHERE product_id = '$update_p_id'");

    if($update_query){
        move_uploaded_file($update_p_image_tmp_name, $update_p_image_folder);
        $message[] = 'product updated successfully';
        header('location:addproducts.php');
    }else{
        $message[] = 'product could not be updated';
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

if(isset($message)){
   foreach($message as $message){
      echo '<div class="message"><span>'.$message.'</span> <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i> </div>';
   };
};

?>

<div class="container">

<section>

<form action="" method="post" class="add-product-form" enctype="multipart/form-data">
   <h3>add a new product</h3>
   <input type="text" name="p_prod_name" placeholder="Enter the product name" class="box" required>
   <input type="number" name="p_prod_price" min="0" placeholder="Enter the product price" class="box" required>
   <input type="file" name="p_prod_image" accept="image/png, image/jpg, image/jpeg" class="box" required>
   <input type="submit" value="add the product" name="add_product" class="btn">
</form>

</section>

<section class="display-product-table">

   <table>

      <thead>
         <th>image</th>
         <th>product name</th>
         <th>product price</th>
         <th>action</th>
      </thead>

      <tbody>
         <?php
         
            $select_products = mysqli_query($con, "SELECT * FROM `products`");
            if(mysqli_num_rows($select_products) > 0){
               while($row = mysqli_fetch_assoc($select_products)){
         ?>

         <tr>
            <td><img src="images/<?php echo $row['prod_image']; ?>" height="100" alt=""></td>
            <td><?php echo $row['prod_name']; ?></td>
            <td>₱<?php echo $row['prod_price']; ?></td>
            <td>
            <a href="addproducts.php?delete=<?php echo $row['product_id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this?');"> <i class="fas fa-trash"></i> delete </a>
            <a href="addproducts.php?edit=<?php echo $row['product_id']; ?>" class="option-btn"> <i class="fas fa-edit"></i> update </a>
            </td>
         </tr>

         <?php
            };    
            }else{
               echo "<div class='empty'>no product added</div>";
            };
         ?>
      </tbody>
   </table>

</section>

<section class="edit-form-container">

   <?php
   
   if(isset($_GET['edit'])){
    $edit_id = $_GET['edit'];
    $edit_query = mysqli_query($con, "SELECT * FROM `products` WHERE product_id = $edit_id");
    if(mysqli_num_rows($edit_query) > 0){
        while($fetch_edit = mysqli_fetch_assoc($edit_query)){
?>

<form action="" method="post" enctype="multipart/form-data">
    <img src="images/<?php echo $fetch_edit['prod_image']; ?>" height="200" alt="">
    <input type="hidden" name="update_p_id" value="<?php echo $fetch_edit['product_id']; ?>">
    <input type="text" class="box" required name="update_p_prod_name" value="<?php echo $fetch_edit['prod_name']; ?>">
    <input type="number" min="0" class="box" required name="update_p_prod_price" value="<?php echo $fetch_edit['prod_price']; ?>">
    <input type="file" class="box" name="update_p_prod_image" accept="image/png, image/jpg, image/jpeg">
    <input type="submit" value="update the product" name="update_product" class="btn">
    <input type="reset" value="cancel" id="close-edit" class="option-btn">
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


<script src="js/script.js"></script>

</body>
</html>