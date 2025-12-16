<?php
session_start();
include 'koneksi.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login Pelanggan</title>
    <link rel="stylesheet" href="admin/assets/css/bootstrap.css">
    <link rel="icon" type="image/png" href="image/LogoTokoCahaya.png"> <!-- Menggantikan Icon Pada Tab Web -->
    <style>
        .login-container {
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
        .logo {
            display: block;
            margin: 0 auto 15px;
            border-radius: 50%;
            width: 100px;
            height: 100px;
            object-fit: cover;
        }
        .forgot-password {
            margin-bottom: 10px;
            text-align: left; /* Aligns the "Lupa Password?" link to the left */
        }
    </style>
</head>
<body>

<?php include 'menu.php'; ?>

<div class="container login-container">
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Login Pelanggan</h3>
            </div>
            <div class="panel-body">
                <form method="post">
                    <img src="image/LogoTokoCahaya.png" alt="Logo" class="logo">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <div class="form-group forgot-password">
                        <a href="lupa_password.php" style="color: blue;">Lupa Password?</a>
                    </div>
                    <button class="btn btn-primary btn-block" name="login">Login</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
// If the login button is pressed
if (isset($_POST["login"])) {

    $email = $_POST["email"];
    $password = $_POST["password"];
    // Query to check account in pelanggan table
    $ambil = $koneksi->query("SELECT * FROM pelanggan WHERE email_pelanggan='$email' AND password_pelanggan='$password'");

    // Count the number of matching accounts
    $akunyangcocok = $ambil->num_rows;

    // If one account matches, log in
    if ($akunyangcocok == 1) {
        // Successful login
        // Get account details as an array
        $akun = $ambil->fetch_assoc();
        // Save in session pelanggan
        $_SESSION["pelanggan"] = $akun;
        echo "<script>alert('Anda sukses login');</script>";

        // If already shopping
        if (isset($_SESSION["keranjang"]) OR !empty($_SESSION["keranjang"])) {
            echo "<script>location='checkout.php';</script>";
        } else {
            echo "<script>location='riwayat.php';</script>";
        }
    } else {
        // Failed login
        echo "<script>alert('Anda gagal login, periksa akun anda');</script>";
        echo "<script>location='login.php';</script>";
    }
}
?>

</body>
</html>
