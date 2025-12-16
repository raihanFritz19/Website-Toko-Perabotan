<?php
session_start();
include 'koneksi.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Lupa Password</title>
    <link rel="stylesheet" href="admin/assets/css/bootstrap.css">
    <link rel="icon" type="image/png" href="image/LogoTokoCahaya.png">
    <style>
        .reset-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .panel {
            border: 1px solid #ddd;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .panel-heading {
            background-color: #f5f5f5;
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>
<body>

<?php include 'menu.php'; ?>

<div class="container reset-container">
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Reset Password</h3>
            </div>
            <div class="panel-body">
                <form method="post">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="form-group">
                        <label>Password Baru</label>
                        <input type="password" class="form-control" name="new_password" required>
                    </div>
                    <div class="form-group">
                        <label>Konfirmasi Password Baru</label>
                        <input type="password" class="form-control" name="confirm_password" required>
                    </div>
                    <button class="btn btn-primary btn-block" name="reset_password">Reset Password</button>
                </form>

                <?php
                if (isset($_POST["reset_password"])) {
                    $email = $_POST["email"];
                    $new_password = $_POST["new_password"];
                    $confirm_password = $_POST["confirm_password"];
                    
                    // Check if the passwords match
                    if ($new_password !== $confirm_password) {
                        echo "<script>alert('Password baru dan konfirmasi password tidak sesuai.');</script>";
                    } else {
                        // Query to check if the email exists in the database
                        $ambil = $koneksi->query("SELECT * FROM pelanggan WHERE email_pelanggan='$email'");
                        $akunyangcocok = $ambil->fetch_assoc();
                    
                        if ($akunyangcocok) {
                            // Update the password in the database
                            $koneksi->query("UPDATE pelanggan SET password_pelanggan='$new_password' WHERE email_pelanggan='$email'");
                            echo "<script>alert('Password berhasil direset. Silakan login dengan password baru Anda.');</script>";
                            echo "<script>location='login.php';</script>";
                        } else {
                            echo "<script>alert('Email tidak ditemukan. Silakan coba lagi.');</script>";
                        }
                    }
                }
                ?>

            </div>
        </div>
    </div>
</div>

</body>
</html>
