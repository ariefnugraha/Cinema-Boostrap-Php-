<?php
    $koneksi = mysqli_connect("localhost","root","","bioskop");

    if (! $koneksi) {die("Gagal Terhubung Ke Server");}

    $fname = ucwords($_POST['fname']);
    $lname = ucwords($_POST['lname']);
    $username = $_POST['username'];
    $password = $_POST['password'];
    $encrypt = password_hash($password,PASSWORD_DEFAULT);
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $sex   = $_POST['sex'];

    $cek_email = "SELECT email FROM customer WHERE email LIKE '%$email%'";
    $cek_email_query = mysqli_query($koneksi,$cek_email);

    $cek_username = "SELECT username FROM customer WHERE username Like '%$username%'";
    $cek_username_query = mysqli_query($koneksi,$cek_username);

    if (mysqli_num_rows($cek_email_query) > 0) {
        echo "<script>window.alert('Email Telah Digunakan');</script>";
    } else {
        if (mysqli_num_rows($cek_username_query) > 0) {
            echo "<script>window.alert('Username Telah Digunakan');";
        } else {
            $input = "INSERT INTO customer (id,fname,lname,sex,username,password,email,phone) VALUES (NULL,'$fname','$lname','$sex','$username','$encrypt','$email','$phone')";
            $input_query = mysqli_query($koneksi,$input);

            if ($input_query) {
                echo "
                <script>
                    window.alert('Sukses Membuat Akun');
                    window.location = 'login.php';
                </script>";
            } else {
                echo '<script>window.alert("Gagal Membuat Akun");</script>';
            }
        }
    }
?>