-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2025 at 04:00 AM
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

--
-- Dumping data for table `bantuan_bencana`
--

INSERT INTO `bantuan_bencana` (`id_bantuan`, `tanggal`, `jenis_bencana`, `lokasi_bencana`, `penerima`, `kontak_penerima`, `keterangan`, `status`) VALUES
(1, '2025-05-11', 'longsor', 'menawan rt4 rw3 samping jembatan pringgondani ', 'pak narto', '097412351234', NULL, 'Diproses');

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

--
-- Dumping data for table `detail_bantuan`
--

INSERT INTO `detail_bantuan` (`id_detail`, `id_bantuan`, `id_barang`, `jumlah`) VALUES
(1, 1, 22, 4);

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
  `keterangan` varchar(25) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `masuk`
--

INSERT INTO `masuk` (`idmasuk`, `idbarang`, `tanggal`, `keterangan`, `qty`) VALUES
(4, 7, '2025-03-03 03:20:39', 'joe', 145),
(5, 7, '2025-03-03 03:21:57', 'joe', 123),
(7, 6, '2025-03-03 03:24:01', 'joe', 12),
(8, 9, '2025-03-04 06:51:34', 'joe', 4),
(9, 9, '2025-03-04 06:51:44', 'joe', 1),
(10, 9, '2025-03-09 03:25:50', 'munis', 100),
(11, 9, '2025-03-09 03:26:37', 'munarman', 4),
(21, 14, '2025-03-24 06:07:19', 'pembeli', 100),
(22, 14, '2025-03-24 06:15:00', 'munis', 100),
(24, 14, '2025-03-26 15:48:09', 'joe', 100);

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
(14, 'oppo find x', 'smartphone', 650),
(15, 'Iphone 16 Pro Max', 'handphone', 100),
(16, 'iphone 16', 'handphone', 50),
(22, 'beras bunga', 'makanan', 146);

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
  MODIFY `idmasuk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `idbarang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

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
