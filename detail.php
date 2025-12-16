<?php session_start(); ?>
<?php include 'koneksi.php' ?>
<?php
// mendapatkan id_produk dari url
$id_produk = $_GET["id"];

//query ambil data
$ambil = $koneksi->query("SELECT * FROM produk WHERE id_produk='$id_produk'");
$detail = $ambil->fetch_assoc();

// Atur stok menjadi 0 jika stok negatif
if ($detail['stok_produk'] < 0) {
    $detail['stok_produk'] = 0;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Detail Produk</title>
    <link rel="stylesheet" href="admin/assets/css/bootstrap.css">
</head>
<body>

<?php include 'menu.php'; ?>

<section class="kontent">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <img src="foto_produk/<?php echo $detail["foto_produk"]; ?>" alt="" class="img-responsive">
            </div>
            <div class="col-md-6">
                <h2><?php echo $detail["nama_produk"] ?></h2>
                <h4>Rp. <?php echo number_format($detail["harga_produk"]); ?></h4>
                <h5>Stok: <?php echo $detail['stok_produk'] ?></h5>
                <?php if ($detail['stok_produk'] > 0): ?>
                <form method="post">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="number" min="1" class="form-control" name="jumlah" max="<?php echo $detail['stok_produk'] ?>" required>
                            <div class="input-group-btn">
                                <button class="btn btn-primary" name="beli">Beli</button>
                            </div>
                        </div>
                    </div>
                </form>
                <?php else: ?>
                    <div class="alert alert-danger">Stok habis</div>
                <?php endif; ?>
                <?php
                // jk ada tombol beli
                if (isset($_POST["beli"]))
                {
                    // mendapatkan jumlah yg diinputkan
                    $jumlah = $_POST["jumlah"];

                    // memastikan jumlah yang dibeli tidak melebihi stok yang tersedia
                    if ($jumlah > $detail['stok_produk']) {
                        echo "<script>alert('Jumlah pembelian melebihi stok yang tersedia');</script>";
                    } else {
                        // masukan di keranjang belanja
                        $_SESSION["keranjang"]["$id_produk"] = $jumlah;
                        echo "<script>alert('Produk telah masuk ke keranjang belanja');</script>";
                        echo "<script>location='keranjang.php';</script>";
                    }
                }
                ?>
                <p><?php echo nl2br($detail["deskripsi_produk"]); ?></p>
            </div>
        </div>
    </div>
</section>

</body>
</html>
