<?php
// Include the database connection file
include '../koneksi.php';

// Get the 'idfoto' and 'idproduk' from the URL
$id_foto = $_GET["idfoto"];
$id_produk = $_GET["idproduk"];

// Fetch the photo details from the database
$ambilfoto = $koneksi->query("SELECT * FROM produk_foto WHERE id_produk_foto='$id_foto'");
$detailfoto = $ambilfoto->fetch_assoc();

$namafilefoto = $detailfoto["nama_produk_foto"];

// Delete the photo file from the folder
if (file_exists("../foto_produk/" . $namafilefoto)) {
    unlink("../foto_produk/" . $namafilefoto);
}

// Delete the photo record from the database
$koneksi->query("DELETE FROM produk_foto WHERE id_produk_foto='$id_foto'");

// Redirect with a success message
echo "<script>alert('Foto produk berhasil dihapus');</script>";
echo "<script>location='index.php?halaman=detailproduk&id=$id_produk';</script>";
?>
