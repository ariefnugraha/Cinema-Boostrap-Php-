<?php
    $koneksi = mysqli_connect("localhost","root","","bioskop");
        
    if (! $koneksi) {die("GAGAL TERHUBUNG KE DATABASE");} 
    session_start();

    $soon = "SELECT * FROM film WHERE tgl_rilis BETWEEN DATE_ADD(CURDATE(),INTERVAL 1 DAY) AND DATE_ADD(CURDATE(), INTERVAL 14 DAY) LIMIT 4";
    $rilis = "SELECT * FROM tayang INNER JOIN film WHERE CURDATE() BETWEEN tanggal_awal AND tanggal_akhir AND tayang.id_film = film.id_film";
    //QUERY CADANGAN
    /*SELECT judul, image, jam1,jam2,jam3,nama FROM tayang JOIN FILM JOIN studio WHERE (tayang.id_film = film.id_film AND tayang.id_studio = studio.id) AND CURDATE() BETWEEN tanggal_awal AND tanggal_akhir*/
?>
<!DOCTYPE HTML>
<html>
    <head>
        <link href="bootstrap/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="index.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Itim" rel="stylesheet">
        <script src="jquery.js"></script>
        <script src="bootstrap/bootstrap/js/bootstrap.min.js"></script>
        <script src="fontawesome-free/svg-with-js/js/fontawesome-all.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="utf-8">
        <title>Cinema 69 | The Heaven For Movie Geek</title>
        
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
                            <div class="col-md-10 col-lg-10 col-xs-12 col-sm-12">
                                <input type="text" class="input-form" name="id" placeholder="Cari Film..." required>
                            </div>
                            <div class="col-md-2 col-lg-2 col-xs-12 col-sm-12">
                                <button type="submit" class="btn btn-search"><i class="fas fa-search"></i></button>
                            </div>
                        </form>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">  
                    <?php
                        if (isset($_SESSION['username'])) {
                            $name = $_SESSION['username'];
                            $user = "SELECT username,saldo FROM customer WHERE username = '$name' OR email = '$name'";;
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
                                            <li><a href="logout.php"><i class="fas fa-sign-out-alt fa-lg"></i> Logout</a></li>
                                        </ul>
                                    </li>';
                                }  
                                if ($row['id_dpt'] == 903) {
                                    echo '
                                    <li class="dropdown">
                                        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-user-secret fa-lg"></i> '.$row['name'].'</a>
                                        <ul class="dropdown-menu">
                                            <li><a href="manager.php"><i class="fas fa-home fa-lg"></i> Home</a>
                                            <li><a href="logout.php"><i class="fas fa-sign-out-alt fa-lg"></i> Logout</a></li>
                                        </ul>
                                    </li>';
                                }  
                            }
                        } else {
                            echo '
                                <li><a href="login.php"><i class="fas fa-sign-in-alt fa-lg"></i> login</a></li>
                                <li><a href="sign-up.php"><i class="fas fa-user-plus fa-lg"></i> daftar</a></li>
                            ';
                        }
                    ?>
                </ul>
            </div>
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#menu"><i class="fas fa-bars fa-lg"></i></button>
        </nav>
        <section class="landing">
            <div class="wrapper">
                <h1>Cinema 69</h1>
                <h3>the heaven for movie lovers</h3>
                <a href="javascript:scroll()"><i class="fas fa-ticket-alt"></i> pesan tiket</a>
            </div>
        </section>
        <div class="container-fluid film">
            <section class="now" id="now">
                <h3><i class="fas fa-play fa-lg"></i> now playing</h3>
                <?php
                    $rilis_query = mysqli_query($koneksi,$rilis);
                
                    if (mysqli_num_rows($rilis_query) < 1) {
                        echo "<h3 class='not-found'>Tidak Ada film yang main hari ini";
                    } else {
                        echo "<div class='row'>";
                        while($row = mysqli_fetch_assoc($rilis_query)) {
                            echo '  
                                <div class="col-md-3 col-xs-12 col-sm-6 col-lg-3">
                                    <div class="thumbnail">
                                        <a href="detail.php?id='.$row['id_film'].'"><img src="asset/'.$row['image'].'"></a>
                                        <div class="thumbnail-content">
                                            <a class="title" href="order.php?id='.$row['id_film'].'">'.$row['judul'].'</a> 
                                            <p class="time">'.$row['jam1'].' |</p>
                                            <p class="time">'.$row['jam2'].' |</p>
                                            <p class="time">'.$row['jam3'].'</p>
                                        </div>
                                    </div>
                                </div>
                            ';
                        }
                        
                        echo "</div>";
                    }
                ?>
            </section>
        </div>
        <div id="benefit" class="container-fluid benefit">
            <div class="row">
                <div class="col-md-4 col-xs-12 col-sm-4 col-lg-4 cheap">
                    <h3>Lihat Jadwal Film</h3>
                    <i class="fas fa-calendar-alt fa-4x"></i>
                    <p>Cinema 69 menyediakan tempat untuk kamu melihat jadwal film yang akan tayang dan juga film - film yang akan tayang</p>
                </div>
                <div class="col-md-4 col-xs-12 col-sm-4 col-lg-4 fast">
                    <h3>Cepat</h3>
                    <i class="fas fa-rocket fa-4x"></i>
                    <p>Sekarang, gak perlu lagi pesan tiket bioskop pake ngantri. Karena, aplikasi cinema 69 bisa membuat kamu pesan tiket lebih cepat</p>
                </div>
                <div class="col-md-4 col-xs-12 col-sm-4 col-lg-4 easy">
                    <h3>Akses dimanapun dan kapanpun</h3>
                    <i class="fas fa-map-marker-alt fa-4x"></i>
                    <p>Kamu bisa lihat info tentang film dimanapun dan kapanpun di Cinema 69. Tersedia di berbagai platform PC, Tablet, dan smartphone</p>
                </div>
            </div>
        </div>
        <div class="container-fluid film">
            <section class="soon">
                <h3>coming soon</h3>
                <?php
                    $soon_konek = mysqli_query($koneksi,$soon);
                
                    if (mysqli_num_rows($soon_konek) < 1) {
                        echo "<h3 class='not-found'>Tidak Ada film yang rilis dalam waktu dekat</h3>";
                    } else {
                        echo "<div class='row'>";
                        while ($row = mysqli_fetch_assoc($soon_konek)) {
                            echo '
                                 <div class="col-md-3 col-xs-12 col-sm-6 col-lg-3">
                                    <div class="thumbnail">
                                        <a href="detail.php?id='.$row['id_film'].'"><img src="asset/'.$row['image'].'"></a>
                                    </div>
                                </div>
                            ';
                        }
                        echo "</div>";
                    }
                ?>
            </section>
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
        </div>
        
        <script>
            function scroll() {
                var now = document.getElementById("now");
                now.scrollIntoView({behavior:"smooth"});
            }       
        </script>
    </body>
</html>