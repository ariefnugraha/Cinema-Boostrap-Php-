<?php
    $koneksi = mysqli_connect("localhost","root","","bioskop");

    if (! $koneksi) {die("Gagal Terhubung Ke Server");}

    $nominal = $_POST['nominal'];
    $username = $_POST['username'];
    $uang   = $_POST['uang'];
    $kembalian;

    $user = "SELECT * FROM customer WHERE username = '$username'";
    $user_query = mysqli_query($koneksi,$user);

    if (mysqli_num_rows($user_query) == 1) {
        
        $kembalian = $nominal - $uang;
        
        if ($uang < $nominal) {
            echo '
                <script>
                    window.alert("Uang Untuk Bayar Kurang");
                    window.location = "kasir.php";
                </script>
            ';
        } else {
            $update = "UPDATE customer SET saldo = saldo + '$nominal' WHERE username = '$username'";
            $update_query = mysqli_query($koneksi,$update);
            
            $insert = "INSERT INTO topup (id,username,uang) VALUES (NULL,'$username',$nominal)";
            $insert_query = mysqli_query($koneksi,$insert);
            
            if ($update_query && $insert_query) {
                echo '
                    <script>
                        window.alert("Sukses Menambah Saldo Tiket");
                        window.location = "kasir.php";
                    </script>
                ';
            } else {
                echo '
                    <script>
                        window.alert("Gagal Menambah Saldo");
                        window.location = "kasir.php";
                    </script>
                ';
            }   
        }
    } else {
        echo '
            <script>
                window.alert("User Tidak Ditemukan");
                window.location = "kasir.php";
            </script>
        ';
    }
?>