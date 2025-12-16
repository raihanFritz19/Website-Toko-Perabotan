<?php include 'koneksi.php'; ?>
<?php
$keyword = isset($_GET["keyword"]) ? $_GET["keyword"] : '';

$semuadata = array();
if (!empty($keyword)) {
    $ambil = $koneksi->query("SELECT * FROM produk WHERE nama_produk LIKE '%$keyword%' OR deskripsi_produk LIKE '%$keyword%'");
    while ($pecah = $ambil->fetch_assoc()) {
        $semuadata[] = $pecah;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Pencarian</title>
    <link rel="stylesheet" type="text/css" href="admin/assets/css/bootstrap.css">
</head>
<body>
<?php include 'menu.php'; ?>
    <div class="container">
        <?php if (!empty($keyword)): ?>
            <h3>Hasil Pencarian: <?php echo htmlspecialchars($keyword); ?></h3>

            <?php if (empty($semuadata)): ?>
                <div class="alert alert-danger">Produk <strong><?php echo htmlspecialchars($keyword); ?></strong> tidak ditemukan</div>
            <?php endif ?>

            <div class="row">
                <?php foreach ($semuadata as $key => $value): ?>
                    <div class="col-md-3">
                        <div class="thumbnail">
                            <img src="foto_produk/<?php echo htmlspecialchars($value["foto_produk"]); ?>" alt="" class="img-responsive">
                            <div class="caption">
                                <h3><?php echo htmlspecialchars($value["nama_produk"]); ?></h3>
                                <h5>Rp. <?php echo number_format($value['harga_produk']); ?></h5>
                                <a href="beli.php?id=<?php echo $value["id_produk"]; ?>" class="btn btn-primary">Beli</a>
                                <a href="detail.php?id=<?php echo $value["id_produk"]; ?>" class="btn btn-default">Detail</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        <?php endif ?>
    </div>
</body>
</html>
