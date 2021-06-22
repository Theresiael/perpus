-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 22, 2021 at 10:18 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `perpus`
--

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `kd_buku` int(3) NOT NULL,
  `judul_buku` varchar(32) DEFAULT NULL,
  `pengarang` varchar(32) DEFAULT NULL,
  `penerbit` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`kd_buku`, `judul_buku`, `pengarang`, `penerbit`) VALUES
(1, '   tesbuku1', '   pengarang buku1', '   jumptes1'),
(2, ' tesbuku2', ' pengarang buku2', ' penerbit novel2'),
(3, 'harry potter and the prisoner of', 'jk rowling', 'penerbitan'),
(4, 'Pintar Bahasa Inggris', 'Bahasa', 'Pintar'),
(6, 'Matematika', 'matema', 'tika');

-- --------------------------------------------------------

--
-- Table structure for table `table_detail_login`
--

CREATE TABLE `table_detail_login` (
  `id_login` int(3) NOT NULL,
  `nama_depan` varchar(15) NOT NULL,
  `nama_belakang` varchar(15) NOT NULL,
  `email` varchar(15) NOT NULL,
  `telepon` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `table_detail_login`
--

INSERT INTO `table_detail_login` (`id_login`, `nama_depan`, `nama_belakang`, `email`, `telepon`) VALUES
(5, 'agatels', 'ti', 'agats@gmail.com', '081230000456'),
(6, 'tes1', 'tes', 'tes1@tes.com', '083278323412');

-- --------------------------------------------------------

--
-- Table structure for table `table_detail_pinjam`
--

CREATE TABLE `table_detail_pinjam` (
  `id_pinjam` int(3) NOT NULL,
  `tgl_pinjam` datetime NOT NULL,
  `tgl_kembali` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `table_detail_pinjam`
--

INSERT INTO `table_detail_pinjam` (`id_pinjam`, `tgl_pinjam`, `tgl_kembali`) VALUES
(2, '2021-06-23 04:00:14', '2021-06-23 04:00:46'),
(3, '2021-06-23 04:00:35', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `table_level`
--

CREATE TABLE `table_level` (
  `id_login` int(3) NOT NULL,
  `level` enum('admin','user') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `table_level`
--

INSERT INTO `table_level` (`id_login`, `level`) VALUES
(5, 'admin'),
(6, 'user');

-- --------------------------------------------------------

--
-- Table structure for table `table_login`
--

CREATE TABLE `table_login` (
  `id_login` int(3) NOT NULL,
  `username` varchar(10) NOT NULL,
  `password` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `table_login`
--

INSERT INTO `table_login` (`id_login`, `username`, `password`) VALUES
(5, 'agels', '11111'),
(6, 'tes1', '123');

-- --------------------------------------------------------

--
-- Table structure for table `table_pinjam`
--

CREATE TABLE `table_pinjam` (
  `id_pinjam` int(3) NOT NULL,
  `id_login` int(3) NOT NULL,
  `kd_buku` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `table_pinjam`
--

INSERT INTO `table_pinjam` (`id_pinjam`, `id_login`, `kd_buku`) VALUES
(2, 6, 1),
(3, 6, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`kd_buku`);

--
-- Indexes for table `table_detail_login`
--
ALTER TABLE `table_detail_login`
  ADD PRIMARY KEY (`id_login`);

--
-- Indexes for table `table_detail_pinjam`
--
ALTER TABLE `table_detail_pinjam`
  ADD PRIMARY KEY (`id_pinjam`);

--
-- Indexes for table `table_level`
--
ALTER TABLE `table_level`
  ADD KEY `table_detail_login_id_login_fk1` (`id_login`);

--
-- Indexes for table `table_login`
--
ALTER TABLE `table_login`
  ADD KEY `table_detail_login_id_login_fk` (`id_login`);

--
-- Indexes for table `table_pinjam`
--
ALTER TABLE `table_pinjam`
  ADD KEY `table_detail_pinjam_id_pinjam_fk` (`id_pinjam`),
  ADD KEY `table_detail_login_id_login_fk2` (`id_login`),
  ADD KEY `buku_kd_buku_fk` (`kd_buku`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buku`
--
ALTER TABLE `buku`
  MODIFY `kd_buku` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `table_detail_login`
--
ALTER TABLE `table_detail_login`
  MODIFY `id_login` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `table_detail_pinjam`
--
ALTER TABLE `table_detail_pinjam`
  MODIFY `id_pinjam` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `table_level`
--
ALTER TABLE `table_level`
  ADD CONSTRAINT `table_detail_login_id_login_fk1` FOREIGN KEY (`id_login`) REFERENCES `table_detail_login` (`id_login`);

--
-- Constraints for table `table_login`
--
ALTER TABLE `table_login`
  ADD CONSTRAINT `table_detail_login_id_login_fk` FOREIGN KEY (`id_login`) REFERENCES `table_detail_login` (`id_login`);

--
-- Constraints for table `table_pinjam`
--
ALTER TABLE `table_pinjam`
  ADD CONSTRAINT `buku_kd_buku_fk` FOREIGN KEY (`kd_buku`) REFERENCES `buku` (`kd_buku`),
  ADD CONSTRAINT `table_detail_login_id_login_fk2` FOREIGN KEY (`id_login`) REFERENCES `table_detail_login` (`id_login`),
  ADD CONSTRAINT `table_detail_pinjam_id_pinjam_fk` FOREIGN KEY (`id_pinjam`) REFERENCES `table_detail_pinjam` (`id_pinjam`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
