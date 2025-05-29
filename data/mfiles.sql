-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 30, 2025 at 12:50 AM
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
-- Database: `kosoricm_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `mfiles`
--

CREATE TABLE `mfiles` (
  `macID` varchar(100) NOT NULL,
  `filename` varchar(200) NOT NULL,
  `filetitle` varchar(200) NOT NULL,
  `coursecode` varchar(100) NOT NULL,
  `filesize` int(11) NOT NULL,
  `filetype` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `download-number` int(11) NOT NULL DEFAULT 0,
  `upload_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `rating1` int(11) NOT NULL DEFAULT 0,
  `rating2` int(11) NOT NULL DEFAULT 0,
  `rating3` int(11) NOT NULL DEFAULT 0,
  `rating4` int(11) NOT NULL DEFAULT 0,
  `rating5` int(11) NOT NULL DEFAULT 0,
  `count` int(11) NOT NULL DEFAULT 0,
  `rating` float NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mfiles`
--

INSERT INTO `mfiles` (`macID`, `filename`, `filetitle`, `coursecode`, `filesize`, `filetype`, `description`, `download-number`, `upload_time`, `rating1`, `rating2`, `rating3`, `rating4`, `rating5`, `count`, `rating`) VALUES
('kosoricm', 'assignment4 (1) (2).pdf', 'Assignment 4', '1MD3', 90761, 'application/pdf', 'hi jy ane', 0, '2025-05-30 04:16:08', 0, 0, 0, 0, 0, 0, 0),
('johndoe', 'Comp Sci Application Marko Kosoric (2) (2).pdf', 'comp sci app for 1xd3', '1XD3', 43142, 'application/pdf', '', 0, '2025-05-29 09:53:53', 0, 0, 0, 0, 0, 0, 0),
('johndoe', 'MCMASTER ATHLETICS & RECREATION.pdf', 'Contract', '1xc3', 30291097, 'application/pdf', '', 0, '2025-05-29 09:54:10', 0, 0, 0, 0, 0, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mfiles`
--
ALTER TABLE `mfiles`
  ADD PRIMARY KEY (`filename`),
  ADD KEY `macID` (`macID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
