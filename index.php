<?php
session_start();
include 'koneksi.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Toko Cahaya Perabotan Rumah Tangga</title>
    <link rel="stylesheet" href="admin/assets/css/bootstrap.css">
    <link rel="icon" type="image/png" href="image/LogoTokoCahaya.png"> <!-- Menggantikan Icon Pada Tab Web -->
    <style>
        .logo {
            max-width: 80px; /* Sesuaikan ukuran pada logo */
            margin: 20px 0;
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .banner {
            width: 100%;
            height: 400px; /*Atur ketinggian tetap */
            margin-bottom: 20px;
            position: relative;
            overflow: hidden;
        }
        .banner img {
            width: 100%;
            height: 120%;
            object-fit: cover; /* Memastikan gambar mencakup seluruh area spanduk */
        }
        .thumbnail {
            margin-bottom: 20px; /* Sesuaikan margin sesuai kebutuhan */
        }
        .row {
            display: flex;
            flex-wrap: wrap;
        }
        .col-md-3 {
            flex: 0 0 25%;
            max-width: 25%;
            padding: 10px; /* Sesuaikan bantalan untuk mengontrol jarak antar produk */
        }
        .banner-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
        }
        .banner-arrow-right {
            right: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <img src="image/LogoTokoCahaya.png" alt="Logo" class="logo"> <!-- Menggantikan logo Pada Web Anda -->
        <?php include 'menu.php'; ?>
    </div>
</div>

<!-- konten -->
<section class="konten">
    <div class="container">
        <div class="banner">
            <img src="image/cahayalogo-store.jpg" alt="Banner" id="bannerImage" class="banner"> <!-- Menambahkan banner di atas tulisan Produk Terbaru -->
            <button class="banner-arrow banner-arrow-right" onclick="nextBanner()">></button>
        </div>
        <h1>Produk Terbaru</h1>

        <div class="row">
            <?php 
            $ambil = $koneksi->query("SELECT * FROM produk"); 
            while ($perproduk = $ambil->fetch_assoc()) { 
            ?>
            <div class="col-md-3">
                <div class="thumbnail">
                    <img src="foto_produk/<?php echo $perproduk['foto_produk']; ?>" alt="">
                    <div class="caption">
                        <h3><?php echo $perproduk['nama_produk']; ?></h3>
                        <h5>Rp. <?php echo number_format($perproduk['harga_produk']); ?></h5>
                        <?php if ($perproduk['stok_produk'] > 0) { ?>
                            <a href="beli.php?id=<?php echo $perproduk['id_produk']; ?>" class="btn btn-primary">Beli</a>
                        <?php } else { ?>
                            <button class="btn btn-danger" disabled>Stok Habis</button>
                        <?php } ?>
                        <a href="detail.php?id=<?php echo $perproduk['id_produk']; ?>" class="btn btn-default">Detail</a>
                    </div>
                </div>
            </div>
            <?php 
            } 
            ?>
        </div>
    </div>
</section>

<script>
    var bannerImages = ["image/cahayalogo-store.jpg", "image/cahayabanner-store1.jpg"];
    var currentBannerIndex = 0;

    function nextBanner() {
        currentBannerIndex = (currentBannerIndex + 1) % bannerImages.length;
        document.getElementById('bannerImage').src = bannerImages[currentBannerIndex];
    }
</script>

</body>
</html>
