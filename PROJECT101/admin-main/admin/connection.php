<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "shoe_haven";

if (!$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname)) {
    die("failed to connect");
}
