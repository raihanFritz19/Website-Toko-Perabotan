<?php
session_start();
include '../koneksi.php';

$searchQuery = '';
if (isset($_POST['search'])) {
    $searchQuery = $_POST['search'];
}

$query = "SELECT * FROM produk LEFT JOIN kategori ON produk.id_kategori=kategori.id_kategori";
if ($searchQuery != '') {
    $query .= " WHERE stok_produk = $searchQuery";
}
$ambil = $koneksi->query($query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Produk</title>
    <link rel="stylesheet" href="admin/assets/css/bootstrap.css">
</head>
<body>
    <div class="container">
        <h2>Data Produk</h2>

        <form method="post" class="form-inline">
            <div class="form-group">
                <label for="search">Cari Stok: </label>
                <input type="number" class="form-control" id="search" name="search" value="<?php echo $searchQuery; ?>" min="0">
            </div>
            <button type="submit" class="btn btn-primary">Cari</button>
        </form>

        <br>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kategori</th>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Berat</th>
                    <th>Foto</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $nomor = 1;
                while($pecah = $ambil->fetch_assoc()){ 
                ?> 
                <tr>
                    <td><?php echo $nomor; ?></td>
                    <td><?php echo $pecah["nama_kategori"]; ?></td>
                    <td><?php echo $pecah['nama_produk']; ?></td>
                    <td>Rp. <?php echo number_format($pecah['harga_produk']); ?></td>
                    <td><?php echo $pecah['stok_produk'] > 0 ? $pecah['stok_produk'] : 'Stok Habis'; ?></td>
                    <td><?php echo $pecah['berat_produk']; ?> gr</td>
                    <td>
                        <img src="../foto_produk/<?php echo $pecah['foto_produk']; ?>" width="100">
                    </td>
                    <td>
                        <a href="index.php?halaman=hapusproduk&id=<?php echo $pecah['id_produk']; ?>" class="btn btn-danger btn-sm">Hapus</a>
                        <a href="index.php?halaman=ubahproduk&id=<?php echo $pecah['id_produk'];?>" class="btn btn-warning btn-sm">Ubah</a>
                        <a href="index.php?halaman=detailproduk&id=<?php echo $pecah['id_produk'];?>" class="btn btn-info btn-sm">Detail</a>
                    </td>
                </tr>
                <?php $nomor++; ?>
                <?php } ?>	
            </tbody>
        </table>
        <a href="index.php?halaman=tambahproduk" class="btn btn-primary">Tambah Data</a>
    </div>
</body>
</html>
