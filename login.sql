-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2021 at 10:22 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `login`
--

-- --------------------------------------------------------

--
-- Table structure for table `datalogin`
--

CREATE TABLE `datalogin` (
  `id` int(3) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `datalogin`
--

INSERT INTO `datalogin` (`id`, `username`, `password`) VALUES
(1, 'aulafajrun', '12311'),
(2, 'aulafajrun', 'aulafajrun44'),
(3, 'arul', 'arul1709'),
(4, 'arul11', 'arlqwe'),
(5, 'aulafajrun123', '12311123'),
(6, 'aulafajrun', 'arul1709'),
(7, 'dina', 'hehe'),
(8, 'fir', '12345'),
(9, 'firman12', 'fir123'),
(10, 'firnanda', 'nanda123'),
(11, 'diadanaku', '123qweq'),
(12, 'gino', 'ismail12'),
(13, 'eka23', '12345'),
(14, 'aulafajrun22', '22222'),
(15, 'arul44', '0266e268a73acee'),
(16, 'aula44', 'e10e94bdc6d9850'),
(17, 'aula1709', 'indonesia'),
(18, 'aulafj', 'asembagus'),
(19, 'arul231', 'arul231'),
(20, 'arul098', 'arul098'),
(21, 'aulahaha', 'aulahaha'),
(22, 'davidsi', 'davidsi'),
(23, 'pratama11', 'pratama11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `datalogin`
--
ALTER TABLE `datalogin`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `datalogin`
--
ALTER TABLE `datalogin`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
