<?php
    $koneksi = mysqli_connect("localhost","root","","bioskop");

    if (! $koneksi) {die("Tidak Bisa Terhubung ke Database");}
    session_start();
    if(isset($_SESSION['username'])) {
        header("location:index.php");
    }
?>
<html>
    <head>
        <link href="bootstrap/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="sign-up.css" rel="stylesheet">
        <script src="bootstrap/bootstrap/js/bootstrap.min.js"></script>
        <script src="fontawesome-free/svg-with-js/js/fontawesome-all.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="utf-8">
        <title>Daftar</title>
    </head>
    <body>
        <wrapper>
            <div class="row">
                <div class="col-md-6 col-xs-12 col-sm-12 col-lg-6 text">
                    <p>Buat akun agar kamu bisa nikmati semua konten disini</p>
                    <p>sudah punya akun ? ayo <a href="login.php">login</a></p>
                </div>
                <div class="col-md-6 col-xs-12 col-sm-12 col-lg-6 fill">
                    <form action="signup-proses.php" method="post" onsubmit="validasi()">
                        <div class="row">
                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-6">
                                <label>Nama depan :</label>
                                <input type="text" id="fname" class="form-control" placeholder="First Name..." name="fname" required>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-6">
                                <label>Nama Belakang :</label>
                                <input type="text" id="lname" class="form-control" placeholder="Last Name..." name="lname">
                            </div>
                        </div>
                        <label><i class="fas fa-user fa-lg"></i> Username :</label>
                        <input type="text" id="username" class="form-control" placeholder="Username..." name="username" maxlength="12" required>
                        <label><i class="fas fa-lock fa-lg"></i> Password :</label>
                        <p class="error" id="match">Password Tidak sama</p>
                        <input type="password" id="password" class="form-control" placeholder="Password" name="password" required>
                        <label><i class="fas fa-lock fa-lg"></i> Retype Password :</label>
                        <input type="password" id="retype" class="form-control" placeholder="Retype Password..." name="retype" required>
                        <label>jenis kelamin :</label>
                        <label><input type="radio" name="sex" value="L"> Laki - laki</label>
                        <label><input type="radio" name="sex" value="P"> Perempuan</label>
                        <label><i class="fas fa-envelope fa-lg"></i> Email :</label>
                        <input type="email" id="email" class="form-control" placeholder="Email.." name="email" required>
                        <label><i class="fas fa-phone fa-lg"></i> telepon</label>
                        <input type="tel" id="phone" class="form-control" name="phone" placeholder="Phone..." required>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </wrapper>
    </body>
</html>