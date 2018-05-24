<?php
    $koneksi = mysqli_connect("localhost","root","","bioskop");
    if (! $koneksi) {die("Gagal Terhubung Ke Server");}
    session_start();
?>
<!DOCTYPE HTML>
<html>
    <head>
        <link href="bootstrap/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="kategori.css" rel="stylesheet">
        <script src="jquery.js"></script>
        <script src="bootstrap/bootstrap/js/bootstrap.min.js"></script>
        <script src="fontawesome-free/svg-with-js/js/fontawesome-all.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="utf-8">
        <title>Kategori</title>
        
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
                                            <li><a href="logout.php"><i class="fas fa-sign-out-alt fa-lg"></i> Logout</a></li>
                                        </ul>
                                    </li>';
                                }
                                if ($row['id_dpt'] == 121) {
                                    echo '
                                    <li class="dropdown">
                                        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-user-secret fa-lg"></i> '.$row['name'].'</a>
                                        <ul class="dropdown-menu">
                                            <li><a href="hrd.php"><i class="fas fa-home fa-lg"></i> Home</a>
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
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3 action">
                    <wrapper><h3><a href="kategori-detail.php?name=Action">Action</a></h3></wrapper>
                </div>
                <div class="col-md-3 adventure">
                    <wrapper><h3><a href="kategori-detail.php?name=Adventure">Adventure</a></h3></wrapper>
                </div>
                <div class="col-md-3 animation">
                    <wrapper><h3><a href="kategori-detail.php?name=Animation">Animation</a></h3></wrapper>
                </div>
                <div class="col-md-3 anime">
                    <wrapper><h3><a href="kategori-detail.php?name=Anime">Anime</a></h3></wrapper>
                </div>
                <div class="col-md-3 asia">
                    <wrapper><h3><a href="kategori-detail.php?name=Asia">Asia</a></h3></wrapper>
                </div>
                <div class="col-md-3 biography">
                    <wrapper><h3><a href="kategori-detail.php?name=Biography">Biography</a></h3></wrapper>
                </div>
                <div class="col-md-3 comedy">
                    <wrapper><h3><a href="kategori-detail.php?name=Comedy">comedy</a></h3></wrapper>
                </div>
                <div class="col-md-3 crime">
                    <wrapper><h3><a href="kategori-detail.php?name=Crime">crime</a></h3></wrapper>
                </div>
                <div class="col-md-3 documentary">
                    <wrapper><h3><a href="kategori-detail.php?name=Documentary">documentary</a></h3></wrapper>
                </div>
                <div class="col-md-3 drama">
                    <wrapper><h3><a href="kategori-detail.php?name=Drama">drama</a></h3></wrapper>
                </div>
                <div class="col-md-3 family">
                    <wrapper><h3><a href="kategori-detail.php?name=Family">family</a></h3></wrapper>
                </div>
                <div class="col-md-3 fantasy">
                    <wrapper><h3><a href="kategori-detail.php?name=Fantasy">fantasy</a></h3></wrapper>
                </div>
                <div class="col-md-3 foreign">
                    <wrapper><h3><a href="kategori-detail.php?name=Foreign">foreign</a></h3></wrapper>
                </div>
                <div class="col-md-3 history">
                    <wrapper><h3><a href="kategori-detail.php?name=History">history</a></h3></wrapper>
                </div>
                <div class="col-md-3 horror">
                    <wrapper><h3><a href="kategori-detail.php?name=Horror">horror</a></h3></wrapper>
                </div>
                <div class="col-md-3 musical">
                    <wrapper><h3><a href="kategori-detail.php?name=Musical">musical</a></h3></wrapper>
                </div>
                <div class="col-md-3 mystery">
                    <wrapper><h3><a href="kategori-detail.php?name=Mystery">mystery</a></h3></wrapper>
                </div>
                <div class="col-md-3 romance">
                    <wrapper><h3><a href="kategori-detail.php?name=Romance">romance</a></h3></wrapper>
                </div>
                <div class="col-md-3 sci-fi">
                    <wrapper><h3><a href="kategori-detail.php?name=Sci-fi">Sci-fi</a></h3></wrapper>
                </div>
                <div class="col-md-3 short">
                    <wrapper><h3><a href="kategori-detail.php?name=Short">short</a></h3></wrapper>
                </div>
                <div class="col-md-3 sport">
                    <wrapper><h3><a href="kategori-detail.php?name=Sport">sport</a></h3></wrapper>
                </div>
                <div class="col-md-3 superhero">
                    <wrapper><h3><a href="kategori-detail.php?name=Superhero">superhero</a></h3></wrapper>
                </div>
                <div class="col-md-3 thriller">
                    <wrapper><h3><a href="kategori-detail.php?name=Thriller">thriller</a></h3></wrapper>
                </div>
                <div class="col-md-3 war">
                    <wrapper><h3><a href="kategori-detail.php?name=War">war</a></h3></wrapper>
                </div>
            </div>
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
        </div>
    </body>
</html>