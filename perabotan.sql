-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 24, 2024 at 06:26 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `xmuzicstore`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`, `nama_lengkap`) VALUES
(1, 'TokoCahayaRumahTangga.com', 'admin12345', 'RahmaFitri');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(5) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
(1, 'Alat Masak'),
(2, 'Alat Pembersih Rumah'),
(3, 'Peralatan Makan');

-- --------------------------------------------------------

--
-- Table structure for table `ongkir`
--

CREATE TABLE `ongkir` (
  `id_ongkir` int(5) NOT NULL,
  `nama_kota` varchar(100) NOT NULL,
  `tarif` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ongkir`
--

INSERT INTO `ongkir` (`id_ongkir`, `nama_kota`, `tarif`) VALUES
(1, 'Bukittinggi\r\n', 20000),
(2, 'Ampang Gadang', 25000),
(3, 'Payakumbuh', 30000),
(4, 'Jakarta Utara', 50000),
(5, 'Jakarta Timur', 30000);

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `email_pelanggan` varchar(100) NOT NULL,
  `password_pelanggan` varchar(50) NOT NULL,
  `nama_pelanggan` varchar(100) NOT NULL,
  `telepon_pelanggan` varchar(25) NOT NULL,
  `alamat_pelanggan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `email_pelanggan`, `password_pelanggan`, `nama_pelanggan`, `telepon_pelanggan`, `alamat_pelanggan`) VALUES
(1, 'arifrahman2592@gmail.com', 'arif', 'Arif Nur Rohman', '08990423789', ''),
(2, 'rizqa@gmail.com', 'rizqa', 'Rizqa Luviana', '08990423789', ''),
(4, 'jimmy@gmail.com', 'jimmy', 'jimmy', 'telepon', 'lubuklinggau'),
(8, 'jihan@gmail.com', 'jihan12345', 'Jihan', 'telepon', 'jalan Pertama sari perumahan Gading Rt.13 Rw.01'),
(9, 'rezahardiansyah12@gmail.com', 'reza12345', 'Reza', 'telepon', 'Harmoni ');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `id_pembelian` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `bank` varchar(255) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `bukti` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `id_pembelian`, `nama`, `bank`, `jumlah`, `tanggal`, `bukti`) VALUES
(2, 17, 'Arif Nur Rohman', 'mandiri', 295000, '2021-12-19', '211219174044wallppoejhrthy.jpg'),
(3, 18, 'Arif Rahman', 'Mandiri', 14020000, '2021-12-26', '211226103551IMG_20180821_133009.JPG'),
(4, 19, 'zoro', 'MANDIRI', 1, '2022-01-11', '220111172822Header.jpg'),
(5, 20, 'zoro', 'MANDIRI', 3025000, '2022-01-11', '220111185642ampli.jpg'),
(6, 21, 'Jihan', 'BRI', 120000, '2024-06-18', '2406180505014.png'),
(7, 22, 'Andri', 'BCA', 40000, '2024-06-18', '2406181004121.png'),
(8, 23, 'Riyas', 'BCA', 40000, '2024-06-18', '2406181357132.png'),
(9, 25, 'Riyas', 'DKI', 40000, '2024-06-21', '2406211403311.png'),
(10, 26, 'Adi Putra', 'Simpades', 125000, '2024-06-23', '2406230716161.png'),
(11, 27, 'Nurhan ', 'BCA', 50000, '2024-06-23', '2406230942582406230716161.png'),
(12, 28, 'Nurhan ', 'BCA', 250000, '2024-06-23', '240623095909211226103551IMG_20180821_133009.JPG'),
(13, 29, 'Natalia', 'BCA', 250000, '2024-06-23', '2406231003462406180505014.png'),
(14, 30, '', '', 0, '2024-06-24', '2406240520322406181004121.png');

-- --------------------------------------------------------

--
-- Table structure for table `pembelian`
--

CREATE TABLE `pembelian` (
  `id_pembelian` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `id_ongkir` int(11) NOT NULL,
  `tanggal_pembelian` date NOT NULL,
  `total_pembelian` int(11) NOT NULL,
  `nama_kota` varchar(100) NOT NULL,
  `tarif` int(11) NOT NULL,
  `alamat_pengiriman` text NOT NULL,
  `status_pembelian` varchar(100) NOT NULL DEFAULT 'pending',
  `resi_pengiriman` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `pembelian`
--

INSERT INTO `pembelian` (`id_pembelian`, `id_pelanggan`, `id_ongkir`, `tanggal_pembelian`, `total_pembelian`, `nama_kota`, `tarif`, `alamat_pengiriman`, `status_pembelian`, `resi_pengiriman`) VALUES
(21, 8, 1, '2024-06-18', 120000, 'Demak', 20000, 'jln.sungai brantas rt.13 rw.01', 'barang dikirim', '089'),
(22, 8, 4, '2024-06-18', 360000, 'Jakarta Utara', 50000, 'jalan  perumahan Gading Rt.13 Rw.01', 'lunas', ''),
(23, 8, 4, '2024-06-18', 150000, 'Jakarta Utara', 50000, 'jln.sungai brantas rt.13 rw.01', 'lunas', ''),
(24, 8, 3, '2024-06-18', 185000, 'Payakumbuh', 30000, 'Bukittinggi Baso KM 10', 'pending', ''),
(25, 8, 4, '2024-06-21', 518000, 'Jakarta Utara', 50000, 'Harmoni', 'lunas', ''),
(26, 9, 2, '2024-06-23', 125000, 'Ampang Gadang', 25000, '', 'lunas', ''),
(27, 10, 4, '2024-06-23', 150000, 'Jakarta Utara', 50000, 'jalan Pertama sari perumahan Gading Rt.13 Rw.01', 'lunas', ''),
(28, 10, 5, '2024-06-23', 240000, 'Jakarta Timur', 30000, 'Harmoni', 'barang dikirim', '089'),
(29, 10, 0, '2024-06-23', 100000, '', 0, 'Gading Serpong RT12 RW09', 'barang dikirim', ''),
(30, 8, 5, '2024-06-24', 210000, 'Jakarta Timur', 30000, 'Gading Nias', 'batal', '');

-- --------------------------------------------------------

--
-- Table structure for table `pembelian_produk`
--

CREATE TABLE `pembelian_produk` (
  `id_pembelian_produk` int(11) NOT NULL,
  `id_pembelian` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `harga` int(11) NOT NULL,
  `berat` int(11) NOT NULL,
  `subberat` int(11) NOT NULL,
  `subharga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `pembelian_produk`
--

INSERT INTO `pembelian_produk` (`id_pembelian_produk`, `id_pembelian`, `id_produk`, `jumlah`, `nama`, `harga`, `berat`, `subberat`, `subharga`) VALUES
(1, 1, 1, 1, '', 0, 0, 0, 0),
(2, 1, 2, 1, '', 0, 0, 0, 0),
(3, 0, 3, 2, '', 0, 0, 0, 0),
(4, 0, 7, 1, '', 0, 0, 0, 0),
(5, 0, 3, 2, '', 0, 0, 0, 0),
(6, 0, 7, 1, '', 0, 0, 0, 0),
(7, 8, 3, 2, '', 0, 0, 0, 0),
(8, 8, 7, 1, '', 0, 0, 0, 0),
(9, 9, 3, 1, '', 0, 0, 0, 0),
(10, 9, 4, 1, '', 0, 0, 0, 0),
(11, 10, 3, 1, 'Bass Toska Series', 7000000, 2000, 2000, 7000000),
(12, 10, 4, 1, 'Saxophone', 7000000, 1000, 1000, 7000000),
(13, 11, 3, 1, 'Bass Toska Series', 7500000, 2000, 2000, 7500000),
(14, 11, 4, 1, 'Saxophone', 7000000, 1000, 1000, 7000000),
(15, 12, 3, 1, 'Bass Toska Series', 7500000, 2000, 2000, 7500000),
(16, 12, 4, 1, 'Saxophone', 7000000, 1000, 1000, 7000000),
(17, 13, 3, 1, 'Bass Toska Series', 7500000, 2000, 2000, 7500000),
(18, 13, 4, 1, 'Saxophone', 7000000, 1000, 1000, 7000000),
(19, 0, 3, 1, 'Bass Toska Series', 7500000, 2000, 2000, 7500000),
(20, 0, 4, 1, 'Saxophone', 7000000, 1000, 1000, 7000000),
(21, 16, 3, 1, 'Bass Toska Series', 7500000, 2000, 2000, 7500000),
(22, 16, 4, 1, 'Saxophone', 7000000, 1000, 1000, 7000000),
(23, 17, 5, 1, 'Gitar Hitam', 4000000, 2000, 2000, 4000000),
(24, 18, 7, 2, 'Biola Hitam', 3000000, 500, 1000, 6000000),
(25, 18, 5, 2, 'Gitar Hitam', 4000000, 2000, 4000, 8000000),
(26, 19, 5, 1, 'Gitar Hitam', 4000000, 2000, 2000, 4000000),
(27, 19, 4, 1, 'Saxophone', 7000000, 1000, 1000, 7000000),
(28, 20, 10, 1, 'kavo gitar', 5000, 100, 100, 5000),
(29, 20, 7, 1, 'Biola', 3000000, 500, 500, 3000000),
(30, 21, 3, 1, 'Wajan Kuali Stainless Steel Gagang Satu  ', 100000, 100, 100, 100000),
(31, 22, 1, 1, 'Panci Stainless Steel Merek Zebra Thailand', 210000, 2300, 2300, 210000),
(32, 22, 3, 1, 'Wajan Kuali Stainless Steel Gagang Satu  ', 100000, 100, 100, 100000),
(33, 23, 3, 1, 'Wajan Kuali Stainless Steel Gagang Satu  ', 100000, 100, 100, 100000),
(34, 24, 3, 1, 'Wajan Kuali Stainless Steel Gagang Satu  ', 100000, 100, 100, 100000),
(35, 24, 10, 1, 'Sendok Masak ', 30000, 97, 97, 30000),
(36, 24, 7, 1, 'Sapu Rumah ', 25000, 100, 100, 25000),
(37, 25, 1, 2, 'Panci Stainless Steel Merek Zebra Thailand', 210000, 2300, 4600, 420000),
(38, 25, 4, 1, 'Loyang Kue Lapis Aluminium', 48000, 13, 13, 48000),
(39, 26, 3, 1, 'Wajan Kuali Stainless Steel Gagang Satu  ', 100000, 100, 100, 100000),
(40, 27, 3, 1, 'Wajan Kuali Stainless Steel Gagang Satu  ', 100000, 100, 100, 100000),
(41, 28, 1, 1, 'Panci Stainless Steel Merek Zebra Thailand', 210000, 2300, 2300, 210000),
(42, 29, 3, 1, 'Wajan Kuali Stainless Steel Gagang Satu  ', 100000, 100, 100, 100000),
(43, 30, 3, 1, 'Wajan Kuali Stainless Steel Gagang Satu  ', 100000, 100, 100, 100000),
(44, 30, 12, 1, 'Wajan Ebonit  Merek Maspion Jawa', 80000, 80, 80, 80000);

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `id_kategori` int(5) NOT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `harga_produk` int(11) NOT NULL,
  `berat_produk` int(11) NOT NULL,
  `foto_produk` varchar(100) NOT NULL,
  `deskripsi_produk` text NOT NULL,
  `stok_produk` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_produk`, `id_kategori`, `nama_produk`, `harga_produk`, `berat_produk`, `foto_produk`, `deskripsi_produk`, `stok_produk`) VALUES
(1, 1, 'Panci Stainless Steel Merek Zebra Thailand', 210000, 2300, 'Panci Stainless Steel.jpg', '                		    		Diameter Dalam : 30 cm\r\nPanjang Gagang :5,5 cm\r\nTinggi Panci : 18 cm\r\nTinggi Tutup Panci : 3 cm\r\nTinggi Keseluruhan : 25 cm\r\nPanjang Keseluruhan : 43 cm\r\nLebar Keseluruhan : 32,5 cm\r\nBerat : ± 2300 gr\r\nKapasitas : ± 12 Lt\r\n\r\n\r\nMade in Thailand    	    	        ', 3),
(3, 1, 'Wajan Kuali Stainless Steel Gagang Satu  ', 100000, 100, 'Wok2.jpeg', '                            		    		    		    		- Diameter : 30 cm\r\n- Berat : 0.8 kg\r\n- Material : stainless steel food grade\r\n\r\n\r\nKeunggulan panci / wajan / wok stainless steel Asta :\r\n\r\n- Anti karat\r\n- Aman untuk makanan\r\n- Tebal\r\n- Gagang satu, lebih mudah digunakan\r\n- Mudah dibersihkan	    	    	    	    	                ', 1),
(4, 1, 'Loyang Kue Lapis Aluminium', 48000, 13, 'LoyangKueLapis.jpeg', '    		    		    		Loyang Kotak / Loyang Kue Lapis / Loyang Bolu    	    	    	', 3),
(5, 2, 'Sikat Closet Lionstar/ Sikat Bulat Lion Star', 24000, 25, 'SikatWcYangBulat.jpg', '    		Sikat WC BO-1 Lion Star\r\n\r\nPanjang 14 cm\r\nLebar 14 cm\r\nTinggi 41 cm\r\n    	    	', 2),
(6, 3, 'Piring Keramik Putih', 100000, 3000, 'Piring Keramik.jpg', 'Piring keramik putih \r\nSatuan: Lusin\r\nBerat: -+ 3Kg\r\nMerk: Tidak ada merk', 5),
(7, 2, 'Sapu Rumah ', 25000, 100, 'Sapu Rumah Nagoya.jpg', '    		    		    		    		Sapu Rumah Merek Nagoya Motif Bunga Coklat\r\nWarna : Coklat\r\nMerek : Nagoya\r\n    	    	    	    	', 1),
(8, 2, 'Pel Lantai ', 25000, 250, 'Pel Lantai Merek Nagoya.jpg', 'Pel Lantai Bagus Untuk Membersihkan Rumah', 4),
(10, 1, 'Sendok Masak ', 30000, 97, 'Sendok Goreng Stainlestell.jpg', 'Sendok Goreng/Masak Merek SHUMA Terbuat Dari Aluminium     	    	', 3),
(12, 1, 'Wajan Ebonit  Merek Maspion Jawa', 80000, 80, 'wajan-ebonit.jpg', 'Terbuat dari aluminium MASPION. Aluminium adalah konduktor panas yang baik sehingga masakan lebih cepat mendidih dan menghemat energi serta waktu', 2);

-- --------------------------------------------------------

--
-- Table structure for table `produk_foto`
--

CREATE TABLE `produk_foto` (
  `id_produk_foto` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `nama_produk_foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `produk_foto`
--

INSERT INTO `produk_foto` (`id_produk_foto`, `id_produk`, `nama_produk_foto`) VALUES
(1, 0, 'gokaiger_symbol___r_by_alpha_vector-d3c89zx.jpg'),
(2, 0, 'MARIO - SUPER MARIO WALLPAPER - MARIO WALLPAPER - NINTENDO WALLPAPER - NINTENDO IPHONE - MARIO BROS.jpg'),
(3, 0, 'wallppoejhrthy.jpg'),
(4, 11, 'Various Projects_ Character Design 33 on Behance.jpg'),
(5, 11, 'Various Projects_ Character Design 9 by Dermot Reddan, via Behance.jpg'),
(6, 11, 'Evil Teddy Bear - Halloween Seasons_Holidays.jpg'),
(8, 12, 'Various Projects_ Character Design 9 by Dermot Reddan, via Behance.jpg'),
(9, 12, 'Evil Teddy Bear - Halloween Seasons_Holidays.jpg'),
(10, 13, 'Various Projects_ Character Design 33 on Behance.jpg'),
(13, 12, '20220109052614Typography Quotes for your Inspiration.jpg'),
(14, 11, 'Various Projects_ Character Design 33 on Behance.jpg'),
(15, 11, 'Various Projects_ Character Design 9 by Dermot Reddan, via Behance.jpg'),
(16, 11, 'cad144d58be0d207b412cf3989fb7ab0.jpg'),
(20, 10, 'kapo.jpg'),
(21, 10, 'kapo1.jpg'),
(22, 10, 'kapo2.jpg'),
(23, 11, ''),
(24, 4, '20240618133802'),
(25, 3, '20240621132450'),
(27, 12, 'wajan-ebonit.jpg'),
(31, 1, '20240624055549');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `ongkir`
--
ALTER TABLE `ongkir`
  ADD PRIMARY KEY (`id_ongkir`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`);

--
-- Indexes for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`id_pembelian`);

--
-- Indexes for table `pembelian_produk`
--
ALTER TABLE `pembelian_produk`
  ADD PRIMARY KEY (`id_pembelian_produk`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indexes for table `produk_foto`
--
ALTER TABLE `produk_foto`
  ADD PRIMARY KEY (`id_produk_foto`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
ALTER TABLE pelanggan ADD COLUMN reset_token VARCHAR(100) DEFAULT NULL;

-- AUTO_INCREMENT for table `ongkir`
--
ALTER TABLE `ongkir`
  MODIFY `id_ongkir` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `pembelian`
--
ALTER TABLE `pembelian`
  MODIFY `id_pembelian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `pembelian_produk`
--
ALTER TABLE `pembelian_produk`
  MODIFY `id_pembelian_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `produk_foto`
--
ALTER TABLE `produk_foto`
  MODIFY `id_produk_foto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
