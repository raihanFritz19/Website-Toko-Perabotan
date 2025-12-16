<?php
// Include the database connection file with the correct path
include '../koneksi.php';

$semuadata = array();
$tgl_mulai = "";
$tgl_selesai = "";
$status = "";

// Tentukan jumlah data per halaman
$perPage = 6;

// Tentukan halaman saat ini
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page > 1) ? ($page * $perPage) - $perPage : 0;

if (isset($_POST["kirim"]) || isset($_GET['tglm'])) {
    $tgl_mulai = isset($_POST["tglm"]) ? $_POST["tglm"] : $_GET['tglm'];
    $tgl_selesai = isset($_POST['tgls']) ? $_POST['tgls'] : $_GET['tgls'];
    $status = isset($_POST["status"]) ? $_POST["status"] : $_GET['status'];

    // Mengambil total data sesuai filter yang dipilih dengan tambahan kondisi pl.nama_pelanggan IS NOT NULL
    $total = $koneksi->query("SELECT COUNT(*) as total FROM pembelian pm LEFT JOIN pelanggan pl ON pm.id_pelanggan=pl.id_pelanggan WHERE status_pembelian='$status' AND tanggal_pembelian BETWEEN '$tgl_mulai' AND '$tgl_selesai' AND pl.nama_pelanggan IS NOT NULL")->fetch_assoc()['total'];
    
    // Mengambil data pembelian untuk halaman saat ini dengan tambahan kondisi pl.nama_pelanggan IS NOT NULL
    $ambil = $koneksi->query("SELECT * FROM pembelian pm LEFT JOIN pelanggan pl ON pm.id_pelanggan=pl.id_pelanggan WHERE status_pembelian='$status' AND tanggal_pembelian BETWEEN '$tgl_mulai' AND '$tgl_selesai' AND pl.nama_pelanggan IS NOT NULL LIMIT $start, $perPage");

    while ($pecah = $ambil->fetch_assoc()) {
        $semuadata[] = $pecah;
    }
}
?>

<h2>Laporan Penjualan dari <?php echo $tgl_mulai ?> hingga <?php echo $tgl_selesai ?></h2>
<br>

<form method="post">
    <div class="row">
        <div class="col-md-3">
            <label>Tanggal Mulai</label>
            <input type="date" class="form-control" name="tglm" value="<?php echo $tgl_mulai ?>">
        </div>
        <div class="col-md-3">
            <label>Tanggal Selesai</label>
            <input type="date" class="form-control" name="tgls" value="<?php echo $tgl_selesai ?>">
        </div>
        <div class="col-md-3">
            <label>Status</label>
            <select class="form-control" name="status">
                <option value="">Pilih Status</option>
                <option value="pending"  <?php echo $status=="pending"?"selected":""; ?> >Belom Melakukan Pembayaran</option>
                <option value="barang dikirim"  <?php echo $status=="barang dikirim"?"selected":""; ?> >Barang Dikirim</option>
                <option value="sudah kirim pembayaran"  <?php echo $status=="sudah kirim pembayaran"?"selected":""; ?> >Sudah Kirim Pembayaran</option>
            </select>
        </div>
        <div class="col-md-2">
            <label>&nbsp;</label><br>
            <button class="btn btn-primary" name="kirim">Lihat</button>
        </div>
    </div>
</form>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Pelanggan</th>
            <th>Tanggal</th>
            <th>Jumlah</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php $total_harga = 0; ?>
        <?php foreach ($semuadata as $key => $value): ?>
        <?php $total_harga += $value['total_pembelian'] ?>
        <tr>
            <td><?php echo $key + 1 + $start; ?></td>
            <td><?php echo $value["nama_pelanggan"] ?></td>
            <td><?php echo date("d F Y", strtotime($value["tanggal_pembelian"])) ?></td>
            <td>Rp. <?php echo number_format($value["total_pembelian"]) ?></td>
            <td><?php echo $value["status_pembelian"] ?></td>
        </tr>
        <?php endforeach ?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="3">Total</th>
            <th>Rp. <?php echo number_format($total_harga) ?></th>
            <th></th>
        </tr>
    </tfoot>
</table>

<!-- Menambahkan navigasi halaman -->
<nav>
    <ul class="pagination">
        <?php 
        if (isset($_POST["kirim"]) || isset($_GET['tglm'])) {
            $pages = ceil($total / $perPage);
            for ($i = 1; $i <= $pages; $i++) {
        ?>
        <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
            <a class="page-link" href="index.php?halaman=laporan_pembelian&page=<?php echo $i; ?>&tglm=<?php echo $tgl_mulai; ?>&tgls=<?php echo $tgl_selesai; ?>&status=<?php echo $status; ?>"><?php echo $i; ?></a>
        </li>
        <?php 
            } 
        }
        ?>
    </ul>
</nav>
