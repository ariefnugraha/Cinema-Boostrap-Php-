<?php
    $koneksi = mysqli_connect("localhost","root","","bioskop");
    
    if (! $koneksi) {die("GAGAL TERHUBUNG KE DATABASE");}

    session_start();
    if (isset($_SESSION['username'])) {
        $username   = $_SESSION['username'];
        $password   = $_SESSION['password'];
        $department = $_SESSION['department'];
    }

    if (isset($_SESSION['department']) != 744) {
        echo '
            <script>
                window.alert("Anda Tidak Berhak Mengakses Halaman Ini Karena Anda Bukan Di Bagian Film Management");
                window.location = "login.php";
            </script>
        ';
    }

    $sql = "SELECT id,id_dpt,CONCAT(fname,' ',lname) AS nama,email,password,tgl_rekrut,sex,tgl_lahir,alamat,telepon,pendidikan FROM karyawan WHERE email = '$username'";
    $sql_query = mysqli_query($koneksi,$sql);
?>
<!DOCTYPE HTML>
<html>
    <head>
        <link href="bootstrap/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="film.css" rel="stylesheet">
        <script src="jquery.js"></script>
        <script src="bootstrap/bootstrap/js/bootstrap.min.js"></script>
        <script src="fontawesome-free/svg-with-js/js/fontawesome-all.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="utf-8">
        <title>Dashboard Film</title>
    </head>
    <body>
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="navbar-header">
                <a class="navbar-brand" href="index.php">Cinema 69</a>
            </div>
            <div class="collapse navbar-collapse" id="menu">
                <ul class="nav navbar-nav">
                    <li><a href="kategori.php">kategori</a></li>
                    <li class="search">
                        <form action="result.php" method="get">
                            <div class="col-md-10">
                                <input type="text" class="input-form" name="id" placeholder="Cari Film..." required>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-search"><i class="fas fa-search"></i></button>
                            </div>
                        </form>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">  
                    <?php
                        if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
                            $row = mysqli_fetch_assoc($sql_query);
                            echo '
                                <li class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="home.php"><i class="fas fa-user-secret fa-lg"></i> '.$row['nama'].'</a>
                                    <ul class="dropdown-menu">
                                        <li><a href="logout.php"><i class="fas fa-sign-out-alt fa-lg"></i> Logout</a></li>
                                    </ul>
                                </li>
                            ';
                        } 
                    ?>
                </ul>
            </div>
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#menu"><i class="fas fa-bars fa-lg"></i></button>
        </nav>
        <div class="menu">
            <?php
                date_default_timezone_set("Asia/Jakarta");        
                echo date("H:i:s",time());
                echo "<br>";
                echo date("l , d M Y", time());
                echo date("");
            ?>
            <ul class="nav nav-pills nav-justified">
                <li class="active"><a data-toggle="pill" href="#tayang">Sedang Tayang</a></li>
                <li><a data-toggle="pill" href="#upload">Upload Film</a></li>
                <li><a data-toggle="pill" href="#rilis">buat jadwal film</a></li>
            </ul>
        </div>
        <div class="tab-content">
            <div id="tayang" class="tab-pane fade in active">
                <?php
                    $tayang = "SELECT judul,tayang.id_film as ID,CONCAT(DATE_FORMAT(tanggal_awal,'%d%-%c%-%Y'),' ','S/D',' ',DATE_FORMAT(tanggal_akhir,'%d%-%c%-%Y')) as jadwal_main, CONCAT(DATE_FORMAT(jam1,'%H%:%i'),' ','|',' ',DATE_FORMAT(jam2,'%H%:%i'),' ' ,'|',' ',DATE_FORMAT(jam3,'%H%:%i')) AS jam_tayang, nama, tayang.id_studio as ID_STUDIO FROM tayang JOIN film JOIN studio WHERE CURDATE() BETWEEN tanggal_awal AND tanggal_akhir AND tayang.id_film = film.id_film AND tayang.id_studio = studio.id";
                    $tayang_query = mysqli_query($koneksi,$tayang);
                    
                    echo '<div class="table-responsive">
                            <table class="table table-striped">
                                <tr>
                                    <th>Id Film</th>
                                    <th>Judul FIlm</th>
                                    <th>Tanggal Main</th>
                                    <th>Jam Tayang</th>
                                    <th>Id Studio</th>
                                    <th>Studio</th>
                                </tr>
                    ';
                
                    while ($row = mysqli_fetch_assoc($tayang_query)) {
                        echo '
                            <tr>
                                <td>'.$row['ID'].'</td>
                                <td><a href="detail.php?id='.$row['ID'].'">'.$row['judul'].'</a></td>
                                <td>'.$row['jadwal_main'].'</td>
                                <td>'.$row['jam_tayang'].'</td>
                                <td>'.$row['ID_STUDIO'].'</td>
                                <td>'.$row['nama'].'</td>
                            </tr>   
                        ';
                    }
                    echo "</table></div>";
                
                ?>
            </div>
            <div id="upload" class="tab-pane fade">
                <form action="uploading.php" method="post" enctype="multipart/form-data">
                    <label>Masukkan Judul film :</label>
                    <input type="text" class="form-control" name="judul" placeholder="Judul Film..." required>
                    <label>Masukkan poster film :</label>
                    <input type="file" name="image" required>
                    <label>masukkan tanggal rilis :</label>
                    <input type="date" class="form-control" name="rilis" required>
                    <label>Masukkan nama pemain :</label>
                    <textarea class="form-control" name="artis" placeholder="Nama Pemain..." required></textarea>
                    <label>masukkan sinopsis :</label>
                    <textarea class="form-control" style="resize:vertical;" name="sinopsis" placeholder="Sinopsis..." required></textarea>
                    <label>masukkan link trailer film :</label>
                    <input type="url" class="form-control" name="link" placeholder="Link Trailer..." required>
                    <label>masukkan durasi film (dalam menit) :</label>
                    <input type="number" class="form-control" placeholder="Durasi Film..." name="durasi" required>
                    <label>masukkan kategori film :</label>
                    <select class="form-control" name="kategori1" required>
                        <option value="Action">Action</option>
                        <option value="Adventure">Adventure</option>
                        <option value="Animation">Animation</option>
                        <option value="Anime">Anime</option>
                        <option value="Asia">Asia</option>
                        <option value="Biography">Biography</option>
                        <option value="Comedy">Comedy</option>
                        <option value="Crime">Crime</option>
                        <option value="Documentary">Documentary</option>
                        <option value="Drama">Drama</option>
                        <option value="Family">Family</option>
                        <option value="Fantasy">Fantasy</option>
                        <option value="Foreign">Foreign</option>
                        <option value="History">History</option>
                        <option value="Horror">Horror</option>
                        <option value="Musical">Musical</option>
                        <option value="Mystery">Mystery</option>
                        <option value="Romance">Romance</option>
                        <option value="Sci-Fi">Sci-fi</option>
                        <option value="Short">Short</option>
                        <option value="Sport">Sport</option>
                        <option value="Superhero">Superhero</option>
                        <option value="Thriller">Thriller</option>
                        <option value="War">War</option>
                    </select>
                    <label>Masukkan kategori film :</label>
                    <select class="form-control" name="kategori2">
                        <option value="Action">Action</option>
                        <option value="Adventure">Adventure</option>
                        <option value="Animation">Animation</option>
                        <option value="Anime">Anime</option>
                        <option value="Asia">Asia</option>
                        <option value="Biography">Biography</option>
                        <option value="Comedy">Comedy</option>
                        <option value="Crime">Crime</option>
                        <option value="Documentary">Documentary</option>
                        <option value="Drama">Drama</option>
                        <option value="Family">Family</option>
                        <option value="Fantasy">Fantasy</option>
                        <option value="Foreign">Foreign</option>
                        <option value="History">History</option>
                        <option value="Horror">Horror</option>
                        <option value="Musical">Musical</option>
                        <option value="Mystery">Mystery</option>
                        <option value="Romance">Romance</option>
                        <option value="Sci-Fi">Sci-fi</option>
                        <option value="Short">Short</option>
                        <option value="Sport">Sport</option>
                        <option value="Superhero">Superhero</option>
                        <option value="Thriller">Thriller</option>
                        <option value="War">War</option>
                    </select>
                    <label>masukkan kategori film :</label>
                    <select class="form-control" name="kategori3">
                        <option value="Action">Action</option>
                        <option value="Adventure">Adventure</option>
                        <option value="Animation">Animation</option>
                        <option value="Anime">Anime</option>
                        <option value="Asia">Asia</option>
                        <option value="Biography">Biography</option>
                        <option value="Comedy">Comedy</option>
                        <option value="Crime">Crime</option>
                        <option value="Documentary">Documentary</option>
                        <option value="Drama">Drama</option>
                        <option value="Family">Family</option>
                        <option value="Fantasy">Fantasy</option>
                        <option value="Foreign">Foreign</option>
                        <option value="History">History</option>
                        <option value="Horror">Horror</option>
                        <option value="Musical">Musical</option>
                        <option value="Mystery">Mystery</option>
                        <option value="Romance">Romance</option>
                        <option value="Sci-Fi">Sci-fi</option>
                        <option value="Short">Short</option>
                        <option value="Sport">Sport</option>
                        <option value="Superhero">Superhero</option>
                        <option value="Thriller">Thriller</option>
                        <option value="War">War</option>
                    </select>
                    <label>masukkan batasan film :</label>
                    <select class="form-control" name="batas">
                        <option value="BO">Bimbingan Orang Tua</option>
                        <option value="R">Remaja</option>
                        <option value="D">Dewasa</option>
                        <option value="SU">Semua Umur</option>
                    </select>
                    <label>masukkan Negara :</label>
                    <select class="form-control" name="negara" required>
                        <option value="Afghanistan">Afghanistan</option>
                        <option value="Albania">Albania</option>
                        <option value="Algeria">Algeria</option>
                        <option value="American Samoa">American Samoa</option>
                        <option value="Andorra">Andorra</option>
                        <option value="Angola">Angola</option>
                        <option value="Anguilla">Anguilla</option>
                        <option value="Antartica">Antarctica</option>
                        <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                        <option value="Argentina">Argentina</option>
                        <option value="Armenia">Armenia</option>
                        <option value="Aruba">Aruba</option>
                        <option value="Australia">Australia</option>
                        <option value="Austria">Austria</option>
                        <option value="Azerbaijan">Azerbaijan</option>
                        <option value="Bahamas">Bahamas</option>
                        <option value="Bahrain">Bahrain</option>
                        <option value="Bangladesh">Bangladesh</option>
                        <option value="Barbados">Barbados</option>
                        <option value="Belarus">Belarus</option>
                        <option value="Belgium">Belgium</option>
                        <option value="Belize">Belize</option>
                        <option value="Benin">Benin</option>
                        <option value="Bermuda">Bermuda</option>
                        <option value="Bhutan">Bhutan</option>
                        <option value="Bolivia">Bolivia</option>
                        <option value="Bosnia and Herzegowina">Bosnia and Herzegowina</option>
                        <option value="Botswana">Botswana</option>
                        <option value="Bouvet Island">Bouvet Island</option>
                        <option value="Brazil">Brazil</option>
                        <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
                        <option value="Brunei Darussalam">Brunei Darussalam</option>
                        <option value="Bulgaria">Bulgaria</option>
                        <option value="Burkina Faso">Burkina Faso</option>
                        <option value="Burundi">Burundi</option>
                        <option value="Cambodia">Cambodia</option>
                        <option value="Cameroon">Cameroon</option>
                        <option value="Canada">Canada</option>
                        <option value="Cape Verde">Cape Verde</option>
                        <option value="Cayman Islands">Cayman Islands</option>
                        <option value="Central African Republic">Central African Republic</option>
                        <option value="Chad">Chad</option>
                        <option value="Chile">Chile</option>
                        <option value="China">China</option>
                        <option value="Christmas Island">Christmas Island</option>
                        <option value="Cocos Islands">Cocos (Keeling) Islands</option>
                        <option value="Colombia">Colombia</option>
                        <option value="Comoros">Comoros</option>
                        <option value="Congo">Congo</option>
                        <option value="Congo">Congo, the Democratic Republic of the</option>
                        <option value="Cook Islands">Cook Islands</option>
                        <option value="Costa Rica">Costa Rica</option>
                        <option value="Cota D'Ivoire">Cote d'Ivoire</option>
                        <option value="Croatia">Croatia (Hrvatska)</option>
                        <option value="Cuba">Cuba</option>
                        <option value="Cyprus">Cyprus</option>
                        <option value="Czech Republic">Czech Republic</option>
                        <option value="Denmark">Denmark</option>
                        <option value="Djibouti">Djibouti</option>
                        <option value="Dominica">Dominica</option>
                        <option value="Dominican Republic">Dominican Republic</option>
                        <option value="East Timor">East Timor</option>
                        <option value="Ecuador">Ecuador</option>
                        <option value="Egypt">Egypt</option>
                        <option value="El Salvador">El Salvador</option>
                        <option value="Equatorial Guinea">Equatorial Guinea</option>
                        <option value="Eritrea">Eritrea</option>
                        <option value="Estonia">Estonia</option>
                        <option value="Ethiopia">Ethiopia</option>
                        <option value="Falkland Islands">Falkland Islands (Malvinas)</option>
                        <option value="Faroe Islands">Faroe Islands</option>
                        <option value="Fiji">Fiji</option>
                        <option value="Finland">Finland</option>
                        <option value="France">France</option>
                        <option value="France Metropolitan">France, Metropolitan</option>
                        <option value="French Guiana">French Guiana</option>
                        <option value="French Polynesia">French Polynesia</option>
                        <option value="French Southern Territories">French Southern Territories</option>
                        <option value="Gabon">Gabon</option>
                        <option value="Gambia">Gambia</option>
                        <option value="Georgia">Georgia</option>
                        <option value="Germany">Germany</option>
                        <option value="Ghana">Ghana</option>
                        <option value="Gibraltar">Gibraltar</option>
                        <option value="Greece">Greece</option>
                        <option value="Greenland">Greenland</option>
                        <option value="Grenada">Grenada</option>
                        <option value="Guadeloupe">Guadeloupe</option>
                        <option value="Guam">Guam</option>
                        <option value="Guatemala">Guatemala</option>
                        <option value="Guinea">Guinea</option>
                        <option value="Guinea-Bissau">Guinea-Bissau</option>
                        <option value="Guyana">Guyana</option>
                        <option value="Haiti">Haiti</option>
                        <option value="Heard and McDonald Islands">Heard and Mc Donald Islands</option>
                        <option value="Holy See">Holy See (Vatican City State)</option>
                        <option value="Honduras">Honduras</option>
                        <option value="Hong Kong">Hong Kong</option>
                        <option value="Hungary">Hungary</option>
                        <option value="Iceland">Iceland</option>
                        <option value="India">India</option>
                        <option value="Indonesia">Indonesia</option>
                        <option value="Iran">Iran (Islamic Republic of)</option>
                        <option value="Iraq">Iraq</option>
                        <option value="Ireland">Ireland</option>
                        <option value="Israel">Israel</option>
                        <option value="Italy">Italy</option>
                        <option value="Jamaica">Jamaica</option>
                        <option value="Japan">Japan</option>
                        <option value="Jordan">Jordan</option>
                        <option value="Kazakhstan">Kazakhstan</option>
                        <option value="Kenya">Kenya</option>
                        <option value="Kiribati">Kiribati</option>
                        <option value="Democratic People's Republic of Korea">Korea, Democratic People's Republic of</option>
                        <option value="Korea">Korea, Republic of</option>
                        <option value="Kuwait">Kuwait</option>
                        <option value="Kyrgyzstan">Kyrgyzstan</option>
                        <option value="Lao">Lao People's Democratic Republic</option>
                        <option value="Latvia">Latvia</option>
                        <option value="Lebanon" selected>Lebanon</option>
                        <option value="Lesotho">Lesotho</option>
                        <option value="Liberia">Liberia</option>
                        <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
                        <option value="Liechtenstein">Liechtenstein</option>
                        <option value="Lithuania">Lithuania</option>
                        <option value="Luxembourg">Luxembourg</option>
                        <option value="Macau">Macau</option>
                        <option value="Macedonia">Macedonia, The Former Yugoslav Republic of</option>
                        <option value="Madagascar">Madagascar</option>
                        <option value="Malawi">Malawi</option>
                        <option value="Malaysia">Malaysia</option>
                        <option value="Maldives">Maldives</option>
                        <option value="Mali">Mali</option>
                        <option value="Malta">Malta</option>
                        <option value="Marshall Islands">Marshall Islands</option>
                        <option value="Martinique">Martinique</option>
                        <option value="Mauritania">Mauritania</option>
                        <option value="Mauritius">Mauritius</option>
                        <option value="Mayotte">Mayotte</option>
                        <option value="Mexico">Mexico</option>
                        <option value="Micronesia">Micronesia, Federated States of</option>
                        <option value="Moldova">Moldova, Republic of</option>
                        <option value="Monaco">Monaco</option>
                        <option value="Mongolia">Mongolia</option>
                        <option value="Montserrat">Montserrat</option>
                        <option value="Morocco">Morocco</option>
                        <option value="Mozambique">Mozambique</option>
                        <option value="Myanmar">Myanmar</option>
                        <option value="Namibia">Namibia</option>
                        <option value="Nauru">Nauru</option>
                        <option value="Nepal">Nepal</option>
                        <option value="Netherlands">Netherlands</option>
                        <option value="Netherlands Antilles">Netherlands Antilles</option>
                        <option value="New Caledonia">New Caledonia</option>
                        <option value="New Zealand">New Zealand</option>
                        <option value="Nicaragua">Nicaragua</option>
                        <option value="Niger">Niger</option>
                        <option value="Nigeria">Nigeria</option>
                        <option value="Niue">Niue</option>
                        <option value="Norfolk Island">Norfolk Island</option>
                        <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                        <option value="Norway">Norway</option>
                        <option value="Oman">Oman</option>
                        <option value="Pakistan">Pakistan</option>
                        <option value="Palau">Palau</option>
                        <option value="Panama">Panama</option>
                        <option value="Papua New Guinea">Papua New Guinea</option>
                        <option value="Paraguay">Paraguay</option>
                        <option value="Peru">Peru</option>
                        <option value="Philippines">Philippines</option>
                        <option value="Pitcairn">Pitcairn</option>
                        <option value="Poland">Poland</option>
                        <option value="Portugal">Portugal</option>
                        <option value="Puerto Rico">Puerto Rico</option>
                        <option value="Qatar">Qatar</option>
                        <option value="Reunion">Reunion</option>
                        <option value="Romania">Romania</option>
                        <option value="Russia">Russian Federation</option>
                        <option value="Rwanda">Rwanda</option>
                        <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option> 
                        <option value="Saint LUCIA">Saint LUCIA</option>
                        <option value="Saint Vincent">Saint Vincent and the Grenadines</option>
                        <option value="Samoa">Samoa</option>
                        <option value="San Marino">San Marino</option>
                        <option value="Sao Tome and Principe">Sao Tome and Principe</option> 
                        <option value="Saudi Arabia">Saudi Arabia</option>
                        <option value="Senegal">Senegal</option>
                        <option value="Seychelles">Seychelles</option>
                        <option value="Sierra">Sierra Leone</option>
                        <option value="Singapore">Singapore</option>
                        <option value="Slovakia">Slovakia (Slovak Republic)</option>
                        <option value="Slovenia">Slovenia</option>
                        <option value="Solomon Islands">Solomon Islands</option>
                        <option value="Somalia">Somalia</option>
                        <option value="South Africa">South Africa</option>
                        <option value="South Georgia">South Georgia and the South Sandwich Islands</option>
                        <option value="Span">Spain</option>
                        <option value="SriLanka">Sri Lanka</option>
                        <option value="St. Helena">St. Helena</option>
                        <option value="St. Pierre and Miguelon">St. Pierre and Miquelon</option>
                        <option value="Sudan">Sudan</option>
                        <option value="Suriname">Suriname</option>
                        <option value="Svalbard">Svalbard and Jan Mayen Islands</option>
                        <option value="Swaziland">Swaziland</option>
                        <option value="Sweden">Sweden</option>
                        <option value="Switzerland">Switzerland</option>
                        <option value="Syria">Syrian Arab Republic</option>
                        <option value="Taiwan">Taiwan, Province of China</option>
                        <option value="Tajikistan">Tajikistan</option>
                        <option value="Tanzania">Tanzania, United Republic of</option>
                        <option value="Thailand">Thailand</option>
                        <option value="Togo">Togo</option>
                        <option value="Tokelau">Tokelau</option>
                        <option value="Tonga">Tonga</option>
                        <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                        <option value="Tunisia">Tunisia</option>
                        <option value="Turkey">Turkey</option>
                        <option value="Turkmenistan">Turkmenistan</option>
                        <option value="Turks and Caicos">Turks and Caicos Islands</option>
                        <option value="Tuvalu">Tuvalu</option>
                        <option value="Uganda">Uganda</option>
                        <option value="Ukraine">Ukraine</option>
                        <option value="United Arab Emirates">United Arab Emirates</option>
                        <option value="United Kingdom">United Kingdom</option>
                        <option value="United States">United States</option>
                        <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
                        <option value="Uruguay">Uruguay</option>
                        <option value="Uzbekistan">Uzbekistan</option>
                        <option value="Vanuatu">Vanuatu</option>
                        <option value="Venezuela">Venezuela</option>
                        <option value="Vietnam">Viet Nam</option>
                        <option value="Virgin Islands (British)">Virgin Islands (British)</option>
                        <option value="Virgin Islands (U.S)">Virgin Islands (U.S.)</option>
                        <option value="Wallis and Futana Islands">Wallis and Futuna Islands</option>
                        <option value="Western Sahara">Western Sahara</option>
                        <option value="Yemen">Yemen</option>
                        <option value="Yugoslavia">Yugoslavia</option>
                        <option value="Zambia">Zambia</option>
                        <option value="Zimbabwe">Zimbabwe</option>
                    </select>
                    <label>masukkan perusahaan pembuat film :</label>
                    <input type="text" class="form-control" name="perusahaan" placeholder="Nama Perusahaan..." required>
                    <button type="submit" class="btn btn-success">Submit</button>
                    <button type="reset" class="btn btn-danger"><i class="fas fa-cross"></i> reset</button>
                </form>
            </div>
            <div id="rilis" class="tab-pane fade">
                <?php
                    $film = "SELECT * FROM film WHERE CURDATE() BETWEEN tgl_rilis AND DATE_ADD(tgl_rilis, INTERVAL 7 DAY)";
                    $film_konek = mysqli_query($koneksi,$film);

                    $studio         = "SELECT * FROM studio";
                    $studio_konek   = mysqli_query($koneksi,$studio);
                
                    if (mysqli_num_rows($film_konek) < 1) {
                    echo "<h3 style='text-align:center;margin-top:100px;'>Tidak ada film yang dirilis hari ini</h3>";
                    } else {
                        echo "<form action='rilis.php' method='post'>";
                        echo '<label>masukkan nama film</label>';
                        echo "<select class='form-control' name='film' required>";
                        while($row = mysqli_fetch_assoc($film_konek)) {
                            echo '<option value="'.$row['id_film'].'">'.$row['judul'].'</option>';
                        }
                        echo "</select>";
                        echo "<label>Masukkan Awal Tanggal Main :</label>";
                        echo "<input type='date' class='form-control' name='awal' required>";
                        echo '<label>masukkan akhir tanggal main :</label>';
                        echo '<input type="date" class= "form-control" name="akhir" required>';
                        echo '<label>pilih studio :</label>';
                        echo '<select class="form-control" name="studio" required>';
                         while($row = mysqli_fetch_assoc($studio_konek)) {
                            echo '<option value="'.$row['id'].'">'.$row['nama'].'</option>';
                        }
                        echo '</select>';
                        echo '<label>masukkan jam tayang pertama :</label>';
                        echo '<input type="time" class="form-control" name="jam1" placeholder="Jam Tayang" required>';
                        echo '<label>masukkan jam tayang kedua :</label>';
                        echo '<input type="time" class="form-control" name="jam2" placeholder="Jam Tayang">';
                        echo '<label>masukkan jam tayang ketiga :</label>';
                        echo '<input type="time" class="form-control" name="jam3" placeholder="Jam Tayang">';
                        echo '<button type="submit" class="btn btn-primary">Submit</button>';
                        echo '</form>';
                    }
                ?>
            </div>
        </div>
    </body>
</html>