<?php

// file ini untuk menghubungkan ke database

$servername = "db";
$username = "user";
$password = "userpassword";
$dbname = "mydatabase";

/// sesuaikan sesuai database

$connect = mysqli_connect($servername, $username, $password, $dbname);
?>
