<!-- /mnt/data/hapusproduk.php -->

<?php
// Include the database connection file with the correct path
include '../koneksi.php';

$ambil = $koneksi->query("SELECT * FROM produk WHERE id_produk='$_GET[id]'");
$pecah = $ambil->fetch_assoc();
$fotoproduk = $pecah['foto_produk'];

// Check if the file exists and delete it
if (file_exists("../foto_produk/$fotoproduk")) {
    unlink("../foto_produk/$fotoproduk");
}

// Delete the product from the database
$koneksi->query("DELETE FROM produk WHERE id_produk='$_GET[id]'");

echo "<script>alert('produk terhapus');</script>";
echo "<script>location='index.php?halaman=produk';</script>";
?>
