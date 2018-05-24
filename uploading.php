<?php
  // Create database connection
    $servername = "localhost";
    $username   = "root";
    $password   = "";
    $db         = "bioskop";

    $koneksi = mysqli_connect($servername,$username,$password,$db);

    if (! $koneksi) {
        die("Gagal Terhubung Ke Database");
    }

    $title      = ucwords($_POST['judul']);
    $release    = $_POST['rilis'];
    $cast       = ucwords($_POST['artis']);
    $story      = ucfirst($_POST['sinopsis']);
    $trailer    = $_POST['link'];
    $duration   = $_POST['durasi'];
    $category1  = ucwords($_POST['kategori1']);
    $category2  = ucwords($_POST['kategori2']);
    $category3  = ucwords($_POST['kategori3']);
    $restricted = strtoupper($_POST['batas']);
    $country    = ucwords($_POST['negara']);
    $company    = ucwords($_POST['perusahaan']);

    //UNTUK FOTO
    $foto       = $_FILES['image']['name'];
    $size       = $_FILES['image']['size'];
    $type       = $_FILES['image']['type'];
    $tmp        = $_FILES['image']['tmp_name'];
    $allow      = array("jpg","png","jpeg","svg");
    $file_ext   = strtolower(end(explode('.',$_FILES['image']['name'])));
//$save       = "asset/".basename($foto);

    $rename     = $title.$foto;
    $save       = "asset/".$rename;
    
    if ($category1 == $category2 || $category1 == $category3 || $category2 == $category3) {
        echo '
            <script>
                window.alert("Kategori Film Harus Berbeda);
                window.location = "film.php";
            </script>
        ';
    } else {
        if (in_array($file_ext,$allow)) {
        if ($size < 5000000) {
            if (move_uploaded_file($tmp,$save)) {
                $query = "INSERT INTO film (id_film,image,judul,trailer,tgl_rilis,durasi,sinopsis,artis,kategori1,kategori2,kategori3,rating,negara,produksi) VALUES (NULL,'$rename','$title','$trailer','$release','$duration','$story','$cast','$category1','$category2','$category3','$restricted','$country','$company')";
                $query_konek = mysqli_query($koneksi,$query);

                if ($query_konek) {
                    echo "
                        <script>
                            window.alert('Film Berhasil Diupload');
                            window.location = 'film.php';
                        </script>
                    ";
                } else {
                    echo '
                        <script>
                            window.alert("Film Gagal Diupload);
                            window.location = "film.php";
                        </script>
                    ';
                }
                } else {
                    echo "
                        <script>
                            window.alert('Film Gagal Diupload');
                            window.location = 'film.php';
                        </script>
                    ";
                }
            } else {
                echo '
                    <script>
                        window.alert("Ukuran File Gambar Terlalu Besar");
                        window.location = "film.php"
                    </script>
                ';
            }
        } else {
            echo "
                <script>
                    window.alert('Ekstensi Gambar Yang Anda Upload Dilarang. Pastikan Ekstensi Gambar Adalah JPG, JPEG, PNG, SVG);
                    window.location = 'film.php';
                </script>
            ";
        }
    }
    
?>