-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 27, 2025 at 05:57 AM
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
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `filename` varchar(200) NOT NULL,
  `macID` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`filename`, `macID`) VALUES
('A4.pdf', 'kamals19'),
('A4.pdf', 'maden'),
('AI and Data_kamals19.pdf', 'maden'),
('Assignment-3-Discrete-Math.pdf', 'kamals19'),
('Assignment1.pdf', 'kamals19'),
('Assignment3.pdf', 'maden'),
('Chapter3.pdf', 'kamals19'),
('Chapter3.pdf', 'maden'),
('childsmath.png', 'kamals19'),
('Discrete-Math-Assignment-5.pdf', 'kamals19'),
('Discrete-Math-Assignment-5.pdf', 'maden'),
('file1.txt', 'kamals19'),
('file1.txt', 'maden'),
('[Book] Discrete mathematics and its applications (2019)_0.pdf', 'maden');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`filename`,`macID`),
  ADD KEY `macID` (`macID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_ibfk_1` FOREIGN KEY (`filename`) REFERENCES `mfiles` (`filename`),
  ADD CONSTRAINT `ratings_ibfk_2` FOREIGN KEY (`macID`) REFERENCES `users` (`macID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
