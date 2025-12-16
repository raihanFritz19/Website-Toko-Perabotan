<?php
session_start();
// Include the database connection file
include '../koneksi.php';

// Set default status to an empty string
$status_filter = '';

// Check if the form has been submitted and set the status filter
if (isset($_POST['status'])) {
    $status_filter = $_POST['status'];
}

?>

<h2>Data Penjualan</h2>

<!-- Search form -->
<form method="post" action="">
    <label for="status">Filter by Status Data Penjualan:</label>
    <select name="status" id="status">
        <option value="">All</option>
        <option value="pending" <?php if ($status_filter == 'pending') echo 'selected'; ?>>Pending</option>
        <option value="lunas" <?php if ($status_filter == 'lunas') echo 'selected'; ?>>Lunas</option>
        <option value="sudah kirim pembayaran" <?php if ($status_filter == 'sudah kirim pembayaran') echo 'selected'; ?>>Sudah Kirim Pembayaran</option>
        <option value="barang dikirim" <?php if ($status_filter == 'barang dikirim') echo 'selected'; ?>>Barang Dikirim</option>
        <option value="gagal" <?php if ($status_filter == 'gagal') echo 'selected'; ?>>Gagal</option>
        <option value="expired" <?php if ($status_filter == 'expired') echo 'selected'; ?>>Expired</option>
    </select>
    <button type="submit" class="btn btn-primary">Filter</button>
</form>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Pelanggan</th>
            <th>Tanggal</th>
            <th>Status Pembelian</th>
            <th>Total</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php $nomor = 1; ?>
        <?php 
        // Modify the query to include the status filter and group by customer name
        if ($status_filter) {
            $ambil = $koneksi->query("SELECT * FROM pembelian JOIN pelanggan ON pembelian.id_pelanggan = pelanggan.id_pelanggan WHERE pembelian.status_pembelian = '$status_filter' GROUP BY pelanggan.nama_pelanggan"); 
        } else {
            $ambil = $koneksi->query("SELECT * FROM pembelian JOIN pelanggan ON pembelian.id_pelanggan = pelanggan.id_pelanggan GROUP BY pelanggan.nama_pelanggan");
        }
        ?>
        <?php while($pecah = $ambil->fetch_assoc()){ ?>
        <tr>
            <td><?php echo $nomor; ?></td>
            <td><?php echo $pecah['nama_pelanggan']; ?></td>
            <td><?php echo $pecah['tanggal_pembelian']; ?></td>
            <td><?php echo $pecah['status_pembelian']; ?></td>
            <td>Rp. <?php echo number_format($pecah['total_pembelian']); ?></td>
            <td>
                <a href="index.php?halaman=detail&id=<?php echo $pecah['id_pembelian']; ?>" class="btn btn-info">Detail</a>
                <?php if ($pecah['status_pembelian'] !== "pending"): ?>
                <a href="index.php?halaman=pembayaran&id=<?php echo $pecah['id_pembelian']; ?>" class="btn btn-success">Pembayaran</a>
                <?php endif ?>
                <a href="hapuspembelian.php?id=<?php echo $pecah['id_pembelian']; ?>" class="btn btn-danger" onclick="return confirm('Anda yakin ingin menghapus data ini?')">Hapus</a>
            </td>
        </tr>
        <?php $nomor++; ?>
        <?php } ?>
    </tbody>
</table>
