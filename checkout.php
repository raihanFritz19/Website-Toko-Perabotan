<?php
session_start();
include 'koneksi.php';
require_once __DIR__ . '/vendor/autoload.php';

// If not logged in, redirect to login page
if (!isset($_SESSION["pelanggan"])) {
    echo "<script>alert('Silahkan Login Terlebih Dahulu');</script>";
    echo "<script>location='login.php';</script>";
    exit();
}

// Initialize the keranjang array if not set
if (!isset($_SESSION["keranjang"])) {
    $_SESSION["keranjang"] = array();
}

// Midtrans configuration
\Midtrans\Config::$serverKey = 'SB-Mid-server-vnzHOLBQ_mObWwee2tl4thVI'; // Replace with your server key
\Midtrans\Config::$isProduction = false; // Set to true for production
\Midtrans\Config::$isSanitized = true;
\Midtrans\Config::$is3ds = true;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    <link rel="stylesheet" href="admin/assets/css/bootstrap.css">
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-P8Z8rILxYbb7FC2h"></script> <!-- Replace with your client key -->
</head>
<body>
<!-- navbar -->
<?php include 'menu.php'; ?>

<section class="konten">
    <div class="container">
        <h1>Keranjang Belanja</h1>
        <hr>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subharga</th>
                </tr>
            </thead>
            <tbody>
                <?php $nomor=1; ?>
                <?php $totalbelanja = 0; ?>
                <?php if (!empty($_SESSION["keranjang"])): ?>
                <?php foreach ($_SESSION["keranjang"] as $id_produk => $jumlah): ?>
                <?php
                $ambil = $koneksi->query("SELECT * FROM produk WHERE id_produk='$id_produk'");
                $pecah = $ambil->fetch_assoc();
                $subharga = $pecah["harga_produk"] * $jumlah;
                ?>
                <tr>
                    <td><?php echo $nomor; ?></td>
                    <td><?php echo $pecah["nama_produk"]; ?></td>
                    <td>Rp. <?php echo number_format($pecah["harga_produk"]); ?></td>
                    <td><?php echo $jumlah; ?></td>
                    <td>Rp. <?php echo number_format($subharga); ?></td>
                </tr>
                <?php $nomor++; ?>
                <?php $totalbelanja += $subharga; ?>
                <?php endforeach; ?>
                <?php else: ?>
                <tr>
                    <td colspan="5">Keranjang belanja kosong.</td>
                </tr>
                <?php endif; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4">Total Belanja</th>
                    <th>Rp. <?php echo number_format($totalbelanja); ?></th>
                </tr>
            </tfoot>
        </table>

        <form method="post">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <input type="text" readonly value="<?php echo isset($_SESSION["pelanggan"]['nama_pelanggan']) ? $_SESSION["pelanggan"]['nama_pelanggan'] : ''; ?>" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <input type="text" readonly value="<?php echo isset($_SESSION["pelanggan"]['telepon_pelanggan']) ? $_SESSION["pelanggan"]['telepon_pelanggan'] : ''; ?>" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <select class="form-control" name="id_ongkir" required>
                        <option value="">Pilih Ongkos Kirim</option>
                        <?php
                        $ambil = $koneksi->query("SELECT * FROM ongkir");
                        while ($perongkir = $ambil->fetch_assoc()) {
                        ?>
                        <option value="<?php echo $perongkir["id_ongkir"]; ?>">
                            <?php echo $perongkir['nama_kota']; ?> - Rp. <?php echo number_format($perongkir['tarif']); ?>
                        </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label>Alamat Lengkap Pengiriman</label>
                <textarea class="form-control" name="alamat_pengiriman" placeholder="Masukan alamat lengkap pengiriman (termasuk kode pos)" required></textarea>
            </div>
            <button class="btn btn-primary" name="checkout">Checkout</button>
        </form>

        <?php
        if (isset($_POST["checkout"])) {
            if (!empty($_POST["id_ongkir"]) && !empty($_POST["alamat_pengiriman"])) {
                $id_pelanggan = $_SESSION["pelanggan"]["id_pelanggan"];
                $id_ongkir = $_POST["id_ongkir"];
                $tanggal_pembelian = date("Y-m-d");
                $alamat_pengiriman = $_POST['alamat_pengiriman'];

                $ambil = $koneksi->query("SELECT * FROM ongkir WHERE id_ongkir='$id_ongkir'");
                $arrayongkir = $ambil->fetch_assoc();
                $nama_kota = $arrayongkir['nama_kota'];
                $tarif = $arrayongkir['tarif'];

                $total_pembelian = $totalbelanja + $tarif;

                // Save to pembelian table
                $koneksi->query("INSERT INTO pembelian (id_pelanggan,id_ongkir,tanggal_pembelian,total_pembelian,nama_kota,tarif,alamat_pengiriman)
                    VALUES ('$id_pelanggan','$id_ongkir','$tanggal_pembelian','$total_pembelian','$nama_kota','$tarif','$alamat_pengiriman')");

                // Get last inserted id_pembelian
                $id_pembelian_barusan = $koneksi->insert_id;

                foreach ($_SESSION["keranjang"] as $id_produk => $jumlah) {
                    $ambil = $koneksi->query("SELECT * FROM produk WHERE id_produk='$id_produk'");
                    $perproduk = $ambil->fetch_assoc();

                    $nama = $perproduk['nama_produk'];
                    $harga = $perproduk['harga_produk'];
                    $berat = $perproduk['berat_produk'];

                    $subberat = $perproduk['berat_produk'] * $jumlah;
                    $subharga = $perproduk['harga_produk'] * $jumlah;
                    $koneksi->query("INSERT INTO pembelian_produk (id_pembelian,id_produk,nama,harga,berat,subberat,subharga,jumlah)
                        VALUES ('$id_pembelian_barusan','$id_produk','$nama','$harga','$berat','$subberat','$subharga','$jumlah')");

                    // Update product stock
                    $koneksi->query("UPDATE produk SET stok_produk=stok_produk - $jumlah WHERE id_produk='$id_produk'");
                }

                // Midtrans transaction
                $transaction_details = array(
                    'order_id' => $id_pembelian_barusan,
                    'gross_amount' => $total_pembelian,
                );

                $item_details = array();
                foreach ($_SESSION["keranjang"] as $id_produk => $jumlah) {
                    $ambil = $koneksi->query("SELECT * FROM produk WHERE id_produk='$id_produk'");
                    $perproduk = $ambil->fetch_assoc();

                    $item = array(
                        'id' => $id_produk,
                        'price' => $perproduk['harga_produk'],
                        'quantity' => $jumlah,
                        'name' => $perproduk['nama_produk']
                    );
                    array_push($item_details, $item);
                }

                // Add shipping cost to item details
                $shipping_cost = array(
                    'id' => 'SHIPPING',
                    'price' => $tarif,
                    'quantity' => 1,
                    'name' => 'Ongkos Kirim (' . $nama_kota . ')'
                );
                array_push($item_details, $shipping_cost);

                $customer_details = array(
                    'first_name' => isset($_SESSION["pelanggan"]['nama_pelanggan']) ? $_SESSION["pelanggan"]['nama_pelanggan'] : '',
                    'email' => isset($_SESSION["pelanggan"]['email_pelanggan']) ? $_SESSION["pelanggan"]['email_pelanggan'] : '',
                    'phone' => isset($_SESSION["pelanggan"]['telepon_pelanggan']) ? $_SESSION["pelanggan"]['telepon_pelanggan'] : '',
                );

                $params = array(
                    'transaction_details' => $transaction_details,
                    'item_details' => $item_details,
                    'customer_details' => $customer_details
                );

                try {
                    $snapToken = \Midtrans\Snap::getSnapToken($params);
                    echo '<script>
                        snap.pay("' . $snapToken . '", {
                            onSuccess: function(result){
                                console.log(result);
                                window.location.href = "nota.php?id=' . $id_pembelian_barusan . '";
                            },
                            onPending: function(result){
                                console.log(result);
                                window.location.href = "nota.php?id=' . $id_pembelian_barusan . '";
                            },
                            onError: function(result){
                                console.log(result);
                                alert("Transaction failed");
                            }
                        });
                    </script>';
                } catch (Exception $e) {
                    echo 'Midtrans API error: ' . $e->getMessage();
                }
            } else {
                echo "<script>alert('Silakan isi semua data pengiriman.');</script>";
            }
        }
        ?>
    </div>
</section>
</body>
</html>
