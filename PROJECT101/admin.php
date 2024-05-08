<?php
session_start();
include("connection.php");
include("function.php");



$_SESSION;

?>

<!DOCTYPE html>
<html>

<head>
    <title>Show Haven</title>

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    </head>
    <style>
        /*********** admin dashboard styling **********/
        @import url('https://fonts.googleapis.com/css?family=Work+Sans:400,500,600,700&display=swap');

        * {
            margin: 0;
            padding: 0;
            font-family: 'Work Sans', sans-serif;
            font-size: 18px;
        }

        .card {
            background-color: #3B3131;
            padding: 20px;
            margin: 10px;
            border-radius: 10px;
            box-shadow: 8px 5px 5px #3B3131;
        }
    </style>
</head>

<body>

    <?php
    require_once('include/adminheader.php');
    require_once('include/sidebar.php');

    ?>

    <div id="main-content" class="container allContent-section py-4">
        <div class="row">
            <div class="col-sm-3">
                <div class="card">
                    <i class="fa fa-users  mb-2" style="font-size: 70px;"></i>
                    <h4 style="color:white;">Total Users</h4>
                    <h5 style="color:white;">
                        <?php
                        $sql = "SELECT * from users";
                        $result = $con->query($sql);
                        $count = 0;
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {

                                $count = $count + 1;
                            }
                        }
                        echo $count;
                        ?></h5>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="card">
                    <i class="fa fa-th mb-2" style="font-size: 70px;"></i>
                    <h4 style="color:white;">Total Products</h4>
                    <h5 style="color:white;">
                        <?php

                        $sql = "SELECT * from products";
                        $result = $con->query($sql);
                        $count = 0;
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {

                                $count = $count + 1;
                            }
                        }
                        echo $count;
                        ?>
                    </h5>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card">
                    <i class="fa fa-list mb-2" style="font-size: 70px;"></i>
                    <h4 style="color:white;">Total orders</h4>
                    <h5 style="color:white;">
                        <?php

                        $sql = "SELECT * from orders";
                        $result = $con->query($sql);
                        $count = 0;
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {

                                $count = $count + 1;
                            }
                        }
                        echo $count;
                        ?>
                    </h5>
                </div>
            </div>
        </div>

    </div>


    <?php
    if (isset($_GET['category']) && $_GET['category'] == "success") {
        echo '<script> alert("Category Successfully Added")</script>';
    } else if (isset($_GET['category']) && $_GET['category'] == "error") {
        echo '<script> alert("Adding Unsuccess")</script>';
    }
    if (isset($_GET['size']) && $_GET['size'] == "success") {
        echo '<script> alert("Size Successfully Added")</script>';
    } else if (isset($_GET['size']) && $_GET['size'] == "error") {
        echo '<script> alert("Adding Unsuccess")</script>';
    }
    if (isset($_GET['variation']) && $_GET['variation'] == "success") {
        echo '<script> alert("Variation Successfully Added")</script>';
    } else if (isset($_GET['variation']) && $_GET['variation'] == "error") {
        echo '<script> alert("Adding Unsuccess")</script>';
    }
    ?>



    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>

    <script>
        function showProductItems() {
            $.ajax({
                url: "./adminView/viewAllProducts.php",
                method: "post",
                data: {
                    record: 1
                },
                success: function(data) {
                    $('.allContent-section').html(data);
                }
            });
        }

        function showCategory() {
            $.ajax({
                url: "./adminView/viewCategories.php",
                method: "post",
                data: {
                    record: 1
                },
                success: function(data) {
                    $('.allContent-section').html(data);
                }
            });
        }

        function showProducts() {
            $.ajax({
                url: "add_products.php",
                method: "post",
                data: {
                    record: 1
                },
                success: function(data) {
                    $('.allContent-section').html(data);
                }
            });
        }

        function showProductSizes() {
            $.ajax({
                url: "./adminView/viewProductSizes.php",
                method: "post",
                data: {
                    record: 1
                },
                success: function(data) {
                    $('.allContent-section').html(data);
                }
            });
        }

        function showCustomers() {
            $.ajax({
                url: "customers.php",
                method: "post",
                data: {
                    record: 1
                },
                success: function(data) {
                    $('.allContent-section').html(data);
                }
            });
        }

        function showOrders() {
            $.ajax({
                url: "viewAllOrders.php",
                method: "post",
                data: {
                    record: 1
                },
                success: function(data) {
                    $('.allContent-section').html(data);
                }
            });
        }

        function ChangeOrderStatus(id) {
            $.ajax({
                url: "./controller/updateOrderStatus.php",
                method: "post",
                data: {
                    record: id
                },
                success: function(data) {
                    alert('Order Status updated successfully');
                    $('form').trigger('reset');
                    showOrders();
                }
            });
        }

        function ChangePay(id) {
            $.ajax({
                url: "./controller/updatePayStatus.php",
                method: "post",
                data: {
                    record: id
                },
                success: function(data) {
                    alert('Payment Status updated successfully');
                    $('form').trigger('reset');
                    showOrders();
                }
            });
        }


        //add product data
        function addItems() {
            var p_name = $('#p_name').val();
            var p_desc = $('#p_desc').val();
            var p_price = $('#p_price').val();
            var category = $('#category').val();
            var upload = $('#upload').val();
            var file = $('#file')[0].files[0];

            var fd = new FormData();
            fd.append('p_name', p_name);
            fd.append('p_desc', p_desc);
            fd.append('p_price', p_price);
            fd.append('category', category);
            fd.append('file', file);
            fd.append('upload', upload);
            $.ajax({
                url: "./controller/addItemController.php",
                method: "post",
                data: fd,
                processData: false,
                contentType: false,
                success: function(data) {
                    alert('Product Added successfully.');
                    $('form').trigger('reset');
                    showProductItems();
                }
            });
        }

        //edit product data
        function itemEditForm(id) {
            $.ajax({
                url: "./adminView/editItemForm.php",
                method: "post",
                data: {
                    record: id
                },
                success: function(data) {
                    $('.allContent-section').html(data);
                }
            });
        }

        //update product after submit
        function updateItems() {
            var product_id = $('#product_id').val();
            var p_name = $('#p_name').val();
            var p_desc = $('#p_desc').val();
            var p_price = $('#p_price').val();
            var category = $('#category').val();
            var existingImage = $('#existingImage').val();
            var newImage = $('#newImage')[0].files[0];
            var fd = new FormData();
            fd.append('product_id', product_id);
            fd.append('p_name', p_name);
            fd.append('p_desc', p_desc);
            fd.append('p_price', p_price);
            fd.append('category', category);
            fd.append('existingImage', existingImage);
            fd.append('newImage', newImage);

            $.ajax({
                url: './controller/updateItemController.php',
                method: 'post',
                data: fd,
                processData: false,
                contentType: false,
                success: function(data) {
                    alert('Data Update Success.');
                    $('form').trigger('reset');
                    showProductItems();
                }
            });
        }

        //delete product data
        function itemDelete(id) {
            $.ajax({
                url: "./controller/deleteItemController.php",
                method: "post",
                data: {
                    record: id
                },
                success: function(data) {
                    alert('Items Successfully deleted');
                    $('form').trigger('reset');
                    showProductItems();
                }
            });
        }


        //delete cart data
        function cartDelete(id) {
            $.ajax({
                url: "./controller/deleteCartController.php",
                method: "post",
                data: {
                    record: id
                },
                success: function(data) {
                    alert('Cart Item Successfully deleted');
                    $('form').trigger('reset');
                    showMyCart();
                }
            });
        }

        function eachDetailsForm(id) {
            $.ajax({
                url: "./view/viewEachDetails.php",
                method: "post",
                data: {
                    record: id
                },
                success: function(data) {
                    $('.allContent-section').html(data);
                }
            });
        }



        //delete category data
        function categoryDelete(id) {
            $.ajax({
                url: "./controller/catDeleteController.php",
                method: "post",
                data: {
                    record: id
                },
                success: function(data) {
                    alert('Category Successfully deleted');
                    $('form').trigger('reset');
                    showCategory();
                }
            });
        }

        //delete size data
        function sizeDelete(id) {
            $.ajax({
                url: "./controller/deleteSizeController.php",
                method: "post",
                data: {
                    record: id
                },
                success: function(data) {
                    alert('Size Successfully deleted');
                    $('form').trigger('reset');
                    showSizes();
                }
            });
        }


        //delete variation data
        function variationDelete(id) {
            $.ajax({
                url: "./controller/deleteVariationController.php",
                method: "post",
                data: {
                    record: id
                },
                success: function(data) {
                    alert('Successfully deleted');
                    $('form').trigger('reset');
                    showProductSizes();
                }
            });
        }

        //edit variation data
        function variationEditForm(id) {
            $.ajax({
                url: "./adminView/editVariationForm.php",
                method: "post",
                data: {
                    record: id
                },
                success: function(data) {
                    $('.allContent-section').html(data);
                }
            });
        }


        //update variation after submit
        function updateVariations() {
            var v_id = $('#v_id').val();
            var product = $('#product').val();
            var size = $('#size').val();
            var qty = $('#qty').val();
            var fd = new FormData();
            fd.append('v_id', v_id);
            fd.append('product', product);
            fd.append('size', size);
            fd.append('qty', qty);

            $.ajax({
                url: './controller/updateVariationController.php',
                method: 'post',
                data: fd,
                processData: false,
                contentType: false,
                success: function(data) {
                    alert('Update Success.');
                    $('form').trigger('reset');
                    showProductSizes();
                }
            });
        }

        function search(id) {
            $.ajax({
                url: "./controller/searchController.php",
                method: "post",
                data: {
                    record: id
                },
                success: function(data) {
                    $('.eachCategoryProducts').html(data);
                }
            });
        }


        function quantityPlus(id) {
            $.ajax({
                url: "./controller/addQuantityController.php",
                method: "post",
                data: {
                    record: id
                },
                success: function(data) {
                    $('form').trigger('reset');
                    showMyCart();
                }
            });
        }

        function quantityMinus(id) {
            $.ajax({
                url: "./controller/subQuantityController.php",
                method: "post",
                data: {
                    record: id
                },
                success: function(data) {
                    $('form').trigger('reset');
                    showMyCart();
                }
            });
        }

        function checkout() {
            $.ajax({
                url: "./view/viewCheckout.php",
                method: "post",
                data: {
                    record: 1
                },
                success: function(data) {
                    $('.allContent-section').html(data);
                }
            });
        }


        function removeFromWish(id) {
            $.ajax({
                url: "./controller/removeFromWishlist.php",
                method: "post",
                data: {
                    record: id
                },
                success: function(data) {
                    alert('Removed from wishlist');
                }
            });
        }


        function addToWish(id) {
            $.ajax({
                url: "./controller/addToWishlist.php",
                method: "post",
                data: {
                    record: id
                },
                success: function(data) {
                    alert('Added to wishlist');
                }
            });
        }
    </script>
</body>

</html>