<?php
    $koneksi = mysqli_connect("localhost","root","","bioskop");
    
    if (! $koneksi) {die("Gagal terhubung ke database");}
    
    session_start();
    if (!isset($_SESSION['username'])) {
        echo '
            <script>
                window.alert("Anda Harus Login Dahulu");
                window.location = "login.php";
            </script>
        ';
    }
    
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];

    if (!isset($_GET['id'])) {
        echo '
            <script>
                window.alert("Anda Harus Memilih Film Dahulu");
                window.location = "index.php";
            </script>
        ';
    }

    $id = $_GET['id'];

    //SALDO USER
    $saldo = "SELECT saldo FROM customer WHERE username = '$username'";
    $saldo_query = mysqli_query($koneksi,$saldo);
    $saldo_row = mysqli_fetch_assoc($saldo_query);

    //JUDUL FILM
    $film = "SELECT judul FROM tayang JOIN film WHERE CURDATE() BETWEEN tanggal_awal AND tanggal_akhir AND film.id_film = '$id'";
    $film_query = mysqli_query($koneksi,$film);

    //NAMA STUDIO
    $studio = "SELECT studio.id as studio_id,nama, harga FROM tayang JOIN film JOIN studio WHERE CURDATE() BETWEEN tanggal_awal AND tanggal_akhir AND film.id_film = '$id' AND tayang.id_studio = studio.id ";
    $studio_query = mysqli_query($koneksi,$studio);
    
    //Jam TAYANG

    #SQL YANG BNR
    $jam = "SELECT jam1,jam2,jam3 FROM tayang JOIN film WHERE tayang.id_film = film.id_film";
    $jam_query = mysqli_query($koneksi,$jam);

    //KURSI TERISI
    $kursi = "SELECT seat from tiket WHERE film_id= '$id'";
    $kursi_query = mysqli_query($koneksi,$kursi);
    $seat = mysqli_fetch_assoc($kursi_query);
?>
<!DOCTYPE HTML>
<html>
    <head>
        <link href="bootstrap/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="order.css" rel="stylesheet">
        <script src="jquery.js"></script>
        <script src="bootstrap/bootstrap/js/bootstrap.min.js"></script>
        <script src="fontawesome-free/svg-with-js/js/fontawesome-all.js"></script>
        <script src="order.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="utf-8">
        <title>Pesan Tiket</title>
        
    </head>
    <body>
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="navbar-header">
                <a class="navbar-brand" href="index.php">Cinema 69</a>
            </div>
            <div class="collapse navbar-collapse" id="menu">
                <ul class="nav navbar-nav">
                    <li><a href="kategori.php">kategori</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <?php
                        if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
                            $name = $_SESSION['username'];
                            $user = "SELECT username,saldo FROM customer WHERE username = '$name' OR email = '$name'";
                            $user_query = mysqli_query($koneksi,$user);
                            if (mysqli_num_rows($user_query) == 1) {
                                $row = mysqli_fetch_assoc($user_query);
                                echo '
                                    <li class="dropdown">
                                        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fas fa-user fa-lg"></i> '.$row['username'].'</a>
                                        <ul class="dropdown-menu">
                                            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> logout</a></li>
                                        </ul>
                                    </li>
                                    <li><p class="saldo"><i class="fas fa-ticket-alt fa-lg"></i> '.$row['saldo'].'</p></li>
                                ';
                            }
                        } 
                    ?>
                </ul>
            </div>
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#menu"><i class="fas fa-bars fa-lg"></i></button>
        </nav>
        <div class="container-fluid">
            <form action="order-proses.php" method="post">
                <?php
                    $film_content = mysqli_fetch_assoc($film_query);
                    $studio_content = mysqli_fetch_assoc($studio_query);
                    $jam_content = mysqli_fetch_assoc($jam_query);
                    $kursi_content = mysqli_fetch_assoc($kursi_query);
                    echo '
                        <label>Judul film :</label>
                        <input type="text" class="form-control" value="'.$film_content['judul'].'" name="film" required readonly>
                        <label>Studio :</label>
                        <input type="text" class="form-control" value="'.$studio_content['nama'].'" name="studio" required readonly>
                        <label>Harga :</label>
                        <input type="text" value="'.$studio_content['harga'].'" class="form-control" name="harga" required readonly>
                        <label>masukkan tanggal :</label>
                        <input type="date" class="form-control" name="tanggal" required>
                        <label>Masukkan jam tayang :</label>
                        <select name="jam" class="form-control" required>
                            <option value="'.$jam_content['jam1'].'">'.$jam_content['jam1'].'</option>
                            <option value="'.$jam_content['jam2'].'">'.$jam_content['jam2'].'</option>
                            <option value="'.$jam_content['jam3'].'">'.$jam_content['jam3'].'</option>
                        </select>
                    ';  
                ?>
                <label>Kursi terisi :</label>
                <?php
                    if (mysqli_num_rows($kursi_query) < 1) {
                        echo '<p id="reserved">Tidak Ada Kursi</p>';
                    } else {
                        echo '<p id="reserved">'.$seat['seat'].'</p>';
                    }
                ?>
                <label>masukkan posisi kursi :</label>
                    <div class="screen">layar</div>
                    <div class="row kursi">
                        <div class="col-md-1 col-sm-1 col-xs-1 col-lg-1">
                            <label><input type="checkbox" name="seat[]" value="A1">A1</label>
                            <label><input type="checkbox" name="seat[]" value="B1">B1</label>
                            <label><input type="checkbox" name="seat[]" value="C1">C1</label>
                            <label><input type="checkbox" name="seat[]" value="D1">D1</label>
                            <label><input type="checkbox" name="seat[]" value="E1">E1</label>
                            <label><input type="checkbox" name="seat[]" value="F1">F1</label>
                        </div>
                        <div class="col-md-1 col-sm-1 col-xs-1 col-lg-1">
                            <label><input type="checkbox" name="seat[]" value="A2">A2</label>
                            <label><input type="checkbox" name="seat[]" value="B2">B2</label>
                            <label><input type="checkbox" name="seat[]" value="C2">C2</label>
                            <label><input type="checkbox" name="seat[]" value="D2">D2</label>
                            <label><input type="checkbox" name="seat[]" value="E2">E2</label>
                            <label><input type="checkbox" name="seat[]" value="F2">F2</label>
                        </div>
                        <div class="col-md-1 col-sm-1 col-xs-1 col-lg-1">
                            <label><input type="checkbox" name="seat[]" value="A3">A3</label>
                            <label><input type="checkbox" name="seat[]" value="B3">B3</label>
                            <label><input type="checkbox" name="seat[]" value="C3">C3</label>
                            <label><input type="checkbox" name="seat[]" value="D3">D3</label>
                            <label><input type="checkbox" name="seat[]" value="E3">E3</label>
                            <label><input type="checkbox" name="seat[]" value="F3">F3</label>
                        </div>
                        <div class="col-md-1 col-sm-1 col-xs-1 col-lg-1">
                            <label><input type="checkbox" name="seat[]" value="A4">A4</label>
                            <label><input type="checkbox" name="seat[]" value="B4">B4</label>
                            <label><input type="checkbox" name="seat[]" value="C4">C4</label>
                            <label><input type="checkbox" name="seat[]" value="D4">D4</label>
                            <label><input type="checkbox" name="seat[]" value="E4">E4</label>
                            <label><input type="checkbox" name="seat[]" value="F4">F4</label>
                        </div>
                        <div class="col-md-1 col-sm-1 col-xs-1 col-lg-1">
                            <label><input type="checkbox" name="seat[]" value="A5">A5</label>
                            <label><input type="checkbox" name="seat[]" value="B5">B5</label>
                            <label><input type="checkbox" name="seat[]" value="C5">C5</label>
                            <label><input type="checkbox" name="seat[]" value="D5">D5</label>
                            <label><input type="checkbox" name="seat[]" value="E5">E5</label>
                            <label><input type="checkbox" name="seat[]" value="F5">F5</label>
                        </div>
                    </div>
                <button type="button" onclick="tes()" id="input" class="btn btn-primary input">Input Kursi</button>
                <label>Kursi yang dipilih :</label>
                <input type="text" class="form-control" id="inputan" required>
                <label>Jumlah Kursi yang dipilih :</label>
                <input type="text" class="form-control" id="jumlah-orang" name="jumlah_kursi" readonly>
                <button type="button" onclick="cek()" class="btn btn-primary cek">cek kursi</button>
                <div id="promo">
                    <label>Masukkan Kode Promo :</label>
                    <input type="text" class="form-control" name="promo" placeholder="Promo...">
                    <button type="submit" class="btn btn-orange" id="submit">Submit</button>
                </div>
            </form>
        </div>
    </body>
</html>