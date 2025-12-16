<?php
session_start();
include '../koneksi.php';
require_once __DIR__ . '/vendor/autoload.php';

\Midtrans\Config::$serverKey = 'SB-Mid-server-vnzHOLBQ_mObWwee2tl4thVI';
\Midtrans\Config::$isProduction = false;
\Midtrans\Config::$isSanitized = true;
\Midtrans\Config::$is3ds = true;

// Handle Midtrans notification
$notification = new \Midtrans\Notification();

$transaction = $notification->transaction_status;
$type = $notification->payment_type;
$order_id = $notification->order_id;
$fraud = $notification->fraud_status;

// Get the order from database
$ambil = $koneksi->query("SELECT * FROM pembelian WHERE id_pembelian='$order_id'");
$pecah = $ambil->fetch_assoc();

if ($transaction == 'capture') {
    // Capture only applies to card transaction
    if ($type == 'credit_card') {
        if ($fraud == 'challenge') {
            // Update to pending payment status
            $koneksi->query("UPDATE pembelian SET status_pembelian='pending' WHERE id_pembelian='$order_id'");
        } else {
            // Update to success payment status
            $koneksi->query("UPDATE pembelian SET status_pembelian='lunas' WHERE id_pembelian='$order_id'");
        }
    }
} else if ($transaction == 'settlement') {
    // Update to success payment status
    $koneksi->query("UPDATE pembelian SET status_pembelian='lunas' WHERE id_pembelian='$order_id'");
} else if ($transaction == 'pending') {
    // Update to pending payment status
    $koneksi->query("UPDATE pembelian SET status_pembelian='pending' WHERE id_pembelian='$order_id'");
} else if ($transaction == 'deny') {
    // Update to failure payment status
    $koneksi->query("UPDATE pembelian SET status_pembelian='gagal' WHERE id_pembelian='$order_id'");
} else if ($transaction == 'expire') {
    // Update to expired payment status
    $koneksi->query("UPDATE pembelian SET status_pembelian='expired' WHERE id_pembelian='$order_id'");
} else if ($transaction == 'cancel') {
    // Update to canceled payment status
    $koneksi->query("UPDATE pembelian SET status_pembelian='gagal' WHERE id_pembelian='$order_id'");
}
?>
