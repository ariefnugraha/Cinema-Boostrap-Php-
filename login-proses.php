<?php
    $koneksi = mysqli_connect("localhost","root","","bioskop");

    if (! $koneksi) {die("Gagal Terhubung Ke Database");}

    $username   = $_POST['username'];
    $userpass   = $_POST['password_login'];

    //LOGIN USER
    $user      = "SELECT username,email,password FROM customer WHERE username = '$username' OR email = '$username'";
    $user_query = mysqli_query($koneksi,$user);
    
    $row = mysqli_fetch_assoc($user_query);
    $user_password = $row['password'];
    
    if (mysqli_num_rows($user_query) == 1) {
        if(password_verify($userpass,$user_password)) {
            session_start();
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $userpass;
            header("location:home.php");
        } else {
            echo '
                <script>
                    window.alert("Username Atau Password Salah");
                    window.location = "login.php";
                </script>
            ';
        }
    } else {
        //LOGIN KARYAWAN
        $karyawan = "SELECT email,password,id_dpt FROM karyawan WHERE email = '$username' AND password = '$userpass'";
        $karyawan_query = mysqli_query($koneksi,$karyawan);
        $row = mysqli_fetch_assoc($karyawan_query);
        $password = $row['password'];
        $department = $row['id_dpt'];
        
        if (mysqli_num_rows($karyawan_query) == 1) {
            if ($userpass == $password) {
                session_start();
                $_SESSION['username'] = $username;
                $_SESSION['password'] = $userpass;
                $_SESSION['department']   = $department;
                
                if ($department == 744) {
                    header("location:film.php");
                } else if ($department == 432) {
                    header("location:kasir.php");
                } else if ($department ==  903) {
                    header("location:manager.php");
                }
                
            } else {
                echo '
                <script>
                    window.alert("Username Atau Password Salah");
                    window.location = "login.php";
                </script>
                ';
            }
        } else {
            echo '
                <script>
                    window.alert("Username Atau Password Salah");
                    window.location = "login.php";
                </script>
                ';
        }
    }
?> 