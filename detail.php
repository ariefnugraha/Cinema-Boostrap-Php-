<?php
    $koneksi = mysqli_connect("localhost","root","","bioskop");

    if (! $koneksi) {die("Gagal Terhubung Ke Server");}
    session_start();
    $id      = $_GET['id'];
    $tanggal = date("m/d/y",time()); 
?>
<!DOCTYPE HTML>
<html>
    <head>
        <link href="bootstrap/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="detail.css" rel="stylesheet">
        <script src="jquery.js"></script>
        <script src="bootstrap/bootstrap/js/bootstrap.min.js"></script>
        <script src="fontawesome-free/svg-with-js/js/fontawesome-all.js"></script>
         <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="utf-8">
        <title>
            <?php
                $title = "SELECT judul, YEAR(tgl_rilis) AS tahun FROM film WHERE id_film='$id'";
                $title_query = mysqli_query($koneksi,$title);
                $title_hasil = mysqli_fetch_assoc($title_query);
                echo $title_hasil['judul'],'&nbsp;','('.$title_hasil['tahun'].')';           
            ?>
        </title>
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
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fas fa-user fa-lg"></i> '.$row['username'].'</a>
                                        <ul class="dropdown-menu">
                                            <li><a href="home.php"><i class="fas fa-home fa-lg"></i> home</a></li>
                                            <li><a href="logout.php"><i class="fas fa-sign-out-alt fa-lg"></i> logout</a><li>
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
        <div class="container-fluid">
            <?php
                $film = "SELECT * FROM film WHERE id_film = '$id'";
                $film_query = mysqli_query($koneksi,$film);
                $row = mysqli_fetch_assoc($film_query);
            ?>
            <div class="row">
                <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
                    <?php
                        echo '
                            <div class="thumbnail">
                                <img src="asset/'.$row['image'].'" class="img-responsive">
                            </div>
                        ';
                    ?>
                </div>
                <div class="col-md-7 col-lg-7 col-sm-12 col-xs-12">
                    <?php
                        echo '
                            <h3>'.$title_hasil['judul'].' ('.$title_hasil['tahun'].')</h3> 
                            <p><a class="kategori" href="kategori-detail.php?name='.$row['kategori1'].'">'.$row['kategori1'].'</a> | <a class="kategori" href="kategori-detail.php?name='.$row['kategori2'].'">'.$row['kategori2'].'</a> | <a class="kategori" href="kategori-detail.php?name='.$row['kategori3'].'">'.$row['kategori3'].'</a> | '.$row['rating'].' | '.$row['durasi'].' menit</p>
                            <label>tanggal rilis</label>
                            <p>'.$row['tgl_rilis'].'</p>
                            <label>sinopsis</label>
                            <p>'.$row['sinopsis'].'</p>
                            <label>pemain</label>
                            <p>'.$row['artis'].'</p>
                            <label>negara</label>
                            <p>'.$row['negara'].'</p>
                            <label>produksi</label>
                            <p>'.$row['produksi'].'</label>
                        ';
                    ?>
                </div>
            </div>
            <ul class="nav nav-pills nav-justified">
                <li class="active"><a data-toggle="pill" href="#trailer">trailer</a></li>
            </ul>
            <div class="tab-content">
                <div id="trailer" class="tab-pane fade in active">
                    <embed src="<?php echo $row['trailer']?>">
                </div>
            </div>
        </div>
    </body>
</html>