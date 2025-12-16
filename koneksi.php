<?php 
$koneksi = new mysqli("localhost","root","","perabotan");  
if ($koneksi->connect_error) {
     die("Connection failed: " . $koneksi->connect_error);
 }
?>
