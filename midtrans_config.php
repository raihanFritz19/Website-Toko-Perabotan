<?php
require_once dirname(__FILE__) . '/path/to/Midtrans.php'; // Sesuaikan path-nya

// Set your Merchant Server Key
\Midtrans\Config::$serverKey = 'SB-Mid-server-vnzHOLBQ_mObWwee2tl4thVI'; // Ganti dengan Server Key dari Midtrans

// Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
\Midtrans\Config::$isProduction = false;

// Set sanitization on (default)
\Midtrans\Config::$isSanitized = true;

// Set 3DS transaction for credit card to true
\Midtrans\Config::$is3ds = true;
?>
