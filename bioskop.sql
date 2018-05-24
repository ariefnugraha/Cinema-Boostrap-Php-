-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 02, 2018 at 03:00 AM
-- Server version: 10.1.8-MariaDB
-- PHP Version: 5.6.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id5598637_bioskop`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(5) UNSIGNED ZEROFILL NOT NULL,
  `image` varchar(50) DEFAULT NULL,
  `fname` varchar(20) NOT NULL,
  `lname` varchar(20) NOT NULL,
  `sex` varchar(1) NOT NULL,
  `username` varchar(12) NOT NULL,
  `password` varchar(60) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `saldo` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `image`, `fname`, `lname`, `sex`, `username`, `password`, `email`, `phone`, `saldo`) VALUES
(00001, NULL, 'Dadagn', 'Ib', 'L', 'iba', '$2y$10$6wMGisIUiEKTtiTUjjj9bexknA9GSpR5p49d5vH6vVwjk6IwFlT6i', 'admkadka@gmail.com', '0420', 0),
(00002, NULL, 'Arief', 'Nugraha', 'L', 'crazythings', '$2y$10$i8rGPOcMzZRW5A9VNFIyEeaWiwmRgXPTv.oPqEGQU9dfC77mUw3Ou', 'muhammadariefnugraha@gmail.com', '98494', 755000),
(00003, NULL, 'Yosua', 'Acung', 'L', '535160039', '$2y$10$W6K6/NGPPoaPjR0Np1grjeFvBQz.zdoiqb0ZeW/Ww8KCk/fL1NI1C', 'yosua.acung@gmail.com', '081258444385', 0),
(00004, NULL, 'Muhammad Arief', 'Nugraha', 'L', 'kentury', '$2y$10$JVnncYWtlqiLX85dxLLwU.gOrOWmHJO25vPRpbzDpP1ZbkVLJscAe', 'muhammadariefnugraha77@gmail.com', '085986891211', 25000);

-- --------------------------------------------------------

--
-- Table structure for table `departemen`
--

CREATE TABLE `departemen` (
  `id` int(5) NOT NULL,
  `nama` varchar(20) NOT NULL,
  `gaji` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `departemen`
--

INSERT INTO `departemen` (`id`, `nama`, `gaji`) VALUES
(432, 'Kasir', 3000000),
(744, 'Film Management', 3500000),
(903, 'Manager', 500000);

-- --------------------------------------------------------

--
-- Table structure for table `film`
--

CREATE TABLE `film` (
  `id_film` int(5) NOT NULL,
  `image` varchar(60) NOT NULL,
  `judul` varchar(30) NOT NULL,
  `trailer` varchar(100) NOT NULL,
  `tgl_rilis` date NOT NULL,
  `durasi` int(3) NOT NULL,
  `sinopsis` text,
  `artis` text,
  `kategori1` varchar(20) NOT NULL,
  `kategori2` varchar(20) DEFAULT NULL,
  `kategori3` varchar(20) DEFAULT NULL,
  `rating` varchar(2) DEFAULT NULL,
  `negara` varchar(20) DEFAULT NULL,
  `produksi` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `film`
--

INSERT INTO `film` (`id_film`, `image`, `judul`, `trailer`, `tgl_rilis`, `durasi`, `sinopsis`, `artis`, `kategori1`, `kategori2`, `kategori3`, `rating`, `negara`, `produksi`) VALUES
(5, 'The Greatest Showmancover5.jpg', 'The Greatest Showman', 'http://www.facebook.com', '2018-04-16', 106, 'Terinsipirasi oleh imajinasi P. T. Barnum, The Greatest Showman adalah musikal asli yang menceritakan kelahiran bisnis pertunjukan dan bercerita tentang seorang visioner yang bangkit dari nol untuk menciptakan tontonan yang menjadi sensasi di seluruh dunia', 'Hugh Jackman, Zac Efron, Zendaya, Michelle Williams, Rebecca Ferguson, Keala Seattle, Skylar Dunn', 'Family', 'Musical', 'Drama', 'BO', 'United States', 'Twenty Century Fox'),
(6, 'Rampagerampage.jpg', 'Rampage', 'https://www.youtube.com/embed/SaZNFH4OORg', '2018-04-11', 107, 'Tiga hewan berbeda terinfeksi oleh patogen yang berbahaya, seorang primatologis dan tim genetis bergabung untuk menghentikan mereka menghancurkan chicago', 'Dwayne Johnson, Naomi Harris, Malin Akerman, Jeffrey Dean Morgan, Jake Lacey', 'Action', 'Adventure', 'Sci-Fi', 'BO', 'United States', 'New Line Cinema'),
(7, 'A Quiet Place1.jpg', 'A Quiet Place', 'https://www.youtube.com/embed/p9wE8dyzEJE', '2018-04-06', 90, 'Sebuah keluarga harus hidup tanpa suara ketika bersembunyi dari mahluk yang memburu dengan suara', 'Emily Blunt, John Krasinki, Millicent Simons, Noah Jupe, Cade Woodward', 'Drama', 'Horror', 'Sci-Fi', 'BO', 'United States', 'Platinum Dunes'),
(8, 'Ready Player Onecover1.jpg', 'Ready Player One', 'https://www.youtube.com/embed/cSp1dM2Vj48', '2018-04-29', 140, 'Ketika pembuat dunia virtual reality yang disebut OASIS meninggal, dia merilis sebuah video dimana dia menantang seluruh pengguna OASIS untuk mencari rahasia di OASIS yang mana akan memberikan keberuntungan bagi penemunya', 'Tye Sheridan, Olivia Cooke, Ben Mendelsohn, Lena Waithe, T.J. Miller, Simon Pegg  ', 'Action', 'Adventure', 'Sci-Fi', 'BO', 'United States', 'Warner Bros.'),
(10, '2.jpg', 'Avenger Infinity War', 'https://www.youtube.com/embed/6ZfuNTqbHE8', '2018-04-27', 149, 'Avengers bersama sekutunya harus berkorban untuk melawan Thanos yang kuat sebelum terjadinya kehancuran alam semesta', 'Robert Downey Jr, Chris Evans, Chris Hemsworth, Tom Holland, Scarlett Johansson', 'Action', 'Adventure', 'Superhero', 'BO', 'United States', 'Marvel Studios'),
(11, 'Solo A Star Wars Storycover3.jpg', 'Solo A Star Wars Story', 'https://www.youtube.com/embed/jPEYpryMp2s', '2018-04-25', 135, 'Selama berpetualang di dunia gelap, Han Solo bertemu dengan Chilbaca copilot masa depannya dan bertemu degan Lando Calrissan beberapa tahun sebelum bergabung dengan pemberontakan', 'Alden Ehrenreich, Emilia Clarke, Donald Glover, Woody Harelson, Phoebe Waller-Bridge', 'Action', 'Adventure', 'Fantasy', 'BO', 'United States', 'Lucasfilm');

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE `karyawan` (
  `id` int(5) NOT NULL,
  `id_dpt` int(5) NOT NULL,
  `fname` varchar(20) NOT NULL,
  `lname` varchar(20) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) DEFAULT NULL,
  `tgl_rekrut` date NOT NULL,
  `sex` varchar(1) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `alamat` varchar(50) NOT NULL,
  `telepon` varchar(15) NOT NULL,
  `pendidikan` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`id`, `id_dpt`, `fname`, `lname`, `email`, `password`, `tgl_rekrut`, `sex`, `tgl_lahir`, `alamat`, `telepon`, `pendidikan`) VALUES
(1, 744, 'Budi', 'Pekerti', 'budi@gmail.com', 'budi744', '2018-03-23', 'L', '2018-03-23', 'Jl. JOhar Baru', '9292', 'SMA'),
(2, 432, 'Tiara', '', 'tiara@gmail.com', 'tiara432', '2018-03-23', 'M', '2018-03-01', 'Jl. Baru', '085986891211', 'SMA'),
(4, 903, 'Arief', 'Nugraha', 'kentury@gmail.com', 'arieftkj2', '2018-04-21', 'L', '2018-04-01', 'Jalan jalan ke rumah orang', '03013901930', 'SMA');

-- --------------------------------------------------------

--
-- Table structure for table `promo`
--

CREATE TABLE `promo` (
  `id` int(5) NOT NULL,
  `kode` varchar(20) NOT NULL,
  `nominal` int(10) NOT NULL,
  `tanggal_awal` date NOT NULL,
  `tanggal_akhir` date NOT NULL,
  `deskripsi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `promo`
--

INSERT INTO `promo` (`id`, `kode`, `nominal`, `tanggal_awal`, `tanggal_akhir`, `deskripsi`) VALUES
(1, 'Aprilceria', 10000, '2018-04-25', '2018-04-30', 'akhir bulan tapi belum gajian ? tenang aja. Kamu tetap bisa nonton tapi dompet gak bolong dengan promosi aprilceria');

-- --------------------------------------------------------

--
-- Table structure for table `studio`
--

CREATE TABLE `studio` (
  `id` int(11) NOT NULL,
  `nama` varchar(20) NOT NULL,
  `kapasitas` int(3) NOT NULL,
  `harga` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `studio`
--

INSERT INTO `studio` (`id`, `nama`, `kapasitas`, `harga`) VALUES
(101, 'Regular', 50, 35000),
(102, 'Sweet', 30, 50000),
(103, 'Platinum', 20, 70000),
(104, 'Imax', 40, 75000);

-- --------------------------------------------------------

--
-- Table structure for table `tayang`
--

CREATE TABLE `tayang` (
  `id` int(5) NOT NULL,
  `tanggal_awal` date NOT NULL,
  `tanggal_akhir` date NOT NULL,
  `id_film` int(5) NOT NULL,
  `id_studio` int(3) NOT NULL,
  `jam1` time NOT NULL,
  `jam2` time DEFAULT NULL,
  `jam3` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tayang`
--

INSERT INTO `tayang` (`id`, `tanggal_awal`, `tanggal_akhir`, `id_film`, `id_studio`, `jam1`, `jam2`, `jam3`) VALUES
(1, '2018-04-17', '2018-04-24', 5, 101, '10:00:00', '15:00:00', '21:00:00'),
(2, '2018-04-25', '2018-04-30', 11, 101, '10:00:00', '15:00:00', '22:00:00'),
(3, '2018-05-01', '2018-05-31', 8, 101, '10:00:00', '15:00:00', '21:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tiket`
--

CREATE TABLE `tiket` (
  `id` int(5) NOT NULL,
  `tanggal` date NOT NULL,
  `tanggal_tonton` date NOT NULL,
  `username` varchar(15) NOT NULL,
  `film_id` int(5) NOT NULL,
  `judul` varchar(50) NOT NULL,
  `id_studio` int(5) NOT NULL,
  `nama_studio` varchar(15) NOT NULL,
  `seat` varchar(30) NOT NULL,
  `jam_tonton` time NOT NULL,
  `jumlah_orang` int(3) NOT NULL,
  `harga` int(6) NOT NULL,
  `total_harga` int(10) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tiket`
--

INSERT INTO `tiket` (`id`, `tanggal`, `tanggal_tonton`, `username`, `film_id`, `judul`, `id_studio`, `nama_studio`, `seat`, `jam_tonton`, `jumlah_orang`, `harga`, `total_harga`, `status`) VALUES
(5, '2018-04-17', '2018-04-17', 'crazythings', 5, 'The Greatest Showman', 101, 'Regular', 'D3 ', '10:00:00', 1, 35000, 35000, 'Ready To Watch'),
(7, '2018-04-25', '2018-04-26', 'kentury', 11, 'Solo A Star Wars Story', 101, 'Regular', 'F4 F5 ', '10:00:00', 2, 35000, 60000, 'Ready To Watch'),
(8, '2018-05-01', '2018-05-01', 'kentury', 8, 'Ready Player One', 101, 'Regular', 'F3 ', '10:00:00', 1, 35000, 25000, 'Ready To Watch');

-- --------------------------------------------------------

--
-- Table structure for table `topup`
--

CREATE TABLE `topup` (
  `id` int(5) NOT NULL,
  `tanggal` date NOT NULL,
  `username` varchar(15) NOT NULL,
  `uang` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `topup`
--

INSERT INTO `topup` (`id`, `tanggal`, `username`, `uang`) VALUES
(1, '2018-04-25', 'kentury', 100000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departemen`
--
ALTER TABLE `departemen`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `film`
--
ALTER TABLE `film`
  ADD PRIMARY KEY (`id_film`),
  ADD KEY `id_film` (`id_film`),
  ADD KEY `id_film_2` (`id_film`);

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_dpt` (`id_dpt`);

--
-- Indexes for table `promo`
--
ALTER TABLE `promo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `studio`
--
ALTER TABLE `studio`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tayang`
--
ALTER TABLE `tayang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_studio` (`id_studio`),
  ADD KEY `id_film` (`id_film`);

--
-- Indexes for table `tiket`
--
ALTER TABLE `tiket`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_studio` (`id_studio`),
  ADD KEY `film_id` (`film_id`);

--
-- Indexes for table `topup`
--
ALTER TABLE `topup`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `departemen`
--
ALTER TABLE `departemen`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=904;
--
-- AUTO_INCREMENT for table `film`
--
ALTER TABLE `film`
  MODIFY `id_film` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `promo`
--
ALTER TABLE `promo`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tayang`
--
ALTER TABLE `tayang`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tiket`
--
ALTER TABLE `tiket`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `topup`
--
ALTER TABLE `topup`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD CONSTRAINT `tes` FOREIGN KEY (`id_dpt`) REFERENCES `departemen` (`id`);

--
-- Constraints for table `tayang`
--
ALTER TABLE `tayang`
  ADD CONSTRAINT `tayang_ibfk_1` FOREIGN KEY (`id_studio`) REFERENCES `studio` (`id`),
  ADD CONSTRAINT `tayang_ibfk_2` FOREIGN KEY (`id_film`) REFERENCES `film` (`id_film`);

--
-- Constraints for table `tiket`
--
ALTER TABLE `tiket`
  ADD CONSTRAINT `studio` FOREIGN KEY (`id_studio`) REFERENCES `studio` (`id`),
  ADD CONSTRAINT `tiket_ibfk_1` FOREIGN KEY (`film_id`) REFERENCES `film` (`id_film`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
