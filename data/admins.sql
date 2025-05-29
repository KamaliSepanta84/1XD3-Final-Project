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
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `macID` varchar(200) NOT NULL,
  `username` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `course_code` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `macID`, `username`, `email`, `password`, `course_code`) VALUES
(1, 'johndoe', 'John Doe', 'johndoe@mcmaster.ca', '$2y$10$Uy0pxz3xTbZq8f5x.SOqqecXcpgnxeTDkwFUT5srf1CViKtzEICJy', '1XD3'),
(2, 'johndoe', 'John Doe', 'johndoe@mcmaster.ca', '$2y$10$Uy0pxz3xTbZq8f5x.SOqqecXcpgnxeTDkwFUT5srf1CViKtzEICJy', '1XC3'),
(3, 'scott52', 'samscott', 'scott52@mcmaster.ca', '$2y$10$Upg5s.7fC0R7wiASbEwmNefjTCnTVA3jhiUdYwf3Cn2PJn/bVpwYa', '1XD3'),
(4, 'johndoe', 'John Doe', 'johndoe@mcmaster.ca', '$2y$10$Uy0pxz3xTbZq8f5x.SOqqecXcpgnxeTDkwFUT5srf1CViKtzEICJy', '1MD3');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
