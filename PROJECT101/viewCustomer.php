<?php

@include 'connection.php';
include("function.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Page</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/adminCSS.css">
</head>
<body>

<?php require_once('include/nava.php'); ?>

<div >
<p class="client">Customers</p>
  <table class="table ">
    <thead>
      <tr>
        <th class="text-center">ID</th>
        <th class="text-center">Name </th>
        <th class="text-center">Email</th>
      </tr>
    </thead>
    <?php
      
      $sql="SELECT * from users where user_type = 'u'";
      $result=$con-> query($sql);
      $count=1;
      if ($result-> num_rows > 0){
        while ($row=$result-> fetch_assoc()) {
           
    ?>
    <tr>
      <td class="text-center"><?=$count?></td>
      <td class="text-center"><?=$row["fullname"]?> </td>
      <td class="text-center"><?=$row["email"]?></td>
      
    </tr>
    <?php
            $count=$count+1;
           
        }
    }
    ?>
  </table>