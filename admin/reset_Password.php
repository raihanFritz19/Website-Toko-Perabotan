<?php
// Koneksi ke database
include '../koneksi.php';

// Pastikan form sudah disubmit
if (isset($_POST['submit'])) {
    if (isset($_POST['old_username']) && isset($_POST['new_username']) && isset($_POST['new_password'])) {
        $oldUsername = $_POST['old_username']; // Username lama
        $newUsername = $_POST['new_username']; // Username baru
        $newPassword = $_POST['new_password']; // Password baru

        // Cek apakah username lama ada di database
        $result = $koneksi->query("SELECT * FROM admin WHERE username='$oldUsername'");
        if ($result->num_rows > 0) {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT); // Enkripsi password baru

            // Update username dan password di database
            $koneksi->query("UPDATE admin SET username='$newUsername', password='$hashedPassword' WHERE username='$oldUsername'");

            echo "<script>location='login.php';</script>"; // Mengarahkan ke halaman login
        } else {
            // Jika username lama tidak ditemukan, tampilkan pesan kesalahan
            echo "<div class='alert alert-danger'>Username lama tidak ditemukan.</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Harap masukkan semua data yang diperlukan.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Username dan Password Admin</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/custom.css" rel="stylesheet" />
</head>
<body>
    <div class="container">
        <div class="row text-center">
            <div class="col-md-6 col-md-offset-3">
                <br /><br />
                <h2>Reset Username dan Password Admin</h2>
                <h5>Masukkan username lama Anda untuk mereset username dan password baru.</h5>
                <br />
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong>Masukkan Data Anda</strong></div>
                    <div class="panel-body">
                        <form role="form" method="post">
                            <div class="form-group">
                                <input type="text" name="old_username" class="form-control" placeholder="Username Lama" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="new_username" class="form-control" placeholder="Username Baru" required>
                            </div>
                            <div class="form-group">
                                <input type="password" name="new_password" class="form-control" placeholder="Password Baru" required>
                            </div>
                            <button class="btn btn-primary" type="submit" name="submit">Reset Username dan Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- SCRIPTS -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/custom.js"></script>
</body>
</html>
