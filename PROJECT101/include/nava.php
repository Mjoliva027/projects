<style>
  body {
    margin: 0;
    font-family: Arial, sans-serif;
}

.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 20px;
    background-color: #333;
    color: #fff;
}

.logo img {
    height: 55px;
    margin-left: 30px;
}

.ttle h4 {
  margin-right: 100px;
  margin-left: -280px;
  font-size: 18px;
  color: white;
  margin-top: 5px;
}

.nav-links {
    list-style: none;
    display: flex;
    align-items: center;
    margin: 0; /* Remove default margin */
    padding: 0; /* Remove default padding */
    justify-content: center; /* Align items to the center */
}

.nav-links li {
    margin-right: 20px;
}

.nav-links li a {
    text-decoration: none;
    color: #fff;
    padding: 10px;
    font-size: 15px;
    transition: color 0.3s ease;
}

.nav-links li a:hover {
    color: #ccc;
}

.nav-links li a.active {
    border-bottom: 2px solid #fff;
}
</style>

<nav class="navbar">
    <div class="logo">
        <img src="./images/shoe-haven-high-resolution-logo-transparent.png" alt="Logo">
    </div>
    <div class="ttle">
    <h4> Shoe Haven </h4>
</div>
    <ul class="nav-links">
        <li><a href="adminpage.php">Home</a></li>
        <li><a href="order_received.php">Inbox</a></li>
        <li><a href="addproducts.php">Products</a></li>
        <li><a href="viewCustomer.php">Customers</a></li>
        <li><a href="viewAllOrders.php">Orders</a></li>
        <li><a href="Sales.php">Sales</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</nav>