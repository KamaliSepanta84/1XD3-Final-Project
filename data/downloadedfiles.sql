-- phpMyAdmin SQL Dump
-- version 5.2.2-1.el9
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 27, 2025 at 05:27 AM
-- Server version: 9.1.0-commercial
-- PHP Version: 8.2.25

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
-- Table structure for table `downloadedfiles`
--

CREATE TABLE `downloadedfiles` (
  `filename` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `macIDofDownloader` varchar(12) COLLATE utf8mb4_general_ci NOT NULL,
  `macIDofUploader` varchar(12) COLLATE utf8mb4_general_ci NOT NULL,
  `filetitle` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `coursecode` varchar(4) COLLATE utf8mb4_general_ci NOT NULL,
  `description` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `download-number` int NOT NULL,
  `rating` int NOT NULL,
  `upload_time` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `downloadedfiles`
--

INSERT INTO `downloadedfiles` (`filename`, `macIDofDownloader`, `macIDofUploader`, `filetitle`, `coursecode`, `description`, `download-number`, `rating`, `upload_time`) VALUES
('A4.pdf', 'kamals19', 'kamals19', 'Assignment 4 1XC3', '1XC3', 'This is my assignment 4 for the course CompSci 1XC3, which I got a 60% on.', 1, 3, '2025-04-27'),
('Discrete-Math-Assignment-5.pdf', 'kamals19', 'kamals19', 'Assignment 5 Discrete', '1DM3', 'This is my assignment 5 for the course discrete math, which I got a 100% on.', 1, 5, '2025-04-27'),
('Chapter3.pdf', 'maden', 'maden', 'Chapter 3 Discrete', '1DM3', 'This is a pdf of the chapter 3 of the discrete math textbook. I found it pretty useful.', 1, 5, '2025-04-27'),
('A4.pdf', 'maden', 'kamals19', 'Assignment 4 1XC3', '1XC3', 'This is my assignment 4 for the course CompSci 1XC3, which I got a 60% on.', 2, 3, '2025-04-27'),
('Discrete-Math-Assignment-5.pdf', 'maden', 'kamals19', 'Assignment 5 Discrete', '1DM3', 'This is my assignment 5 for the course discrete math, which I got a 100% on.', 2, 5, '2025-04-27'),
('file1.txt', 'maden', 'kamals19', 'Javascript Text File', '1XD3', 'This is just text of my javascript code, which I did for one of my assignments in winter 2025.', 1, 4, '2025-04-27'),
('Chapter3.pdf', 'kamals19', 'maden', 'Chapter 3 Discrete', '1DM3', 'This is a pdf of the chapter 3 of the discrete math textbook. I found it useful.', 2, 4, '2025-04-27'),
('AI and Data_kamals19.pdf', 'kamals19', 'maden', 'AI and Data', '1JC3', 'This is an essay for the course CompSci 1JC3, about AI and Data, which I got 80% on.', 1, 5, '2025-04-27'),
('Lecture02 Part1 - Copy.pdf', 'kamals19', 'kamals19', 'Chapter 1 Discrete', '1DM3', 'This is the chapter one of the discrete math textbook, and its easy.', 1, 5, '2025-04-27'),
('Assignment-3-Discrete-Math.pdf', 'kamals19', 'kamals19', 'Assignment 3 Discrete', '1DM3', 'This is my assignment 3 for the course discrete math, which I got a 90% on.', 1, 4, '2025-04-27'),
('Assignment3.pdf', 'kamals19', 'maden', 'Assignment 3 1XC3', '1XC3', 'This is my assignment 3 for the course CompSci 1XC3, which I got a 59% on.', 1, 4, '2025-04-27');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
