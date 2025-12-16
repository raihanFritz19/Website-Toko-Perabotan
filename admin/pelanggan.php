<?php
// Include the database connection file with the correct path
include '../koneksi.php';

// Tentukan jumlah data per halaman
$perPage = 6;

// Tentukan halaman saat ini
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page > 1) ? ($page * $perPage) - $perPage : 0;

// Mengambil total data
$total = $koneksi->query("SELECT COUNT(*) as total FROM pelanggan")->fetch_assoc()['total'];

// Mengambil data pelanggan untuk halaman saat ini
$ambil = $koneksi->query("SELECT * FROM pelanggan LIMIT $start, $perPage");
?>

<h2>Data Pelanggan</h2>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Telepon</th>
            <th>Email</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $nomor = $start + 1; 
        while ($pecah = $ambil->fetch_assoc()) { 
        ?>
        <tr>
            <td><?php echo $nomor; ?></td>
            <td><?php echo $pecah['nama_pelanggan']; ?></td>
            <td><?php echo $pecah['telepon_pelanggan']; ?></td>
            <td><?php echo $pecah['email_pelanggan']; ?></td>
            <td>
                <a href="hapus_pelanggan.php?id=<?php echo $pecah['id_pelanggan']; ?>" class="btn btn-danger">Hapus</a>
            </td>
        </tr>
        <?php 
            $nomor++; 
        } 
        ?>
    </tbody>
</table>

<!-- Menambahkan navigasi halaman -->
<nav>
    <ul class="pagination">
        <?php 
        $pages = ceil($total / $perPage);
        for ($i = 1; $i <= $pages; $i++) {
        ?>
        <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
            <a class="page-link" href="index.php?halaman=pelanggan&page=<?php echo $i; ?>"><?php echo $i; ?></a>
        </li>
        <?php 
        } 
        ?>
    </ul>
</nav>
