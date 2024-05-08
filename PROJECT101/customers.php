<?php
session_start();
include("connection.php");
include("function.php");



$_SESSION;

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <title>Shoe Haven</title>
  <style>
    table {
      width: 100%;
      border-collapse: collapse;
      border-spacing: 0;
      box-shadow: 0 2px 15px rgba(64, 64, 64, .7);
      border-radius: 12px 12px 0 0;
      margin-bottom: 50px;
    }

    td,
    th {
      padding: 10px 16px;
      text-align: center;
    }

    th {
      background-color: #584e46;
      color: #fafafa;
      font-family: 'Open Sans', Sans-serif;
      font-weight: bold;
    }

    tr {
      width: 100%;
      background-color: #fafafa;
      font-family: 'Montserrat', sans-serif;
    }

    tr:nth-child(even) {
      background-color: #eeeeee;
    }
  </style>
</head>

<body>
  <?php
  require_once('include/adminheader.php');
  require_once('include/sidebar.php');

  ?>
  <div>
    <h2>All Customers</h2>
    <table class="table">
      <thead>
        <tr>
          <th class="text-center">ID</th>
          <th class="text-center">Fullname</th>
          <th class="text-center">Email</th>
          <th class="text-center">Username</th>
          <th class="text-center">User Status</th>
        </tr>
      </thead>
      <tbody>
        <?php

        $sql = "SELECT * FROM users WHERE user_type = 'u'";
        $result = $con->query($sql);
        $count = 1;
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
        ?>
            <tr>
              <td><?php echo $count; ?></td>
              <td><?php echo $row["fullname"]; ?></td>
              <td><?php echo $row["email"]; ?></td>
              <td><?php echo $row["username"]; ?></td>
              <td><?php echo $row["status"]; ?></td>
            </tr>
        <?php
            $count++;
          }
        }
        ?>
      </tbody>
    </table>
  </div>


  <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>



</body>

</html>