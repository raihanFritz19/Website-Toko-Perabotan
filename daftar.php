<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Daftar</title>
    <link rel="stylesheet" href="admin/assets/css/bootstrap.css">
    <link rel="icon" type="image/png" href="image/LogoTokoCahaya.png"> <!-- Menggantikan Icon Pada Tab Web -->
    <style>
        body {
            background-color: #f0f8ff; /* AliceBlue background */
            font-family: Arial, sans-serif;
        }
        .container-background {
            background-color: #4682b4; /* SteelBlue background */
            padding: 80px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 900px;
            margin: 0 auto;
        }
        .form-container {
            background-color: #ffffff; /* White background */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-group label {
            color: #333;
        }
        .btn-primary {
            background-color: #4682b4;
            border-color: #4682b4;
        }
        .btn-primary:hover {
            background-color: #5a9bd4;
            border-color: #5a9bd4;
        }
        .panel-heading {
            background-color: #4682b4;
            color: white;
            border-radius: 10px 10px 0 0;
        }
    </style>
    <script>
        function validateForm() {
            var nama = document.forms["daftarForm"]["nama"].value;
            var email = document.forms["daftarForm"]["email"].value;
            var telepon = document.forms["daftarForm"]["telepon"].value;
            var namaRegex = /^[a-zA-Z\s]+$/;
            var emailRegex = /^[a-zA-Z]+@[a-zA-Z]+\.[a-zA-Z]+$/;
            var teleponRegex = /^\d{11,12}$/;

            if (!namaRegex.test(nama)) {
                alert("Nama hanya boleh diisi dengan huruf kapital atau huruf kecil.");
                return false;
            }

            if (!emailRegex.test(email)) {
                alert("Email hanya boleh berisi huruf dan harus sesuai dengan pola email yang benar.");
                return false;
            }

            if (!teleponRegex.test(telepon)) {
                alert("Nomor telepon harus terdiri dari 11 atau 12 digit.");
                return false;
            }

            return true;
        }
    </script>
</head>
<body>
    <?php include 'menu.php'; ?>

    <div class="container container-background">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default form-container">
                    <div class="panel-heading">
                        <h3 class="panel-title">Daftar Pelanggan</h3>
                    </div>
                    <div class="panel-body">
                        <form method="post" class="form-horizontal" name="daftarForm" onsubmit="return validateForm()">
                            <div class="form-group">
                                <label class="control-label col-md-3">Nama</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="nama" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Email</label>
                                <div class="col-md-9">
                                    <input type="email" class="form-control" name="email" required pattern="[a-zA-Z]+@[a-zA-Z]+\.[a-zA-Z]+" inputmode="email">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Password</label>
                                <div class="col-md-9">
                                    <input type="password" class="form-control" name="password" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Alamat</label>
                                <div class="col-md-9">
                                    <textarea class="form-control" name="alamat" required></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Telp/HP</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="telepon" required pattern="\d{11,12}" title="Nomor telepon harus terdiri dari 11 atau 12 digit">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-9 col-md-offset-3">
                                    <button class="btn btn-primary" name="daftar">Daftar</button>
                                </div>
                            </div>
                        </form>
                        <?php
                        // jk ada tombol daftar(ditekan tombol daftar)
                        if (isset($_POST["daftar"]))
                        {
                            $nama = $_POST["nama"];
                            $email = $_POST["email"];
                            $password = $_POST["password"];
                            $alamat = $_POST["alamat"];
                            $telepon = $_POST["telepon"];

                            // Validasi nama hanya berisi huruf
                            if (!preg_match("/^[a-zA-Z\s]+$/", $nama)) {
                                echo "<script>alert('Nama hanya boleh diisi dengan huruf kapital atau huruf kecil.');</script>";
                                echo "<script>location='daftar.php';</script>";
                                exit();
                            }

                            // Validasi email hanya berisi huruf dan sesuai pola email
                            if (!preg_match("/^[a-zA-Z]+@[a-zA-Z]+\.[a-zA-Z]+$/", $email)) {
                                echo "<script>alert('Email hanya boleh berisi huruf dan harus sesuai dengan pola email yang benar.');</script>";
                                echo "<script>location='daftar.php';</script>";
                                exit();
                            }

                            // Validasi nomor telepon
                            if (!preg_match("/^\d{11,12}$/", $telepon)) {
                                echo "<script>alert('Nomor telepon harus terdiri dari 11 atau 12 digit.');</script>";
                                echo "<script>location='daftar.php';</script>";
                                exit();
                            }

                            // Cek apakah email sudah digunakan
                            $ambil = $koneksi->query("SELECT * FROM pelanggan WHERE email_pelanggan='$email'");
                            $yangcocok = $ambil->num_rows;
                            if ($yangcocok == 1) {
                                echo "<script>alert('Pendaftaran gagal, email sudah digunakan');</script>";
                                echo "<script>location='daftar.php';</script>";
                            } else {
                                // Query insert ke tabel pelanggan
                                $koneksi->query("INSERT INTO pelanggan (email_pelanggan, password_pelanggan, nama_pelanggan, telepon_pelanggan, alamat_pelanggan) VALUES ('$email', '$password', '$nama', '$telepon', '$alamat')");

                                echo "<script>alert('Pendaftaran sukses, silahkan login');</script>";
                                echo "<script>location='login.php';</script>";
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
