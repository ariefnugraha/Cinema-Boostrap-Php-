<?php
    $koneksi = mysqli_connect("localhost","root","","bioskop");

    if (! $koneksi) {die("Tidak Tersambung Dengan Database");}
    session_start();
    if (isset($_SESSION['username'])) {
        header("location:index.php");
    }     
?>
<!DOCTYPE HTML>
<html>
    <head>
        <link href="bootstrap/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="login.css" rel="stylesheet">
        <script src="fontawesome-free/svg-with-js/js/fontawesome-all.min.js"></script>
        <script src="jquery.js"></script>
        <script src="bootstrap/bootstrap/js/bootstrap.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="utf-8">
        <title>Login</title>
    </head>
    <body>
        <div class="container">
            <form action="login-proses.php" method="post">
                <h3><i class="fas fa-user fa-lg"></i> login</h3>
                <label>Username atau Email :</label>
                <input type="text" name="username" class="input-form" placeholder="Username Or Email..." required>
                <label>Password :</label>
                <input type="password" class="input-form" placeholder="Password..." name="password_login" required>
                <button type="submit"><i class="fas fa-sign-in-alt"></i> login</button>
                <a class="forgot" href="forgot.php">Forgot Password ?</a>
                <hr>
                <p style="font-size:100%;text-align:center">Belum Punya Akun ? Ayo <a href="sign-up.php" style="font-size:100%;">daftar</a></p>
            </form>     
        </div>
    </body>
</html>