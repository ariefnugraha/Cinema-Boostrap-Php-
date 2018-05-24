<?php
    $koneksi = mysqli_connect("localhost","root","","bioskop");
    if (!$koneksi) {die("Gagal terhubung ke server");}

    session_start();
    if (isset($_SESSION['username'])) {
        $username   = $_SESSION['username'];
        $password   = $_SESSION['password'];
        $department = $_SESSION['department'];
    }

    if (isset($_SESSION['department']) != 744) {
        echo '
            <script>
                window.alert("Anda Tidak Berhak Mengakses Halaman Ini Karena Anda Belum Login Sebagai Manager");
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
        <link href="manager.css" rel="stylesheet">
        <script src="jquery.js"></script>
        <script src="bootstrap/bootstrap/js/bootstrap.min.js"></script>
        <script src="fontawesome-free/svg-with-js/js/fontawesome-all.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="utf-8">
        <title>Dashboard Film</title>
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
                        if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
                            $row = mysqli_fetch_assoc($sql_query);
                            echo '
                                <li class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="home.php"><i class="fas fa-user-secret fa-lg"></i> '.$row['nama'].'</a>
                                    <ul class="dropdown-menu">
                                        <li><a href="logout.php"><i class="fas fa-sign-out-alt fa-lg"></i> Logout</a></li>
                                    </ul>
                                </li>
                            ';
                        } 
                    ?>
                </ul>
            </div>
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#menu"><i class="fas fa-bars fa-lg"></i></button>
        </nav>
        <div class="container">
            <ul class="nav nav-pills nav-justified">
                <li class="active"><a data-toggle="pill" href="#overview">overview</a></li>
                <li><a data-toggle="pill" href="#karyawan">daftar karyawan</a></li>
                <li><a href="#tambah">tambah karyawan</a></li>
            </ul>
            <hr>
            <div class="tab-content">
                <div id="overview" class="tab-pane fade in active">
                    <div class="overall">
                        <h3>Overall</h3>
                        <div class="row">
                            <?php
                                $overall = "SELECT SUM(total_harga) + SUM(uang) AS keuntungan FROM tiket JOIN topup WHERE (tiket.tanggal = topup.tanggal) = CURDATE()";
                                $overall_query = mysqli_query($koneksi,$overall);
                                while ($row = mysqli_fetch_assoc($overall_query)) {
                                    if($row['keuntungan'] < 1) {
                                        echo '
                                            <div class="col-md-4">
                                                <div class="panel panel-primary">
                                                    <div class="panel-heading">Jumlah Profit Hari Ini (Film dan Topup)</div>
                                                    <div class="panel-body">Rp. 0</div>
                                                </div>
                                            </div>
                                        ';
                                    } else {
                                        echo '
                                            <div class="col-md-4">
                                                <div class="panel panel-primary">
                                                    <div class="panel-heading">Jumlah Profit Hari Ini</div>
                                                    <div class="panel-body">Rp. '.$row['keuntungan'].'</div>
                                                </div>
                                            </div>
                                        ';
                                    }
                                }
                            
                                //PENDAPATAN PERBULAN
                                $overall_month = "SELECT SUM(total_harga) + SUM(uang) AS keuntungan FROM tiket JOIN topup WHERE (tiket.MONTH(tanggal) = topup.MONTH(tanggal)) = MONTH(CURDATE())";
                                $overall_month_query = mysqli_query($koneksi,$overall_month);
                            
                                //JUMLAH KARYAWAN
                                $karyawan = "SELECT COUNT(id) AS total FROM karyawan";
                                $karyawan_query = mysqli_query($koneksi,$karyawan);
                                while($row = mysqli_fetch_assoc($karyawan_query)) {
                                    echo '
                                        <div class="col-md-4">
                                            <div class="panel panel-primary">
                                                <div class="panel-heading">Jumlah Karyawan</div>
                                                <div class="panel-body">'.$row['total'].'</div>
                                            </div>
                                        </div>
                                    ';
                                }
                            ?>
                        </div>
                    </div>
                    <hr>
                    <div class="film">
                        <h3>film</h3>
                        <div class="row">
                            <?php
                                //JUMLAH PENONTON DAN PENDAPATAN HARI INI
                                $profit_day = "SELECT SUM(jumlah_orang) AS penonton, SUM(total_harga) AS profit FROM tiket WHERE CURDATE() = tanggal";
                                $profit_day_query = mysqli_query($koneksi,$profit_day);
                                while($row = mysqli_fetch_assoc($profit_day_query)) {
                                    if ($row['penonton'] < 1) {
                                        echo '
                                            <div class="col-md-3">
                                                <div class="panel panel-primary">
                                                    <div class="panel-heading">jumlah penonton hari ini</div>
                                                    <div class="panel-body">0</div>
                                                </div>
                                            </div>
                                        ';    
                                    } else {
                                        echo '
                                            <div class="col-md-3">
                                                <div class="panel panel-primary">
                                                    <div class="panel-heading">jumlah penonton hari ini</div>
                                                    <div class="panel-body">'.$row['penonton'].'</div>
                                                </div>
                                            </div>
                                        ';
                                    }
                                    
                                    if ($row['profit'] < 1) {
                                        echo '
                                            <div class="col-md-3">
                                                <div class="panel panel-primary">
                                                    <div class="panel-heading">jumlah profit hari ini</div>
                                                    <div class="panel-body">Rp. 0</div>
                                                </div>
                                            </div>
                                        ';
                                    } else {
                                        echo '
                                            <div class="col-md-3">
                                                <div class="panel panel-primary">
                                                    <div class="panel-heading">jumlah penonton hari ini</div>
                                                    <div class="panel-body">Rp. '.$row['profit'].'</div>
                                                </div>
                                            </div>
                                        ';
                                    }
                                }
                                //JUMLAH PENONTON DAN PENDAPATAN BULAN INI
                                $profit_month = "SELECT SUM(jumlah_orang) AS penonton, SUM(total_harga) AS profit FROM tiket WHERE MONTH(CURDATE()) = MONTH(tanggal)";
                                $profit_month_query = mysqli_query($koneksi,$profit_month);
                                while ($row = mysqli_fetch_assoc($profit_month_query)) {
                                    if ($row['penonton'] < 1) {
                                        echo '
                                            <div class="col-md-3">
                                                <div class="panel panel-primary">
                                                    <div class="panel-heading">jumlah penonton bulan ini</div>
                                                    <div class="panel-body">0</div>
                                                </div>
                                            </div>
                                        ';
                                    } else {
                                        echo '
                                            <div class="col-md-3">
                                                <div class="panel panel-primary">
                                                    <div class="panel-heading">jumlah penonton bulan ini</div>
                                                    <div class="panel-body"> '.$row['penonton'].'</div>
                                                </div>
                                            </div>
                                        ';
                                    } 
                                    
                                    if ($row['profit'] < 1) {
                                        echo '
                                            <div class="col-md-3">
                                                <div class="panel panel-primary">
                                                    <div class="panel-heading">jumlah profit bulan ini</div>
                                                    <div class="panel-body">Rp. 0</div>
                                                </div>
                                            </div>
                                        ';
                                    } else {
                                        echo '
                                            <div class="col-md-3">
                                                <div class="panel panel-primary">
                                                    <div class="panel-heading">jumlah profit bulan ini</div>
                                                    <div class="panel-body">Rp. '.$row['profit'].'</div>
                                                </div>
                                            </div>
                                        ';
                                    }
                                }
                            ?>
                        </div>
                    </div>
                    <hr>
                    <div class="topup">
                        <h3>topup</h3>
                        <div class="row">
                            <?php
                                //JUMLAH TOPUP HARI INI
                                $profit_today = "SELECT COUNT(id) AS banyak, SUM(uang) AS profit FROM topup WHERE tanggal = CURDATE()";
                                $profit_today_query = mysqli_query($koneksi,$profit_today);
                                while($row = mysqli_fetch_assoc($profit_today_query)) {
                                    echo '
                                        <div class="col-md-3">
                                            <div class="panel panel-primary">
                                                <div class="panel-heading">Jumlah Orang Topup Hari Ini</div>
                                                <div class="panel-body">'.$row['banyak'].'</div>
                                            </div>
                                        </div>
                                    ';
                                    if ($row['profit'] < 1) {
                                        echo '
                                            <div class="col-md-3">
                                                <div class="panel panel-primary">
                                                    <div class="panel-heading">Jumlah Profit Topup Hari Ini</div>
                                                    <div class="panel-body">Rp. 0</div>
                                                </div>
                                            </div>
                                        ';
                                    } else {
                                        echo '
                                            <div class="col-md-3">
                                                <div class="panel panel-primary">
                                                    <div class="panel-heading">Jumlah Profit Topup Hari Ini</div>
                                                    <div class="panel-body">'.$row['banyak'].'</div>
                                                </div>
                                            </div>
                                        ';
                                    }
                                }
                                //JUMLAH TOPUP BULAN INI
                                $profit_today = "SELECT COUNT(id) AS banyak, SUM(uang) AS profit FROM topup WHERE MONTH(tanggal) = MONTH(CURDATE())";
                                $profit_today_query = mysqli_query($koneksi,$profit_today);
                                while($row = mysqli_fetch_assoc($profit_today_query)) {
                                    echo '
                                        <div class="col-md-3">
                                            <div class="panel panel-primary">
                                                <div class="panel-heading">Jumlah Orang Topup Bulan Ini</div>
                                                <div class="panel-body">'.$row['banyak'].'</div>
                                            </div>
                                        </div>
                                    ';
                                    if ($row['profit'] < 1) {
                                        echo '
                                            <div class="col-md-3">
                                                <div class="panel panel-primary">
                                                    <div class="panel-heading">Jumlah Profit Topup Bulan Ini</div>
                                                    <div class="panel-body">Rp. 0</div>
                                                </div>
                                            </div>
                                        ';
                                    } else {
                                        echo '
                                            <div class="col-md-3">
                                                <div class="panel panel-primary">
                                                    <div class="panel-heading">Jumlah Profit Topup Bulan Ini</div>
                                                    <div class="panel-body">'.$row['banyak'].'</div>
                                                </div>
                                            </div>
                                        ';
                                    }
                                }
                            ?>
                        </div>
                    </div>
                </div>
                <div id="karyawan" class="tab-pane fade">
                    <form method="post">
                        <div class="row">
                            <div class="col-md-10">
                                <label>Cari Karyawan :</label>
                                <input type="text" class="form-control" placeholder="Cari Karyawan..." name="karyawan" required>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" name="submit" class="btn btn-primary">Cari Karyawan</button>
                            </div>
                        </div>
                    </form>
                    <?php
                        if (!isset($_POST['submit'])) {
                            $karyawan = "SELECT * FROM karyawan ORDER BY fname";
                            $karyawan_query = mysqli_query($koneksi,$karyawan);
                            echo '<div class="table-responsive">
                            <table class="table table-striped">
                                <tr>
                                    <th>ID</th>
                                    <th>ID Departemen</th>
                                    <th>Nama Depan</th>
                                    <th>Nama Belakang</th>
                                    <th>Email</th>
                                    <th>Tanggal Rekrut</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Alamat</th>
                                    <th>Telepon</th>
                                </tr>
                            ';

                            while ($row = mysqli_fetch_assoc($karyawan_query)) {
                                echo '
                                    <tr>
                                        <td>'.$row['id'].'</td>
                                        <td>'.$row['id_dpt'].'</td>
                                        <td>'.$row['fname'].'</td>
                                        <td>'.$row['lname'].'</td>
                                        <td style="text-transform:lowercase;">'.$row['email'].'</td>
                                        <td>'.$row['tgl_rekrut'].'</td>
                                        <td>'.$row['sex'].'</td>
                                        <td>'.$row['tgl_lahir'].'</td>
                                        <td>'.$row['alamat'].'</td>
                                        <td>'.$row['telepon'].'</td>
                                    </tr>   
                                ';
                            }
                            echo "</table></div>";
                        } else if (isset($_POST['submit'])) {
                            $nama = $_POST['karyawan'];
                            $sql = "SELECT * FROM karyawan WHERE fname LIKE '%$nama%' OR lname LIKE '%$nama%'";
                            $query = mysqli_query($koneksi,$sql);
                            if (mysqli_num_rows($query) < 1) {
                                echo '<h3 class="not-found">Karyawan Tidak Ditemukan</h3>';
                            } else {
                                echo '
                                    <div class="table-responsive">
                                        <table class="table table-responsive">
                                            <tr>
                                                <th>ID</th>
                                                <th>ID Departemen</th>
                                                <th>Nama Depan</th>
                                                <th>Nama Belakang</th>
                                                <th>Email</th>
                                                <th>Tanggal Rekrut</th>
                                                <th>Jenis Kelamin</th>
                                                <th>Tanggal Lahir</th>
                                                <th>Alamat</th>
                                                <th>Telepon</th>
                                            </tr>
                                ';
                                while($row = mysqli_fetch_assoc($query)) {
                                    echo '
                                        <tr>
                                            <td>'.$row['id'].'</td>
                                            <td>'.$row['id_dpt'].'</td>
                                            <td>'.$row['fname'].'</td>
                                            <td>'.$row['lname'].'</td>
                                            <td style="text-transform:lowercase;">'.$row['email'].'</td>
                                            <td>'.$row['tgl_rekrut'].'</td>
                                            <td>'.$row['sex'].'</td>
                                            <td>'.$row['tgl_lahir'].'</td>
                                            <td>'.$row['alamat'].'</td>
                                            <td>'.$row['telepon'].'</td>
                                        </tr> 
                                    ';
                                }
                                echo '</table></div>';
                            }
                        }          
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>