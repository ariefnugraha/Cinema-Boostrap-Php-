<?php
    $koneksi = mysqli_connect("localhost","root","","bioskop");
    if (! $koneksi) {
        die("Gagal terhubung ke server. Silahkan coba lagi");
    } else {
        session_start();
        $title = $_GET['id'];
        $film = "SELECT id_film,image,judul,kategori1,kategori2,kategori3,YEAR(tgl_rilis) as tahun FROM film WHERE judul LIKE '%$title%'";
        $film_query = mysqli_query($koneksi,$film);
    }
?>
<!DOCTYPE HTML>
<html>
    <head>
        <link href="bootstrap/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="result.css" rel="stylesheet">
        <script src="jquery.js"></script>
        <script src="bootstrap/bootstrap/js/bootstrap.min.js"></script>
        <script src="fontawesome-free/svg-with-js/js/fontawesome-all.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="utf-8">
        <title>Pencarian</title>
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
                            $name = $_SESSION['username'];
                            $user = "SELECT username,saldo FROM customer WHERE username = '$name' OR email = '$name'";
                            $user_query = mysqli_query($koneksi,$user);
                            
                            $karyawan = "SELECT CONCAT(fname,' ',lname) AS name, id_dpt FROM karyawan WHERE email = '$name'";
                            $karyawan_query = mysqli_query($koneksi,$karyawan);
                            
                            if (mysqli_num_rows($user_query) == 1) {
                                $row = mysqli_fetch_assoc($user_query);
                                echo '
                                    <li class="dropdown">
                                        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fas  fa-user fa-lg"></i> '.$row['username'].'</a>
                                        <ul class="dropdown-menu">
                                            <li><a href="home.php"><i class="fas fa-home fa-lg"></i>  home</a></li>
                                            <li><a href="logout.php"><i class="fas fa-sign-out-alt fa-lg"></i> logout</a></li>
                                        </ul>
                                    </li>
                                    <li><p><i class="fas fa-ticket-alt fa-lg"></i> '.$row['saldo'].'</p></li>
                                ';
                            }
                            
                            if (mysqli_num_rows($karyawan_query) == 1) {
                                $row = mysqli_fetch_assoc($karyawan_query);
                                if ($row['id_dpt'] == 744) {
                                    echo '
                                    <li class="dropdown">
                                        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-user-secret fa-lg"></i> '.$row['name'].'</a>
                                        <ul class="dropdown-menu">
                                            <li><a href="film.php"><i class="fas fa-home fa-lg"></i> Home</a>
                                            <li><a href="logout.php"><i class="fas fa-sign-out-alt fa-lg"></i> Logout</a></li>
                                        </ul>
                                    </li>';
                                }
                                if ($row['id_dpt'] == 432) {
                                    echo '
                                    <li class="dropdown">
                                        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-user-secret fa-lg"></i> '.$row['name'].'</a>
                                        <ul class="dropdown-menu">
                                            <li><a href="kasir.php"><i class="fas fa-home fa-lg"></i> Home</a>
                                        </ul>
                                    </li>';
                                }
                                if ($row['id_dpt'] == 121) {
                                    echo '
                                    <li class="dropdown">
                                        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-user-secret fa-lg"></i> '.$row['name'].'</a>
                                        <ul class="dropdown-menu">
                                            <li><a href="hrd.php"><i class="fas fa-home fa-lg"></i> Home</a>
                                        </ul>
                                    </li>';  
                                }
                            }
                        } else {
                            echo '
                                <li><a href="login.php"><i class="fas fa-sign-in-alt fa-lg"></i> login</a></li>
                                <li><a href="signup.php"><i class="fas fa-user-plus fa-lg"></i> daftar</a></li>
                            ';
                        }
                    ?>
                </ul>
            </div>
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#menu"><i class="fas fa-bars fa-lg"></i></button>
        </nav>
        <div class="content">
            <?php
                if (mysqli_num_rows($film_query) < 1) {
                    echo '<h3 class="not-found">oops... hasil yang kamu cari tidak ditemukan :(</h3>';
                } else {
                    echo '<div class="row hasil">';
                    while($row = mysqli_fetch_assoc($film_query)) {
                        echo '
                                <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <img src="asset/'.$row['image'].'" class="img-responsive">
                                        </div>
                                        <div class="col-md-10">
                                            <h3><a class="title" href="detail.php?id='.$row['id_film'].'">'.$row['judul'].' ('.$row['tahun'].')</a></h3>
                                            <a class="kategori" href="kategori-detail.php?name='.$row['kategori1'].'">'.$row['kategori1'].'</a> |
                                            <a class="kategori" href="kategori-detail.php?name='.$row['kategori2'].'">'.$row['kategori2'].'</a> | <a class="kategori" href="kategori-detail.php?name='.$row['kategori3'].'">'.$row['kategori3'].'</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        ';
                    }
                    echo '</div>';
                }
            ?>
        </div>
        <div class="footer">
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