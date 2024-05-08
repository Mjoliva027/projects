<style>
    /************************** for sidebar ***********************************/

    /* The sidebar menu */
    .sidebar {
        height: 100%;
        /* 100% Full-height */
        width: 0;
        /* 0 width - change this with JavaScript */
        position: fixed;
        /* Stay in place */
        z-index: 1;
        /* Stay on top */
        top: 0;
        left: 0;
        background-color: #3B3131;
        /* Black*/
        overflow-x: hidden;
        /* Disable horizontal scroll */
        padding-top: 60px;
        /* Place content 60px from the top */
        transition: 0.5s;
        /* 0.5 second transition effect to slide in the sidebar */
    }

    /* The sidebar links */
    .sidebar a {
        padding: 8px 8px 8px 32px;
        text-decoration: none;
        font-size: 22px;
        color: #fff;
        display: block;
        transition: 0.3s;
    }

    .sidebar .side-header {
        margin-left: 30px;
        margin-bottom: 8px;
        color: #fff;
    }

    /* When you mouse over the navigation links, change their color */
    .sidebar a:hover {
        background-color: #584e46;
    }

    /* Position and style the close button (top right corner) */
    .sidebar .closebtn {
        position: absolute;
        top: 0;
        right: 2px;
        font-size: 34px;
        margin-left: 50px;
    }

    /* The button used to open the sidebar */
    .openbtn {
        font-size: 20px;
        cursor: pointer;
        padding: 10px 15px;
        border: none;
        color: #fff;
        background-color: #584e46;
    }

    .openbtn:hover {
        color: #ECDAC9;
    }

    #main {
        transition: margin-left .5s;
        /* If you want a transition effect */
        padding: 20px;
    }

    @media screen and (max-height: 450px) {
        .sidebar {
            padding-top: 15px;
        }

        .sidebar a {
            font-size: 18px;
        }
    }
</style>

<!-- Sidebar -->
<div class="sidebar" id="mySidebar">
    <div class="side-header">
        <img src="./images/shoe-haven-high-resolution-logo-transparent.png" style="margin-left: 30px;" width="120" height="120" alt="logo">
        <h5 style="margin-top:10px; margin-left:20px;">Hello, Admin</h5>
    </div>

    <hr style="border:1px solid; background-color:#8a7b6d; border-color:#3B3131;">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
    <a href="admin.php"><i class="fa fa-home"></i> Dashboard</a>
    <a href="customers.php" onclick="showCustomers()"><i class="fa fa-users"></i> Customers</a>
    <a href="add_products.php" onclick="showProducts()"><i class="fa fa-th"></i> Add Products</a>
    <a href="#products" onclick="showProductItems()"><i class="fa fa-th"></i> Products</a>
    <a href="#orders" onclick="showOrders()"><i class="fa fa-list"></i> Orders</a>
</div>


<div id="main">
    <button class="openbtn" onclick="openNav()"><i class="fa fa-home"></i></button>
</div>

<script>
    function openNav() {
        document.getElementById("mySidebar").style.width = "250px";
        document.getElementById("main").style.marginLeft = "250px";
        document.getElementById("main-content").style.marginLeft = "250px";
        document.getElementById("main").style.display = "none";
    }

    function closeNav() {
        document.getElementById("mySidebar").style.width = "0";
        document.getElementById("main").style.marginLeft = "0";
        document.getElementById("main").style.display = "block";
    }
</script>