<?php
    $koneksi = mysqli_connect("localhost","root","","bioskop");
    if (!$koneksi) {die("Gagal Terhubung Ke Server");}
?>
<!DOCTYPE HTML>
<html>
    <head>
        <link href="bootstrap/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="forgot.css" rel="stylesheet">
        <script src="jquery.js"></script>
        <script src="bootstrap/bootstrap/js/bootstrap.min.js"></script>
        <script src="fontawesome-free/svg-with-js/js/fontawesome-all.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="utf-8">
        <title>Lupa Password</title>
    </head>
    <body>
        <div class="container-fluid">
            <form method="post">
                <h3 id="not-found">Username Atau email tidak ditemukan</h3>
                <label>masukkan username atau email :</label>
                <input type="text" class="form-control" name="user" placeholder="Username Atau Email..." required>
                <label>masukkan password baru :</label>
                <input type="password" class="form-control" placeholder="Password Baru..." name="password" required>
                <label>ulangi password :</label>
                <input type="password" class="form-control" placeholder="Retype..." name="retype" required>
                <button type="submit" name="submit" class="btn btn-primary">ubah password</button>
            </form>
            <?php
                if (isset($_POST['submit'])) {
                    $user= $_POST['user'];
                    $username = "SELECT * FROM customer WHERE username = '$user' OR email = '$user'";
                    $username_query = mysqli_query($koneksi,$username);
                    
                    if (mysqli_num_rows($username_query) < 1) {
                        echo '
                            <script>
                                document.getElementById("not-found").style.display = "block";
                            </script>
                        ';    
                    } else {
                        if ($_POST['password'] != $_POST['retype']) {
                            echo '
                                <script>
                                    window.alert("Password Harus Sama");
                                    window.location = "forgot.php";
                                </script>
                            ';
                        } else {
                            $user = $_POST['user'];
                            $password = $_POST['password'];     
                            $encrypt = password_hash($password,PASSWORD_DEFAULT);
                            $update = "UPDATE customer SET password = '$encrypt' WHERE username = '$user' OR email = '$user'";
                            $update_query = mysqli_query($koneksi,$update);
                            
                            if ($update_query) {
                                echo '
                                    <script>
                                        window.alert("Ubah Password Berhasil");
                                        window.location = "login.php";
                                    </script>
                                ';
                            } else {
                                echo '
                                    <script>
                                        window.alert("Ubah Password Gagal");
                                        window.location = "forgot.php";
                                    </script>
                                ';
                            }
                        } 
                    }
                }
            ?>
        </div>
    </body>
</html>