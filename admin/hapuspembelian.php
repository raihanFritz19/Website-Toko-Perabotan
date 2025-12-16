<?php
session_start();
// Include the database connection file
include '../koneksi.php';

// Handle the delete action
if (isset($_GET['id'])) {
    $id_pembelian = $_GET['id'];
    $result = $koneksi->query("DELETE FROM pembelian WHERE id_pembelian='$id_pembelian'");

    if ($result) {
        echo "<script>alert('Data penjualan telah dihapus');</script>";
    } else {
        echo "<script>alert('Data penjualan gagal dihapus: " . $koneksi->error . "');</script>";
    }
    echo "<script>location='index.php?halaman=pembelian';</script>";
}
?>
