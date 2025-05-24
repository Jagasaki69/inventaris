-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2025 at 06:23 PM
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
-- Database: `stockbarang`
--

-- --------------------------------------------------------

--
-- Table structure for table `bantuan_bencana`
--

CREATE TABLE `bantuan_bencana` (
  `id_bantuan` int(11) NOT NULL,
  `tanggal` date NOT NULL DEFAULT current_timestamp(),
  `jenis_bencana` varchar(100) NOT NULL,
  `lokasi_bencana` text NOT NULL,
  `penerima` varchar(50) NOT NULL,
  `kontak_penerima` varchar(15) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `status` varchar(15) NOT NULL DEFAULT 'Diproses'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detail_bantuan`
--

CREATE TABLE `detail_bantuan` (
  `id_detail` int(11) NOT NULL,
  `id_bantuan` int(11) DEFAULT NULL,
  `id_barang` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `keluar`
--

CREATE TABLE `keluar` (
  `idkeluar` int(11) NOT NULL,
  `idbarang` int(11) NOT NULL,
  `tanggal` timestamp(4) NOT NULL DEFAULT current_timestamp(4),
  `penerima` varchar(50) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `keluar`
--

INSERT INTO `keluar` (`idkeluar`, `idbarang`, `tanggal`, `penerima`, `qty`) VALUES
(2, 9, '0000-00-00 00:00:00.0000', 'pembeli', 10),
(3, 9, '2025-03-09 08:06:51.4449', 'pembeli', 50),
(4, 18, '2025-03-26 06:23:24.3257', 'pembeli', 6000),
(5, 19, '2025-03-26 06:28:52.6035', 'pembeli', 5000),
(8, 16, '2025-03-26 09:29:20.4882', 'pembeli', 50),
(11, 21, '2025-03-26 15:36:02.7103', 'joe', 50),
(12, 22, '2025-03-26 15:39:54.2438', 'joe', 50);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `iduser` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`iduser`, `email`, `password`) VALUES
(1, 'pak eko', '1234567');

-- --------------------------------------------------------

--
-- Table structure for table `masuk`
--

CREATE TABLE `masuk` (
  `idmasuk` int(11) NOT NULL,
  `idbarang` int(11) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp(),
  `jumlah` int(11) NOT NULL,
  `sumber` varchar(50) NOT NULL DEFAULT '''Input Stock Awal''',
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `masuk`
--

INSERT INTO `masuk` (`idmasuk`, `idbarang`, `tanggal`, `jumlah`, `sumber`, `qty`) VALUES
(26, 25, '2025-05-12 15:19:10', 15, 'Donasi', 0),
(27, 26, '2025-05-12 15:34:44', 12, 'Donasi', 0),
(28, 27, '2025-05-12 16:03:12', 12, 'Donasi', 0),
(29, 28, '2025-05-12 16:03:25', 13, 'Donasi', 0),
(30, 29, '2025-05-12 16:12:23', 12, 'Donasi', 0),
(31, 29, '2025-05-12 16:12:32', 13, 'Donasi', 0),
(32, 30, '2025-05-16 16:20:16', 12, 'Donasi', 0),
(33, 31, '2025-05-16 16:20:40', 13, 'Pembelian APBD', 0);

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `idbarang` int(11) NOT NULL,
  `namabarang` varchar(30) NOT NULL,
  `deskripsi` varchar(50) NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`idbarang`, `namabarang`, `deskripsi`, `stock`) VALUES
(30, 'pakaian anak laki laki', 'pakaian', 12),
(31, 'pakaian anak perempuan', 'pakaian', 13);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bantuan_bencana`
--
ALTER TABLE `bantuan_bencana`
  ADD PRIMARY KEY (`id_bantuan`);

--
-- Indexes for table `detail_bantuan`
--
ALTER TABLE `detail_bantuan`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_bantuan` (`id_bantuan`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indexes for table `keluar`
--
ALTER TABLE `keluar`
  ADD PRIMARY KEY (`idkeluar`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`iduser`);

--
-- Indexes for table `masuk`
--
ALTER TABLE `masuk`
  ADD PRIMARY KEY (`idmasuk`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`idbarang`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bantuan_bencana`
--
ALTER TABLE `bantuan_bencana`
  MODIFY `id_bantuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `detail_bantuan`
--
ALTER TABLE `detail_bantuan`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `keluar`
--
ALTER TABLE `keluar`
  MODIFY `idkeluar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `iduser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `masuk`
--
ALTER TABLE `masuk`
  MODIFY `idmasuk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `idbarang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_bantuan`
--
ALTER TABLE `detail_bantuan`
  ADD CONSTRAINT `detail_bantuan_ibfk_1` FOREIGN KEY (`id_bantuan`) REFERENCES `bantuan_bencana` (`id_bantuan`) ON DELETE CASCADE,
  ADD CONSTRAINT `detail_bantuan_ibfk_2` FOREIGN KEY (`id_barang`) REFERENCES `stock` (`idbarang`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
