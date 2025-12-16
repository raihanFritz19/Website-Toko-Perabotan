<?php
session_start();
// Koneksi ke database
include '../koneksi.php';

// Check if the form is submitted
if (isset($_POST['login'])) {
    $username = $_POST['user'];
    $password = $_POST['pass'];

    // Check if 'Remember me' is checked
    if (isset($_POST['remember'])) {
        setcookie('username', $username, time() + (86400 * 30), "/"); // 30 days
        setcookie('password', $password, time() + (86400 * 30), "/"); // 30 days
    } else {
        // Expire the cookies if 'Remember me' is not checked
        setcookie('username', '', time() - 3600, "/");
        setcookie('password', '', time() - 3600, "/");
    }

    // Query to check the user credentials
    $ambil = $koneksi->query("SELECT * FROM admin WHERE username='$username'");
    if ($ambil->num_rows > 0) {
        $row = $ambil->fetch_assoc();
        // Verify the password
        if (password_verify($password, $row['password'])) {
            $_SESSION['admin'] = $row;
            echo "<div class='alert alert-info'>Login sukses</div>";
            echo "<meta http-equiv='refresh' content='1;url=index.php'>";
        } else {
            echo "<div class='alert alert-danger'>Login Gagal</div>";
            echo "<meta http-equiv='refresh' content='1;url=login.php'>";
        }
    } else {
        echo "<div class='alert alert-danger'>Username tidak ditemukan</div>";
        echo "<meta http-equiv='refresh' content='1;url=login.php'>";
    }
}

// Retrieve cookies if they exist
$savedUsername = isset($_COOKIE['username']) ? $_COOKIE['username'] : '';
$savedPassword = isset($_COOKIE['password']) ? $_COOKIE['password'] : '';

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Toko Cahaya Perabotan Rumah Tangga</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="assets/img/LogoTokoCahaya.png" />
    <!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLES-->
    <link href="assets/css/custom.css" rel="stylesheet" />
    <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <style>
        body {
            background-image: url('assets/img/60914-cahayalogo-store.jpg'); /* Path to your background image */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
        }
        .panel-default {
            background-color: rgba(255, 255, 255, 0.9); /* White background with some transparency */
            padding: 20px;
            border-radius: 10px;
        }
        .forgot-password-link {
            display: inline-block;
            margin-bottom: 10px;
            color: blue;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row text-center ">
            <div class="col-md-12">
                <br /><br />
                <h2>Toko Cahaya Perabotan : Login</h2>
                <h5>( Login yourself to get access )</h5>
                <br />
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong>Enter Details To Login</strong></div>
                    <div class="panel-body">
                        <form role="form" method="post" style="position: relative;">
                            <br />
                            <div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                                <input type="text" class="form-control" name="user" value="<?php echo htmlspecialchars($savedUsername); ?>" />
                            </div>
                            <div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                <input type="password" class="form-control" name="pass" value="<?php echo htmlspecialchars($savedPassword); ?>" />
                            </div>
                            <div class="form-group">
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="remember" <?php if ($savedUsername) echo 'checked'; ?> /> Remember me
                                </label>
                            </div>
                            <!-- Link Lupa Password positioned above the login button -->
                            <a href="lupa_password_admin.php" class="btn btn-link forgot-password-link">Lupa Password?</a>
                            <button class="btn btn-primary" name="login">Login</button>
                        </form>
                        <br />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPTS -AT THE BOTTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="assets/js/jquery.metisMenu.js"></script>
    <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>
</body>
</html>
