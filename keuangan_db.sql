-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 25, 2026 at 01:04 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `keuangan_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `dompet`
--

CREATE TABLE `dompet` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `tabungan` decimal(15,2) DEFAULT '0.00',
  `pengeluaran` decimal(15,2) DEFAULT '0.00',
  `pemasukan` decimal(15,2) DEFAULT '0.00',
  `dana_darurat` decimal(15,2) DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `dompet`
--

INSERT INTO `dompet` (`id`, `user_id`, `tabungan`, `pengeluaran`, `pemasukan`, `dana_darurat`) VALUES
(4, 4, '0.00', '5000.00', '0.00', '0.00'),
(5, 5, '0.00', '0.00', '0.00', '0.00'),
(6, 6, '500000.00', '350000.00', '3000000.00', '1000000.00'),
(7, 7, '0.00', '0.00', '0.00', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `judul` varchar(100) DEFAULT NULL,
  `tipe` varchar(50) DEFAULT NULL,
  `nominal` decimal(15,2) DEFAULT NULL,
  `tanggal` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `user_id`, `judul`, `tipe`, `nominal`, `tanggal`) VALUES
(10, 4, 'seblak', 'pengeluaran', '5000.00', '2026-04-29 02:39:30'),
(12, 6, 'gajian', 'pemasukan', '3000000.00', '2026-05-08 12:38:02'),
(13, 6, 'Bahan baku', 'pengeluaran', '250000.00', '2026-05-08 12:38:35'),
(14, 6, 'Kouta bulanan', 'pengeluaran', '100000.00', '2026-05-08 12:38:55'),
(17, 6, 'darurat', 'dana_darurat', '1000000.00', '2026-05-12 16:44:35'),
(18, 6, 'nabung', 'tabungan', '500000.00', '2026-05-12 16:44:53');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `nama_lengkap`) VALUES
(4, 'Admin Ganteng', 'admin.gan@gmail.com', '$2y$10$FNLaAVMBvG6O02AczOYILu1etzPirH6p7EIka2FjrTKGC.xlL6VDC', 'Admin Ganteng'),
(5, 'Dzikry', 'mantap@gmail.com', '$2y$10$wbI0TjsjbMqnmR9sC5zR1e.Q.hGANj2Xdpkqx1q22ta2oNPr6G8oO', 'Dzikry'),
(6, 'Afghaa', 'afghaa55@gmail.com', '$2y$10$IY8T/j9zszpEU/LR5Re62.1d9pbioBuF1cb.cHws4.wArMuQlnoIq', 'Afghaa'),
(7, 'Dzikry', 'afgha55@gmail.com', '$2y$10$14PfA2IpRdChP3CFTD8p3OM6O4jMVA6AfqIJDNI1mljAW0fWBfTee', 'Dzikry');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dompet`
--
ALTER TABLE `dompet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dompet`
--
ALTER TABLE `dompet`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dompet`
--
ALTER TABLE `dompet`
  ADD CONSTRAINT `dompet_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
