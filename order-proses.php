<?php
    $koneksi = mysqli_connect("localhost","root","","bioskop");

    if (! $koneksi) {die("Gagal Terhubung Ke Database");}
    
    session_start();
    
    $username       = $_SESSION['username'];
    $film           = $_POST['film'];
    $studio         = $_POST['studio'];
    $harga          = $_POST['harga'];
    $tanggal        = $_POST['tanggal'];
    $jam            = $_POST['jam'];
    $seat           = $_POST['seat'];
    $jumlah_kursi   = $_POST['jumlah_kursi'];
    $chk            = "";

    //CEK APAKAH USER NGEINPUT PROMOSI
    if (isset($_POST['promo'])) {
        $promo = $_POST['promo'];
        $sql = "SELECT nominal FROM promo WHERE kode LIKE '%$promo%'";
        $sql_query = mysqli_query($koneksi,$sql);
        if (mysqli_num_rows($sql_query) < 1) {
            echo '
                <script>
                    window.alert("Promo Tidak Ditemukan");
                    window.location = "index.php";
                </script>
            ';
        } else {
            $sql_row = mysqli_fetch_assoc($sql_query);
            $nominal = $sql_row['nominal'];
            $total_harga = ($jumlah_kursi * $harga) - $nominal;
        }
        
    } else {
        $total_harga    = $jumlah_kursi * $harga;   
    }

    //DAPATKAN NAMA USER
    $user = "SELECT username FROM customer WHERE username = '$username' OR email = '$username'";
    $user_query = mysqli_query($koneksi,$user);
    $row_user = mysqli_fetch_assoc($user_query);
    $user_show = $row_user['username'];

    //DAPATKAN ID FILM
    $id_film = "SELECT id_film FROM film WHERE judul = '$film'";
    $id_film_query = mysqli_query($koneksi,$id_film);
    $row_idfilm = mysqli_fetch_assoc($id_film_query);
    $id_film_tampil = $row_idfilm['id_film'];

    //DAPATKAN SALDO USER
    $saldo = "SELECT saldo FROM customer WHERE username = '$username' OR email = '$username'";
    $saldo_query = mysqli_query($koneksi,$saldo);
    while($row = mysqli_fetch_assoc($saldo_query)) {
        $saldo_show = $row['saldo'];
    }

    //DAPATKAN ID STUDIO
    $studio_id = "SELECT id FROM studio WHERE nama = '$studio'";
    $studio_query = mysqli_query($koneksi,$studio_id);
    $row_studio = mysqli_fetch_assoc($studio_query);
    $studio_tampil = $row_studio['id'];

    if ($saldo_show < $total_harga) {
        echo "
            <script>
                window.alert('Maaf Saldo Kamu Kurang');
                window.location('index.php');
            </script>
        ";    
    } else {
        foreach($seat as $chk1) {
            $chk.=$chk1." ";
        }
        
        $insert = "INSERT INTO tiket (id,tanggal,tanggal_tonton,username,film_id,judul,id_studio,nama_studio,seat,jam_tonton,jumlah_orang,harga,total_harga,status) VALUES (NULL,CURRENT_TIMESTAMP,'$tanggal','$user_show','$id_film_tampil','$film','$studio_tampil','$studio','$chk','$jam','$jumlah_kursi','$harga','$total_harga','Ready To Watch')";
        $insert_query = mysqli_query($koneksi,$insert);
        
        if ($insert_query) {
            $update = "UPDATE customer SET saldo = saldo - $total_harga WHERE username = '$user_show' OR email = '$user_show'";
            $update_query = mysqli_query($koneksi,$update);
            if ($update_query) {
                echo '
                    <script>
                        window.alert("Pemesanan Tiket Sukses");
                        window.location = "home.php";
                    </script>
                ';
            } else {
                echo '
                    <script>
                        window.alert("Pengurangan Saldo Gagal. Silahkan Lakukan Pemesanan Ulang");
                        window.location = "index.php";
                    </script>
                ';  
            }
        } else {
            #echo $insert;
            echo '
                <script>
                    window.alert("Pemesanan Tiket Gagal");
                    window.location = "index.php";
                </script>
            ';
        }
    }
?>  