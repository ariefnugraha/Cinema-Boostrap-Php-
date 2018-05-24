<?php
    $koneksi = mysqli_connect("localhost","root","","bioskop");

    if (! $koneksi) {die("Gagal Terhubung Ke Database");}

    session_start();
    if (isset($_SESSION['username'])) {
        $username   = $_SESSION['username'];
        $password   = $_SESSION['password'];
        $department = $_SESSION['department'];
    }

    if (isset($_SESSION['department']) != 744) {
        echo '
            <script>
                window.alert("Anda Tidak Berhak Mengakses Halaman Ini");
                window.location = "login.php";
            </script>
        ';
    }

    $sql = "SELECT id,id_dpt,CONCAT(fname,' ',lname) AS nama,email,password,tgl_rekrut,sex,tgl_lahir,alamat,telepon,pendidikan FROM karyawan WHERE email = '$username'";
    $sql_query = mysqli_query($koneksi,$sql);
?>
<!DOCTYPE HTML>
<html>
    <head>
        <link href="bootstrap/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="kasir.css" rel="stylesheet">
        <script src="jquery.js"></script>
        <script src="bootstrap/bootstrap/js/bootstrap.min.js"></script>
        <script src="fontawesome-free/svg-with-js/js/fontawesome-all.js"></script>
        <script src="kasir.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="utf-8">
        <title>Kasir</title>
    </head>
    <body>
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="navbar-header">
                <a class="navbar-brand" href="index.php">Cinema 69</a>
            </div>
            <div class="collapse navbar-collapse" id="menu">
                <ul class="nav navbar-nav">
                    <li><a href="#">kategori</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">  
                    <?php
                        if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
                            $row = mysqli_fetch_assoc($sql_query);
                            echo '
                                <li class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fas fa-user-secret fa-lg"></i> '.$row['nama'].'</a>
                                    <ul class="dropdown-menu">
                                        <li><a href="logout.php"><i class="fas fa-sign-out-alt fa-lg"></i> logout</a></li>
                                    </ul>
                                </li>
                            ';
                        } else {
                            echo '
                            <li><a href="login.php"><i class="fas fa-sign-in-alt fa-lg"></i> login</a></li>
                            <li><a href="sign-up.php"><i class="fas fa-user-plus fa-lg"></i> signup</a></li>
                            ';
                        }
                        
                    ?>
                </ul>
            </div>
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#menu"><i class="fas fa-bars fa-lg"></i></button>
        </nav>
        <div class="container-fluid">
            <section class="menu">
                <ul class="nav nav-pills nav-justified">
                    <li class="active"><a href="#topup" data-toggle="pill">top up ticket</a></li>
                    <li><a href="#promosi" data-toggle="pill">promosi</a></li>
                </ul>
            </section>
            <section class="tab-content">
                <div id="topup" class="tab-pane fade in active">
                    <form action="topup.php" method="post">
                        <div class="row">
                            <div class="col-md-4">
                                <label>masukkan nominal top up :</label>
                                <select name="nominal" class="form-control" required>
                                    <option value="50000">Rp. 50.000</option>
                                    <option value="100000">Rp. 100.000</option>
                                    <option value="150000">Rp. 150.000</option>
                                    <option value="250000">Rp. 250.000</option>
                                    <option value="500000">Rp. 500.000</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>masukkan username client :</label>
                                <input type="text" class="form-control" name="username" placeholder="Username..." required>
                            </div>
                            <div class="col-md-2">
                                <label>Masukkan Uang client :</label>
                                <input type="text" class="form-control" name="uang" placeholder="Uang Pelanggan..." required>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary btn-md">verifikasi</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div id="promosi" class="tab-pane fade">
                    <form method="post">
                        <label>Masukkan Nama Kode Promo :</label>
                        <input type="text" class="form-control" placeholder="Kode Promo..." name="nama" required>
                        <label>Masukkan Nominal :</label>
                        <input type="number" class="form-control" name="nominal" placeholder="Nominal..." required>
                        <label>Masukkan Tanggal Awal Promosi Berlaku :</label>
                        <input type="date" class="form-control" name="tanggal_awal" required>
                        <label>Masukkan Tanggal Akhir Promosi Berlaku :</label>
                        <input type="date" class="form-control" name="tanggal_akhir" required>
                        <label>Masukkan Deskripsi Promo</label>
                        <textarea class="form-control" name="deskripsi" placeholder="Deskripsi Promosi..." required></textarea>
                        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                    </form>
                    <?php
                        if(isset($_POST['submit'])) {
                            $nama =strtoupper($_POST['nama']);
                            $nominal = $_POST['nominal'];
                            $tanggal_awal = $_POST['tanggal_awal'];
                            $tanggal_akhir = $_POST['tanggal_akhir'];
                            $deskripsi = $_POST['deskripsi'];
                            
                            $insert = "INSERT INTO promo VALUES (NULL,'$nama','$nominal','$tanggal_awal','$tanggal_akhir','$deskripsi')";
                            $insert_query = mysqli_query($koneksi,$insert);
                            if ($insert_query) {
                                echo '
                                    <script>
                                        window.alert("Promosi Berhasil Dibuat");
                                        window.location = "kasir.php";
                                    </script>
                                ';
                            } else {
                                echo '
                                    <script>
                                        window.alert("Promosi Gagal Dibuat");
                                        window.location = "kasir.php";
                                    </script>
                                ';
                            }
                        }
                    ?>
                </div>
            </section>
        </div>
    </body>
</html>