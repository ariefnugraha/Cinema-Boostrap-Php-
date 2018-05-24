<?php
    $koneksi = mysqli_connect("localhost","root","","bioskop");

    if (!$koneksi) {die("Gagal Terhubung Ke Database");}

    $title      = ucfirst($_POST['film']);
    $date_first = $_POST['awal'];
    $date_last  = $_POST['akhir'];
    $studio     = ucfirst($_POST['studio']);
    $schedule_1 = $_POST['jam1'];
    $schedule_2 = $_POST['jam2'];
    $schedule_3 = $_POST['jam3'];
    date_default_timezone_set("Asia/Jakarta");
    $time       = date("d m Y", time());

    if ($date_first < $time ) {
        echo "<script>window.alert('Tanggal Main Awal Tidak Boleh Kurang Dari Tanggal Sekarang);</script>";
    }

    $input = "INSERT INTO tayang (id,tanggal_awal,tanggal_akhir,id_film,id_studio,jam1,jam2,jam3) VALUES (NULL,'$date_first','$date_last',$title,$studio,'$schedule_1','$schedule_2','$schedule_3')";
    $insert_query = mysqli_query($koneksi,$input);
    
    if ($insert_query) {
        echo "
            <script>
                window.alert('Jadwal Film Sukses Dibuat');
                window.location = 'film.php';
            </script>
        ";
    } else {
        echo "
            <script>
                window.alert('Jadwal Film Gagal Dibuat');
                window.location = 'film.php';
            </script>
        ";
    }
?>