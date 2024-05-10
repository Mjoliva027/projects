<?php

@include 'shoe_haven';

session_start();
session_unset();
session_destroy();

header('location: /PROJECT101/login.php');

?>