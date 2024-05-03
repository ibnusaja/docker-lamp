<?php
require 'connect.php';

$kode = $_POST['kode'];
$nama_barang = $_POST['nama_barang'];
$harga = $_POST['harga'];
mysqli_query($connect, "INSERT INTO autocode(kode,nama_barang,harga) VALUES('$kode','$nama_barang','$harga')");
header("location:index.php");
?>