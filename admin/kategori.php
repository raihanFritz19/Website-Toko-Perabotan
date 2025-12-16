<?php
session_start();
// Include the database connection file
include '../koneksi.php';

// Fetch all categories from the database
$semuadata = array();
$ambil = $koneksi->query("SELECT * FROM kategori");
while ($tiap = $ambil->fetch_assoc()) {
    $semuadata[] = $tiap;
}

// Handle form submission for adding a new category
if (isset($_POST['tambah'])) {
    $nama_kategori = $_POST['nama_kategori'];
    $koneksi->query("INSERT INTO kategori (nama_kategori) VALUES ('$nama_kategori')");
    echo "<script>alert('Data Kategori berhasil ditambahkan');</script>";
    echo "<script>location='index.php?halaman=kategori';</script>";
}

// Handle form submission for editing a category
if (isset($_POST['ubah'])) {
    $id_kategori = $_POST['id_kategori'];
    $nama_kategori = $_POST['nama_kategori'];
    $koneksi->query("UPDATE kategori SET nama_kategori='$nama_kategori' WHERE id_kategori='$id_kategori'");
    echo "<script>alert('Data Kategori berhasil diubah');</script>";
    echo "<script>location='index.php?halaman=kategori';</script>";
}

// Handle deleting a category
if (isset($_GET['hapus'])) {
    $id_kategori = $_GET['hapus'];
    $koneksi->query("DELETE FROM kategori WHERE id_kategori='$id_kategori'");
    echo "<script>alert('Data Kategori berhasil dihapus');</script>";
    echo "<script>location='index.php?halaman=kategori';</script>";
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Data Kategori</title>
    <link rel="stylesheet" href="admin/assets/css/bootstrap.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="container">
        <h3>Data Kategori</h3>
        <hr>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($semuadata as $key => $value) : ?>
                    <tr>
                        <td><?php echo $key + 1 ?></td>
                        <td>
                            <span class="nama-kategori"><?php echo $value["nama_kategori"] ?></span>
                            <form class="form-ubah d-none" method="post">
                                <input type="hidden" name="id_kategori" value="<?php echo $value['id_kategori']; ?>">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="nama_kategori" value="<?php echo $value['nama_kategori']; ?>" required>
                                </div>
                                <button class="btn btn-primary btn-sm" name="ubah">Ubah</button>
                                <button type="button" class="btn btn-secondary btn-sm btn-cancel">Batal</button>
                            </form>
                        </td>
                        <td>
                            <a href="kategori.php?hapus=<?php echo $value['id_kategori']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>

        <h3>Tambah Kategori</h3>
        <form method="post">
            <div class="form-group">
                <label>Nama Kategori</label>
                <input type="text" class="form-control" name="nama_kategori" required>
            </div>
            <button class="btn btn-primary" name="tambah">Tambah</button>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            $('.btn-edit').on('click', function() {
                var row = $(this).closest('tr');
                row.find('.nama-kategori').hide();
                row.find('.form-ubah').removeClass('d-none');
                $(this).hide();
            });

            $('.btn-cancel').on('click', function() {
                var row = $(this).closest('tr');
                row.find('.nama-kategori').show();
                row.find('.form-ubah').addClass('d-none');
                row.find('.btn-edit').show();
            });
        });
    </script>
</body>

</html>
