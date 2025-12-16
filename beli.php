<?php
session_start();
//mendapatkan id_produk dari url
$id_produk = $_GET['id'];

// cek apakah produk tersebut sudah ada di keranjang
if (isset($_SESSION['keranjang'][$id_produk])) {
    // pastikan nilai di keranjang adalah integer
    $_SESSION['keranjang'][$id_produk] = (int)$_SESSION['keranjang'][$id_produk] + 1;
} else {
    // jika produk belum ada di keranjang, maka tambahkan sebagai produk baru dengan jumlah 1
    $_SESSION['keranjang'][$id_produk] = 1;
}

// larikan ke halaman keranjang
echo "<script>alert('produk telah masuk ke keranjang belanja');</script>";
echo "<script>location='keranjang.php';</script>";
?>
