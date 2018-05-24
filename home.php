<?php
    $koneksi = mysqli_connect("localhost","root","","bioskop");

    if (! $koneksi) {die("Gagal Terhubung Ke Database");}

    session_start();
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];
    $hasil = "SELECT * FROM customer WHERE username LIKE '%$username%' OR email LIKE '%$username%'";
    $hasil_query = mysqli_query($koneksi,$hasil);
    if ($_SESSION['username'] == " ") {
        echo '
            <script>
                window.alert("Anda Harus Login Terlebih Dahulu");
                window.location = "login.php";
            </script>
        ';
    }

    //DAPETIN USERNAME USER
    $name = $_SESSION['username'];
    $user = "SELECT username,saldo FROM customer WHERE username = '$name' OR email = '$name'";
    $user_query = mysqli_query($koneksi,$user);
    $user_row = mysqli_fetch_assoc($user_query);
?>
<!DOCTYPE HTML>
<html>
    <head>
        <link href="bootstrap/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="home.css" rel="stylesheet">
        <script src="jquery.js"></script>
        <script src="bootstrap/bootstrap/js/bootstrap.min.js"></script>
        <script src="fontawesome-free/svg-with-js/js/fontawesome-all.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="utf-8">
        <title>Home</title>
        
    </head>
    <body>
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="navbar-header">
                <a class="navbar-brand" href="index.php">Cinema 69</a>
            </div>
            <div class="collapse navbar-collapse" id="menu">
                <ul class="nav navbar-nav">
                    <li><a href="kategori.php">kategori</a></li>
                    <li class="search">
                        <form action="result.php" method="get">
                            <div class="col-md-10">
                                <input type="text" class="input-form" name="id" placeholder="Cari Film..." required>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-search"><i class="fas fa-search"></i></button>
                            </div>
                        </form>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">  
                    <?php
                        if (isset($_SESSION['username'])) {                    
                            $karyawan = "SELECT CONCAT(fname,' ',lname) AS name, id_dpt FROM karyawan WHERE email = '$name'";
                            $karyawan_query = mysqli_query($koneksi,$karyawan);
                            
                            if (mysqli_num_rows($user_query) == 1) {
                                echo '
                                    <li class="dropdown">
                                        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fas fa-user fa-lg"></i> '.$user_row['username'].'</a>
                                        <ul class="dropdown-menu">
                                            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> logout</a></li>
                                        </ul>
                                    </li>
                                    <li><p class="saldo"><i class="fas fa-ticket-alt fa-lg"></i> '.$user_row['saldo'].'</p></li>
                                ';
                            }
                        } else {
                            echo '
                                <script>
                                    window.alert("Anda Harus Login Terlebih Dahulu");
                                    window.location = "login.php";
                                </script>
                            ';
                        }
                    ?>
                </ul>
            </div>
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#menu"><i class="fas fa-bars fa-lg"></i></button>
        </nav>

        <div class="container-fluid">
            <ul class="nav nav-pills nav-justified">
                <li class="active"><a data-toggle="pill" href="#transaction"><i class="fas fa-ticket-alt fa-lg"></i> tiket berlaku</a></li>
                <li><a data-toggle="pill" href="#expire"><i class="fas fa-sync fa-lg"></i> histori tiket</a></li>
                <li><a data-toggle="pill" href="#promosi"><i class="fas fa-cut fa-lg"></i> promosi</a></li>
                <li><a data-toggle="pill" href="#topup"><i class="fas fa-dollar-sign fa-lg"></i> topup</a></li>
                <li><a data-toggle="pill" href='#setting'><i class="fas fa-cog fa-lg"></i> Settings</a></li>
            </ul>
            <div class="tab-content">
                <div id="transaction" class="tab-pane fade in active">
                    <?php
                        $username = $user_row['username'];
                        $transaksi = "SELECT * FROM tiket  where (tanggal_tonton >= CURDATE()) AND username = '$username'";
                        $transaksi_query = mysqli_query($koneksi,$transaksi);
                    
                        if (mysqli_num_rows($transaksi_query) < 1) {
                            echo "
                            <h3 style='text-align:center;'>Tidak Ada Data</h3>
                            <p style='text-align:center;'>ayo mulai pesan tiket</p>
                            <a href='index.php' class='btn-primary'>Pesan tiket</a>
                            ";
                        } else {
                            echo "
                            <div class='row'>
                            ";
                            while ($row = mysqli_fetch_assoc($transaksi_query)) {
                                echo '
                                    <div class="col-md-6 col-xs-12 col-sm-12 col-lg-6">
                                        <div class="transaction-content">
                                            <h3>'.$row['judul'].'</h3>
                                            <hr>
                                            <div class="row info">
                                                <div class="col-md-2 col-xs-6 col-sm-6 col-lg-2">
                                                    <p><b>Tanggal</b></p>
                                                    <p>'.$row['tanggal_tonton'].'</p>
                                                </div>
                                                <div class="col-md-2 col-xs-6 col-sm-6 col-lg-2">
                                                    <p><b>Studio</b></p>
                                                    <p>'.$row['nama_studio'].'</p>
                                                </div>
                                                <div class="col-md-2 col-xs-6 col-sm-6 col-lg-2">
                                                    <p><b>kursi</b></p>
                                                    <p>'.$row['seat'].'</p>
                                                </div>
                                                <div class="col-md-2 col-xs-6 col-sm-6 col-lg-2">
                                                    <p><b>jam</b></p>
                                                    <p>'.$row['jam_tonton'].'</p>
                                                </div>
                                                <div class="col-md-2 col-xs-6 col-sm-6 col-lg-2">
                                                    <p><b>Jumlah orang</b></p>
                                                    <p>'.$row['jumlah_orang'].'</p>
                                                </div>
                                                <div class="col-md-2 col-xs-6 col-sm-6 col-lg-2">
                                                    <p><b>Harga</b></p>
                                                    <p>'.$row['total_harga'].'</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                ';
                            }
                            echo "</div>";    
                        }
                    ?>
                </div>
                <div id="expire" class="tab-pane fade">
                    <?php
                        $username = $user_row['username'];
                        $expire = "SELECT * FROM tiket WHERE tanggal_tonton < CURDATE() AND username = '$username'";
                        $expire_query = mysqli_query($koneksi,$expire);
                        if (mysqli_num_rows($expire_query) < 1) {
                            echo '<h3 style="text-align:center;">Tidak Ada Data</h3>';
                        } else {
                            echo '<div class="row">';
                            while ($row = mysqli_fetch_assoc($expire_query)) {
                                echo '
                                    <div class="expire-content col-md-6 col-xs-12 col-sm-12 col-lg-6">
                                        <div class="row">
                                            <div class="col-md-6 col-lg-6 col-xs-6 col-sm-6">
                                                <p class="title">'.$row['judul'].'</p>
                                            </div>
                                            <div class="col-md-6 col-lg-6 col-xs-6 col-sm-6">
                                                <p class="price">Rp. '.$row['total_harga'].'</p>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row" style="text-align:center;">
                                            <div class="col-md-3 col-lg-3 col-xs-6 col-sm-6">
                                                <p><b>Tanggal</b></p>
                                                <p>'.$row['tanggal_tonton'].'</p>
                                            </div>
                                            <div class="col-md-3 col-lg-3 col-xs-6 col-sm-6">
                                                <p><b>studio</b></p>
                                                <p>'.$row['nama_studio'].'</p>
                                            </div>
                                            <div class="col-md-3 col-lg-3 col-xs-6 col-sm-6">
                                                <p><b>kursi</b></p>
                                                <p>'.$row['seat'].'</p>
                                            </div>
                                            <div class="col-md-3 col-lg-3 col-xs-6 col-sm-6">
                                                <p><b>jam</b></p>
                                                <p>'.$row['jam_tonton'].'</p>
                                            </div>
                                        </div>
                                    </div>
                                ';
                            }
                            echo '</div>';    
                        }            
                    ?>
                </div>
                <div id="promosi" class="tab-pane fade">
                    <?php
                        $promosi = "SELECT * FROM promo WHERE CURDATE() BETWEEN tanggal_awal AND tanggal_akhir";
                        $promosi_query = mysqli_query($koneksi,$promosi);
                        if(mysqli_num_rows($promosi_query) < 1) {
                            echo '<h3 style="text-align:center;">Tidak Ada Promosi :(</h3>';
                        } else {
                            echo '<div class="row">';
                            while($row = mysqli_fetch_assoc($promosi_query)) {
                                echo '
                                    <div class="col-md-3 col-lg-3 col-xs-12 col-sm-12">
                                        <div class="panel panel-default">
                                            <div class="panel-heading"><h3>'.$row['kode'].'</h3></div>
                                            <div class="panel-body">
                                                <h4>Rp. '.$row['nominal'].'</h4>
                                                <p>'.$row['tanggal_awal'].' s/d '.$row['tanggal_akhir'].'</p>
                                                <p>'.$row['deskripsi'].'</p>
                                            </div>
                                        </div>
                                    </div>
                                ';
                            }
                            echo '</div>';
                        }
                    ?>
                </div>
                <div id="topup" class="tab-pane fade">
                    <?php
                        $topup = "SELECT * FROM topup WHERE username = '$username'";
                        $topup_query = mysqli_query($koneksi,$topup);
                        if (mysqli_num_rows($topup_query) < 1) {
                            echo "
                            <h3>Tidak ada transaksi topup tiket</h3>
                            <p style='text-align:center;'>Silahkan lakukan topup tiket di bioskop</p>
                            ";
                        } else {
                            echo '
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <tr>
                                            <th>Tanggal Transaksi</th>
                                            <th>Nominal</th>
                                        </tr>
                            ';
                            while ($row = mysqli_fetch_assoc($topup_query)) {
                                echo '
                                    <tr>
                                        <td>'.$row['tanggal'].'</td>
                                        <td>'.$row['uang'].'</td>
                                    </tr>
                                ';
                            }
                            
                            echo '</table></div>';
                        }
                    ?>
                </div>
                <div id="setting" class="tab-pane fade">
                    <form method="post">
                        <label>Ubah Password :</label>
                        <input type="password" name="password" class="form-control" placeholder="Ubah Password..."> 
                        <label>Retype Password :</label>
                        <input type="password" name="retype" class="form-control" placeholder="Retype...">
                        <button type="submit" name="submit" class="btn btn-primary">Ubah</button>
                    </form>
                    
                    <?php
                        if(isset($_POST['submit'])) {
                            if(isset($_POST['password']) && isset($_POST['retype'])) {
                                $username = $_SESSION['username'];
                                $password = $_POST['password'];
                                $retype = $_POST['retype'];
                                $hash = password_hash($password,PASSWORD_DEFAULT);
                                
                                if ($password == $retype) {
                                    $update_password = "UPDATE customer SET password = '$hash' WHERE username = '$username'";
                                    $password_query = mysqli_query($koneksi,$update_password);
                                    if ($password_query) {
                                        echo '
                                            <script>
                                                window.alert("Password Berhasil Diupdate");
                                                window.location = "home.php";
                                            </script>
                                        ';
                                    } else {
                                        echo '
                                            <script>
                                                window.alert("Password Gagal Diupdate");
                                                window.location = "home.php";
                                            </script>
                                        ';
                                    }
                                } else {
                                    echo '
                                        <script>
                                            window.alert("Password Harus Sama");
                                            window.location = "home.php";
                                        </script>
                                    ';
                                }
                            }                        
                        }
                    ?>
                </div>
            </div>
        </div>
        <div class="container-fluid footer">
            <div class="row">
                <div class="col-md-6 col-xs-12 col-sm-6">
                    <div class="row sitemap">
                        <div class="col-md-4 col-xs-12 col-sm-4">
                            <p class="title">cinema 69s</p>
                            <a href="#">about us</a>
                            <a href="#">contact</a>
                            <a href="#">jobs</a>
                        </div>
                        <div class="col-md-4 col-xs-12 col-sm-4">
                            <p class="title">customers</p>
                            <a href="#">Customer Service</a>
                            <a href="#">FAQ</a>
                        </div>
                        <div class="col-md-4 col-xs-12 col-sm-4">
                            <p class="title">legal</p>
                            <a href="#">terms of service</a>
                            <a href="#">privacy policy</a>
                        </div>
                    </div>    
                </div>
                <div class="col-md-6 col-xs-12 col-sm-6">
                    <div class=" col-md-6 col-xs-12 address">
                        <p><i class="fas fa-map-marker-alt fa-lg"></i> fakultas teknologi informasi gedung r universitas tarumanagara. Jl. s parman jakarta barat</p>
                    </div>
                    <div class="col-md-6 col-xs-12 socmed">
                        <a href="#"><i class="fab fa-facebook-square fa-2x"></i></a>
                        <a href="#"><i class="fab fa-instagram fa-2x"></i></a>
                        <a href="#"><i class="fab fa-twitter fa-2x"></i></a>
                        <a href="#"><i class="fab fa-youtube fa-2x"></i></a>
                    </div>
                </div>
            </div>
        </footer>
    </body>
</html>