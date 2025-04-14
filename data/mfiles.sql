-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 14, 2025 at 08:09 AM
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
-- Database: `kamals19_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `mfiles`
--

CREATE TABLE `mfiles` (
  `id` int(11) NOT NULL,
  `macID` varchar(100) NOT NULL,
  `filename` varchar(200) NOT NULL,
  `filetitle` varchar(200) NOT NULL,
  `coursecode` varchar(100) NOT NULL,
  `filesize` int(11) NOT NULL,
  `filetype` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `rating` float NOT NULL DEFAULT 0,
  `download-number` int(11) NOT NULL DEFAULT 0,
  `upload_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mfiles`
--

INSERT INTO `mfiles` (`id`, `macID`, `filename`, `filetitle`, `coursecode`, `filesize`, `filetype`, `description`, `rating`, `download-number`, `upload_time`) VALUES
(70, 'kamals19', 'A4.pdf', 'Assignment 4', '1XC3', 173763, 'application/pdf', 'This is my assignment 4 for 1XC3', 0, 2, '2025-04-14 07:03:20'),
(71, 'pn', 'file1.txt', 'text file 1', '1P13', 3257, 'text/plain', 'thats my text file', 0, 6, '2025-04-14 10:58:17'),
(72, 'kamals19', 'Discrete-Math-Assignment-5.pdf', 'Discrete Math Assignment 5', '1DM3', 4973645, 'application/pdf', 'This is my answers for the discrete math assignment 5', 0, 1, '2025-04-14 12:04:22'),
(73, 'kamals19', 'Discrete-Math-Assignment-5.pdf', 'Discrete Math Assignment 5', '1DM3', 4973645, 'application/pdf', 'This is my answers for the discrete math assignment 5', 0, 1, '2025-04-14 12:06:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mfiles`
--
ALTER TABLE `mfiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `macID` (`macID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mfiles`
--
ALTER TABLE `mfiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
