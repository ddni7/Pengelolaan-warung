-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 04, 2023 at 05:33 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `warungaman`
--

-- --------------------------------------------------------

--
-- Table structure for table `detailpesanan`
--

CREATE TABLE `detailpesanan` (
  `iddetailpesanan` int(11) NOT NULL,
  `idpesanan` int(11) NOT NULL,
  `idproduk` int(11) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detailpesanan`
--

INSERT INTO `detailpesanan` (`iddetailpesanan`, `idpesanan`, `idproduk`, `qty`) VALUES
(22, 0, 13, 13),
(24, 202300001, 14, 3),
(25, 202300002, 17, 2),
(27, 202300002, 14, 3),
(33, 202300005, 13, 100),
(34, 202300006, 15, 2),
(35, 202300012, 13, 200),
(36, 202300013, 34, 2),
(37, 202300011, 34, 8),
(38, 202300014, 13, 50),
(39, 202300015, 13, 30);

-- --------------------------------------------------------

--
-- Table structure for table `masuk`
--

CREATE TABLE `masuk` (
  `idmasuk` int(11) NOT NULL,
  `idproduk` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `tanggalmasuk` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `masuk`
--

INSERT INTO `masuk` (`idmasuk`, `idproduk`, `qty`, `tanggalmasuk`) VALUES
(2, 13, 1, '2023-05-25 14:18:59'),
(4, 27, 100, '2023-05-30 01:15:44'),
(5, 25, 5, '2023-05-30 02:39:29'),
(6, 14, 5, '2023-05-31 00:19:16'),
(7, 45, 50, '2023-06-03 06:01:27'),
(8, 46, 100, '2023-07-06 04:16:42'),
(9, 13, 100, '2023-07-17 07:34:28'),
(10, 17, 90, '2023-07-17 07:35:59'),
(11, 47, 2, '2023-07-25 03:47:56');

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `idpelanggan` int(11) NOT NULL,
  `namapelanggan` varchar(30) NOT NULL,
  `notelp` varchar(15) NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`idpelanggan`, `namapelanggan`, `notelp`, `alamat`) VALUES
(1, 'uzumaki ujang', '089246586234', 'district konoha'),
(2, 'mungki si udin', '0831427891', 'east blue'),
(3, 'danii', '089547268832', 'bandung'),
(6, 'mang ujang', '0897653427', 'kp peuris'),
(7, 'mamang ujang', '08957625327', 'kp cikuda '),
(8, 'Gilang', '089542564563', 'Warlob'),
(9, 'Gugun', '08525348981', 'kp cihampelas'),
(10, 'Agung', '0896427582', 'Pangauban'),
(11, 'Mang asep', '08967429214', 'kp jagabaya'),
(12, 'Bi icih', '085376252876', 'kp jongol'),
(13, 'Si dadan', '089327522352', 'kp cicakung'),
(14, 'adam', '0580975425', 'cimaung'),
(15, 'aril', '0896743563', 'nata endah'),
(16, 'Dani', '432456735', 'jagabya');

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `idorder` int(11) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp(),
  `idpelanggan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`idorder`, `tanggal`, `idpelanggan`) VALUES
(202300001, '2023-05-23 03:56:09', 2),
(202300002, '2023-05-24 08:02:11', 1),
(202300005, '2023-05-30 00:54:23', 8),
(202300006, '2023-05-30 01:19:33', 10),
(202300007, '2023-05-30 03:06:32', 13),
(202300008, '2023-05-30 03:06:41', 12),
(202300009, '2023-05-30 03:06:54', 11),
(202300010, '2023-05-30 03:07:15', 9),
(202300011, '2023-05-30 03:07:32', 6),
(202300012, '2023-05-30 04:09:25', 14),
(202300013, '2023-05-30 07:09:17', 15),
(202300014, '2023-05-31 03:05:57', 3),
(202300015, '2023-06-03 06:03:13', 16);

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `idproduk` int(11) NOT NULL,
  `namaproduk` varchar(30) NOT NULL,
  `deskripsi` varchar(30) NOT NULL,
  `stok` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `image` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`idproduk`, `namaproduk`, `deskripsi`, `stok`, `harga`, `image`) VALUES
(13, 'Indomie Ayam Bawang special', 'Makanan', -379, 3500, '80f6a4ff6bb9e4e9d8db3cefbcb8cdf4.jpg'),
(14, 'Indomie Mie Goreng Hot & Spicy', 'Makanan', 155, 3500, 'cc03f947449faac798e00ca0b50934ad.jpg_480wx480h'),
(15, 'Indomie Mie Goreng Rendang', 'Makanan', 248, 3500, NULL),
(16, 'Indomie Mie Iga Penyet', 'Makanan', 120, 3500, NULL),
(17, 'Indomie Mie Cabe Ijo', 'Makanan', 210, 3500, NULL),
(19, 'Mie Sedaap Goreng', 'Makanan', 350, 3500, NULL),
(20, 'Mie Sedaap Soto', 'Makanan', 300, 3500, NULL),
(21, 'Mie Sedaap Ayam Bawang', 'Makanan', 250, 3500, NULL),
(22, 'Mie Sedaap Kari Spesial', 'Makanan', 400, 3500, NULL),
(24, 'Gerry Salut', 'Makanan Ringan', 100, 1000, NULL),
(25, 'Potato', 'Makanan Ringan', 85, 2000, NULL),
(26, 'Nabati Coklat', 'Makanan Ringan', 70, 2500, NULL),
(27, 'Waffelo', 'Makanan Ringan', 150, 2000, NULL),
(28, 'Kecap Abc', 'Bumbu masak', 100, 3000, NULL),
(29, 'Royko Ayam', 'Bumbu masak', 125, 500, NULL),
(30, 'Garam', 'Bumbu Masak', 150, 3000, NULL),
(31, 'Merica bubuk', 'Bumbu Masak', 120, 500, NULL),
(32, 'Bumbu Racik Nasgor', 'Bumbu Masak', 130, 3000, NULL),
(33, 'Gula Pasir', 'Bumbu Masak', 140, 3500, NULL),
(44, 'sasa ajinomoto', 'Bumbu Masak', 150, 2000, '7a23fb6eab9a87e178b6c7592b7a5de9.jpg'),
(45, 'Minyak', 'Bumbu Masak', 150, 150000, 'f9c3d594d0fd611023566c7c9ede545e.png'),
(46, 'Komputer', 'Elektronik', 150, 1000000, '0d1ef675f5e3366efe0ffdfbf8a10680.png'),
(47, 'KOMPUTER', 'Elektronik', 3, 5000, '92270e56cf1690846ee0f3595c49ab84.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `iduser` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`iduser`, `username`, `password`) VALUES
(1, 'admin', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detailpesanan`
--
ALTER TABLE `detailpesanan`
  ADD PRIMARY KEY (`iddetailpesanan`);

--
-- Indexes for table `masuk`
--
ALTER TABLE `masuk`
  ADD PRIMARY KEY (`idmasuk`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`idpelanggan`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`idorder`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`idproduk`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`iduser`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detailpesanan`
--
ALTER TABLE `detailpesanan`
  MODIFY `iddetailpesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `masuk`
--
ALTER TABLE `masuk`
  MODIFY `idmasuk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `idpelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `idorder` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=202300016;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `idproduk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `iduser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
