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
-- Table structure for table `downloadedfiles`
--

CREATE TABLE `downloadedfiles` (
  `filename` varchar(100) NOT NULL,
  `macIDofDownloader` varchar(12) NOT NULL,
  `macIDofUploader` varchar(12) NOT NULL,
  `filetitle` varchar(100) NOT NULL,
  `coursecode` varchar(4) NOT NULL,
  `description` varchar(200) NOT NULL,
  `download-number` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `upload_time` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
